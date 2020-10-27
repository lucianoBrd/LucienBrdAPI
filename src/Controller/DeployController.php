<?php

namespace App\Controller;

use App\Service\DatabaseGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeployController extends AbstractController
{
    /**
     * @Route("/deploy", name="deploy")
     */
    public function index(KernelInterface $kernel)
    {
        $commands = array(
            'git pull',
            'git status',
        );
        
        $i = 0;
        $output = [];
        foreach($commands as $command){
            /* Run command */
            $tmp = shell_exec($command);
            /* Output */
            $output[$i]['command'] = $command; 
            $output[$i]['result'] = htmlentities(trim($tmp));
            $i++;
        }

        /* Clear cache */
        $output[$i]['command'] = 'cache:clear';
        $output[$i]['result'] = $this->do_command($kernel, 'cache:clear');

        /* Update database */
        $dbGenerator = new DatabaseGenerator($this->getDoctrine()->getManager());
        $dbGenerator->updateDatabase();

        return $this->json([
            $output
        ]);
    }

    private function do_command($kernel, $command)
    {
        $env = $kernel->getEnvironment();

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array(
            'command' => $command,
            '--env' => $env
        ));

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();

        return $content;
    }
}
