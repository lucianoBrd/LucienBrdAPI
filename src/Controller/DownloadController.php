<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use App\Service\UserService;
use App\Service\LocalGenerator;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DownloadController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }
    
    /**
     * @Route("/download/{local}", name="download")
     */
    public function index($local, EntityManagerInterface $manager, \Swift_Mailer $mailer, Request $request)
    {
        $userService = new UserService($manager);

        $error = true;

        if ($request->getMethod() == 'POST' && !$this->localGenerator->checkLocal($local)) {

            $postData = json_decode($request->getContent(), true);

            if (isset($postData['captcha']) && isset($postData['name']) && isset($postData['mail']) && isset($postData['file'])) {

                $captcha = htmlspecialchars($postData['captcha']);
                $name = htmlspecialchars($postData['name']);
                $mail = htmlspecialchars($postData['mail']);
                $file = htmlspecialchars($postData['file']);

                /* Remove all illegal characters from mail */
                $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

                /* Check file + file exist */
                $f = null;
                if ($file && !empty($file)) {
                    $repository = $manager->getRepository(File::class);
                    $f = $repository->findOneBy(['file' => $file]);
                }

                /* Check captcha */
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $_ENV['PRIVATE_KEY'] . '&response=' . $captcha);
                $resp = json_decode($verifyResponse);

                if ($resp != null && $resp->success &&
                    $name && !empty($name) &&
                    $mail && !empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL) &&
                    $f
                ) {
                    /* Save User + Message */
                    $user = new User();

                    $user->setName($name)
                        ->setMail($mail);

                    $userService->addUser($user);

                    /* Create messages */
                    $title = $this->localGenerator->getDownload($local) . $file;
                    $message = (new \Swift_Message($title))
                        ->setFrom('lucien.burdet@gmail.com')
                        ->setTo($mail)
                        ->setBody(
                            $this->renderView(
                                'emails/base.html.twig',
                                [
                                    'local' => $local,
                                    'title' => $title,
                                    'clientPath' => $this->getParameter('app.client.url'),
                                    'emailPath' => $this->getParameter('app.assets.email'),
                                    'banner' => 'download',
                                    'h1' => [
                                        'hello' => $this->localGenerator->getHello($local),
                                        'name' => $name,
                                    ],
                                    'h3' => $title,
                                    'paragraphs' => $this->localGenerator->getFile($local, $f),
                                    'button' => [
                                        'url' => $this->getParameter('app.assets.documents.download') . $f->getFile(), 
                                        'title' => $this->localGenerator->getDownload($local),
                                    ],
                                    'question' => $this->localGenerator->getQuestion($local),
                                    'contact' => $this->localGenerator->getContact($local),
                                ]
                            ),
                            'text/html'
                    );

                    try {
                        $mailer->send($message);
                        $error = false;
                    } catch (\Swift_TransportException $Ste) {
                        $error = true;
                    }
                }
            }
        }

        return $this->json([
            'error' => $error,
        ]);
    }
}
