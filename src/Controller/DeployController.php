<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeployController extends AbstractController
{
    /**
     * @Route("/deploy", name="deploy")
     */
    public function index()
    {
        $commands = array(
            'git pull',
            'git status',
            'php ../bin/console cache:clear --no-warmup --env=prod',
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

        return $this->json([
            $output
        ]);
    }
}
