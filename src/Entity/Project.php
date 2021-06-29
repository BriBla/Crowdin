<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->Source = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langage;

    /**
     * @ORM\OneToMany(targetEntity=Source::class, mappedBy="Project", orphanRemoval=true)
     */
    private $Source;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="project")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $block = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    /**
     * @return Collection|Source[]
     */
    public function getSource(): Collection
    {
        return $this->Source;
    }

    public function addSource(Source $Source): self
    {
        if (!$this->Source->contains($Source)) {
            $this->Source[] = $Source;
            $Source->setProject($this);
        }

        return $this;
    }

    public function removeSource(Source $Source): self
    {
        if ($this->Source->removeElement($Source)) {
            // set the owning side to null (unless already changed)
            if ($Source->getProject() === $this) {
                $Source->setProject(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBlock(): ?int
    {
        return $this->block;
    }

    public function setBlock(int $block): self
    {
        $this->block = $block;

        return $this;
    }
}