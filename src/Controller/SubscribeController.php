<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\LocalGenerator;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
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

                $userService->addUser($user, true);

                /* Create message */
                $title = $this->localGenerator->getThankSubscribe($local);
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
                                'banner' => 'subscribe',
                                'h1' => [
                                    'hello' => $this->localGenerator->getHello($local),
                                    'name' => ($user->getName() ? $user->getName() : $mail),
                                ],
                                'h3' => $title,
                                'paragraphs' => [],
                                'button' => [
                                    'url' => $this->getParameter('app.client.url') . '/blog',
                                    'title' => $this->localGenerator->getSeeBlog($local),
                                ],
                                'question' => $this->localGenerator->getQuestion($local),
                                'contact' => $this->localGenerator->getContact($local),
                                'unsubscribe' => $this->localGenerator->getUnsubscribe($local),
                                'unsubscribePath' => $this->getParameter('app.url') . '/unsubscribe/' . $local . '/' . $user->getSecret(),
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

            $title = $this->localGenerator->getUnsubscribeSuccess($local);

            return $this->renderView(
                'emails/base.html.twig',
                [
                    'local' => $local,
                    'title' => $title,
                    'clientPath' => $this->getParameter('app.client.url'),
                    'emailPath' => $this->getParameter('app.assets.email'),
                    'banner' => 'unsubscribe',
                    'h1' => [
                        'hello' => $this->localGenerator->getHello($local),
                        'name' => ($user->getName() ? $user->getName() : $mail),
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
