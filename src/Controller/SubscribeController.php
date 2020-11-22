<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\MailService;
use App\Service\UserService;
use App\Service\LocalGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscribeController extends AbstractController
{
    private $localGenerator;
    private $mailService;

    public function __construct(LocalGenerator $localGenerator, MailService $mailService)
    {
        $this->localGenerator = $localGenerator;
        $this->mailService = $mailService;
    }

    /**
     * @Route("/subscribe/{local}/{mail}", name="subscribe")
     */
    public function subscribe($local, $mail, EntityManagerInterface $manager, \Swift_Mailer $mailer, Request $request)
    {
        $userService = new UserService($manager);

        $error = true;

        if (!$this->localGenerator->checkLocal($local)) {

            /* Remove all illegal characters from mail */
            $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

            if ($mail && !empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                /* Save User */
                $user = new User();

                $user->setMail($mail);

                $user = $userService->addUser($user, true);

                /* Create message */
                $title = $this->localGenerator->getThankSubscribe($local);
                $message = $this->mailService->getMessageView(
                    $title,
                    $local,
                    'subscribe',
                    ($user->getName() ? $user->getName() : $mail),
                    [],
                    [
                        'url' => $this->getParameter('app.client.url') . '/blog',
                        'title' => $this->localGenerator->getSeeBlog($local),
                    ],
                    $user->getSecret()
                );

                /* Send message */
                $error = $this->mailService->sendMessage(
                    $mail,
                    $title,
                    $message
                );
            }
        }

        return $this->json([
            'error' => $error,
        ]);
    }

    /**
     * @Route("/unsubscribe/{local}/{secret}", name="unsubscribe")
     */
    public function unsubscribe($local, $secret, EntityManagerInterface $manager, Request $request)
    {
        $userService = new UserService($manager);

        $repository = $manager->getRepository(User::class);
        $user = $repository->findOneBy(['secret' => $secret]);

        if (!$this->localGenerator->checkLocal($local) && $user) {
            $user->setSubscribe(false);
            $manager->persist($user);
            $manager->flush();

            $title = $this->localGenerator->getUnsubscribeSuccess($local);

            return $this->render(
                'emails/base.html.twig',
                [
                    'local' => $local,
                    'title' => $title,
                    'clientPath' => $this->getParameter('app.client.url'),
                    'emailPath' => $this->getParameter('app.assets.email'),
                    'banner' => 'unsubscribe',
                    'h1' => [
                        'hello' => $this->localGenerator->getHello($local),
                        'name' => ($user->getName() ? $user->getName() : $user->getMail()),
                    ],
                    'h3' => $title,
                    'paragraphs' => [],
                    'button' => [
                        'url' => $this->getParameter('app.url') . '/subscribe/' . $local . '/' . $user->getMail(),
                        'title' => $this->localGenerator->getSubscribe($local),
                    ],
                    'question' => $this->localGenerator->getQuestion($local),
                    'contact' => $this->localGenerator->getContact($local),
                    'unsubscribe' => $this->localGenerator->getUnsubscribe($local),
                    'unsubscribePath' => null,
                ]
            );
        }

        return $this->json([
            'error' => true,
        ]);

    }
}
