<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class RegistrationManager
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createUser(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}