<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\UserLangue;

class UserLangManager
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createUserLang(UserLangue $userLangue)
    {
        $this->em->persist($userLangue);
        $this->em->flush();
    }
}