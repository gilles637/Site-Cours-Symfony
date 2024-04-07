<?php

namespace App\Entity;

use App\Repository\LeconRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LeconRepository::class),
    ORM\HasLifecycleCallbacks]
class Lecon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(min:1, max:30)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'lecons')]
    private ?User $professeur = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'mesLecons')]
    private Collection $eleves;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getProfesseur(): ?User
    {
        return $this->professeur;
    }

    public function setProfesseur(?User $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PreUpdate,ORM\PrePersist]
    public function updatedTimestamps(): void
    {
        $timezone = new \DateTimeZone('Europe/Paris');

        if($this->getCreatedAt()==null){
            $this->setCreatedAt(new \DateTimeImmutable("now", $timezone));
        }
        $this->setUpdatedAt(new \DateTimeImmutable("now", $timezone));
    }

    /**
     * @return Collection<int, User>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(User $elefe): static
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
        }

        return $this;
    }

    public function removeElefe(User $elefe): static
    {
        $this->eleves->removeElement($elefe);

        return $this;
    }
}
