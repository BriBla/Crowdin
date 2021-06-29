<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Source;
use App\Entity\Project;
use App\Entity\Traduction;

class ProjectManager
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createSource(Source $source)
    {
        $this->em->persist($source);
    }

    public function createSourceOnly(Source $source)
    {
        $this->em->persist($source);
        $this->em->flush();
    }

    public function valideSource()
    {
        $this->em->flush();
    }

    public function createProject(Project $project)
    {
        $this->em->persist($project);
        $this->em->flush();
    }
    public function createTraduction(Traduction $traduction)
    {
        $this->em->persist($traduction);
        $this->em->flush();
    }
    public function deleteProject(Project $project)
    {
        $this->em->remove($project);
        $this->em->flush();
    }
}
