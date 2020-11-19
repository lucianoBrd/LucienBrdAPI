<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Service\LocalGenerator;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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
    public function index($local, EntityManagerInterface $manager, MailerInterface $mailer, Request $request)
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
                $pathFile = '../src/Download/';
                $fileError = true;
                if ($file && !empty($file) && file_exists($pathFile . $file)) {
                    $pathFile = $pathFile . $file;
                    $fileError = false;
                }

                /* Check captcha */
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $_ENV['PRIVATE_KEY'] . '&response=' . $captcha);
                $resp = json_decode($verifyResponse);

                if ($resp != null && $resp->success &&
                    $name && !empty($name) &&
                    $mail && !empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL) &&
                    !$fileError
                ) {
                    /* Save User + Message */
                    $user = new User();

                    $user->setName($name)
                        ->setMail($mail);

                    $userService->addUser($user);

                    /* Create message */
                    $html = $this->localGenerator->getMessageFile($local, $name, $file);

                    /* Get signature */
                    $signature = '';
                    $f = fopen('../public/assets/email/mail.html', 'r');
                    while (!feof($f)) {
                        $result = fgets($f);
                        $signature .= $result;
                    }
                    fclose($f);

                    $html .= $signature;
                    $html .= '<br>';

                    $email = (new Email())
                        ->from(Address::fromString('Lucien Burdet <no-reply@lucien-brd.com>'))
                        ->to(new Address($mail))
                        ->subject($this->localGenerator->getSubjectFile($local, $file))
                        ->html($html)
                        ->attachFromPath($pathFile);
                    try {
                        $mailer->send($email);
                        $error = false;
                    } catch (TransportExceptionInterface $e) {
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
