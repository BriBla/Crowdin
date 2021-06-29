<?php

namespace App\Entity;

use App\Repository\UserLangueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserLangueRepository::class)
 * @UniqueEntity(
 *     fields={"langue_name"},
 *     message="Vous avez déjà selectionné cette langue."
 * )
 */
class UserLangue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="langue_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\Column(type="string")
     */
    private $langue_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getLangueName(): ?string
    {
        return $this->langue_name;
    }

    public function setLangueName(string $langue_name): self
    {
        $this->langue_name = $langue_name;

        return $this;
    }
}
