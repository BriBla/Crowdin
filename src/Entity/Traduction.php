<?php

namespace App\Entity;

use App\Repository\TraductionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraductionRepository::class)
 */
class Traduction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Project;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sourcekey;

    /**
     * @ORM\Column(type="text")
     */
    private $translation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->Project;
    }

    public function setProject(?Project $Project): self
    {
        $this->Project = $Project;

        return $this;
    }

    public function getSourcekey(): ?string
    {
        return $this->sourcekey;
    }

    public function setSourcekey(string $sourcekey): self
    {
        $this->sourcekey = $sourcekey;

        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    public function getLangage(): ?string
    {
        return $this->langage;
    }

    public function setLangage(string $langage): self
    {
        $this->langage = $langage;

        return $this;
    }
}
