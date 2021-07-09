<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_infos"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"show_infos"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"show_infos"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=14)
     * @Groups({"show_infos"})
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="client", cascade={"persist", "remove"})
     * @Groups({"show_infos"})
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"show_infos"})
     */
    private $newsletter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setClient(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getClient() !== $this) {
            $user->setClient($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->getUser()->getClient()->getNom().' '.$this->getUser()->getClient()->getPrenom().' '.$this->getUser()->getClient()->getPhone();
    }
}
