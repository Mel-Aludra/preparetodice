<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private ?string $light;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private ?string $dark;

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

    public function getLight(): ?string
    {
        return $this->light;
    }

    public function setLight(string $light): self
    {
        $this->light = $light;

        return $this;
    }

    public function getDark(): ?string
    {
        return $this->dark;
    }

    public function setDark(string $dark): self
    {
        $this->dark = $dark;

        return $this;
    }
}
