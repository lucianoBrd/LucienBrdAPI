<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use App\Service\MailService;
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
    private $mailService;

    public function __construct(LocalGenerator $localGenerator, MailService $mailService)
    {
        $this->localGenerator = $localGenerator;
        $this->mailService = $mailService;
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

                if ($this->mailService->checkCaptcha($captcha) &&
                    $name && !empty($name) &&
                    $mail && !empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL) &&
                    $f
                ) {
                    /* Save User + Message */
                    $user = new User();

                    $user->setName($name)
                        ->setMail($mail);

                    $user = $userService->addUser($user);

                    /* Create message */
                    $title = $this->localGenerator->getDownload($local) . ' ' . $file;
                    $message = $this->mailService->getMessageView(
                        $title,
                        $local,
                        'download',
                        $name,
                        $this->localGenerator->getFile($local, $f),
                        [
                            'url' => $this->getParameter('app.assets.documents.download') . $f->getFile(), 
                            'title' => $this->localGenerator->getDownload($local),
                        ],
                        $user->getSecret()
                    );

                    /* Send message */
                    $error = $this->mailService->sendMessage(
                        [
                            'to' => $mail,
                            'title' => $title,
                            'm' => $message
                        ]
                    );
                }
            }
        }

        return $this->json([
            'error' => $error,
        ]);
    }
}
