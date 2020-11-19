<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserService
{
    private $manager;
    private $images;
    private $length;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->images = [
            'user.webp',
            'businessman.webp',
            'customer.webp',
            'employee.webp',
            'manager.webp',
            'scientist.webp',
        ];

        $this->length = sizeof($this->images);
    }

    private function getRandomImage() {
        return $this->images[rand(0, ($this->length - 1))];
    }

    public function addUser($user): User
    {
        $repository = $this->manager->getRepository(User::class);

        /* Check if user exist */
        $u = $repository->findOneBy(['mail' => $user->getMail()]);

        if ($u) {
            $messages = $user->getMessages();
            foreach ($messages as $message) {
                $this->manager->persist($message);
                $u->addMessage($message);
            }

            $this->manager->persist($u);
            $user = $u;

        } else {
            $messages = $user->getMessages();
            foreach ($messages as $message) {
                $this->manager->persist($message);
            }
            $user->setImage($this->getRandomImage());
            $this->manager->persist($user);
        }

        $this->manager->flush();

        return $user;

    }
}
