<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserService
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function addUser($user): User
    {
        $repository = $this->manager->getRepository(User::class);

        /* Check if user exist */
        $u = $repository->findOneBy(['mail' => $user->getMail()]);

        if ($u) {
            $messages = $user->getMessages();
            foreach ($messages as $message) {
                $u->addMessage($message);
            }

            $this->manager->persist($u);
            $user = $u;

        } else {
            $this->manager->persist($user);
        }

        $this->manager->flush();

        return $user;

    }
}
