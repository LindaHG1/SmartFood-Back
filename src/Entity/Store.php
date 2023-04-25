<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoreRepository::class)]
class Store
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $instagram = null;

    #[ORM\Column(length: 255)]
    private ?string $facebook = null;

    #[ORM\Column(length: 255)]
    private ?string $youtube = null;

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: SocialMedia::class)]
    private Collection $social;

    #[ORM\Column(length: 5000)]
    private ?string $aboutus = null;

    public function __construct()
    {
        $this->social = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getId();
    }
    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * @return Collection<int, SocialMedia>
     */
    public function getSocial(): Collection
    {
        return $this->social;
    }

    public function addSocial(SocialMedia $social): self
    {
        if (!$this->social->contains($social)) {
            $this->social->add($social);
            $social->setStore($this);
        }

        return $this;
    }

    public function removeSocial(SocialMedia $social): self
    {
        if ($this->social->removeElement($social)) {
            // set the owning side to null (unless already changed)
            if ($social->getStore() === $this) {
                $social->setStore(null);
            }
        }

        return $this;
    }

    public function getAboutus(): ?string
    {
        return $this->aboutus;
    }

    public function setAboutus(string $aboutus): self
    {
        $this->aboutus = $aboutus;

        return $this;
    }
}
