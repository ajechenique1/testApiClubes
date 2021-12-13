<?php

namespace App\Entity;

use App\Repository\ClubesRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=ClubesRepository::class)
 */
class Clubes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=2)
     */
    private $totalBudget;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=2)
     */
    private $disponibleBudget;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;
    
    /**
     * @ORM\OneToMany(targetEntity=Jugadores::class, mappedBy="Clubes")
     */
    private $jugadores;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function __construct()
    {
        $this->jugadores = new ArrayCollection();
    }

    /**
     * @return Collection|Jugadores[]
     */
    public function getJugadores(): Collection
    {
        return $this->jugadores;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTotalBudget(): ?string
    {
        return $this->totalBudget;
    }

    public function setTotalBudget(string $totalBudget): self
    {
        $this->totalBudget = $totalBudget;

        return $this;
    }

    public function getDisponibleBudget(): ?string
    {
        return $this->disponibleBudget;
    }

    public function setDisponibleBudget(string $disponibleBudget): self
    {
        $this->disponibleBudget = $disponibleBudget;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }
    
}
