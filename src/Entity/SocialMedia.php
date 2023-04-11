<?php

namespace App\Entity;

use App\Repository\SocialMediaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocialMediaRepository::class)]
class SocialMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameicon = null;

    #[ORM\Column(length: 255)]
    private ?string $linkicon = null;

    #[ORM\ManyToOne(inversedBy: 'social')]
    private ?Store $store = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameicon(): ?string
    {
        return $this->nameicon;
    }

    public function setNameicon(string $nameicon): self
    {
        $this->nameicon = $nameicon;

        return $this;
    }

    public function getLinkicon(): ?string
    {
        return $this->linkicon;
    }

    public function setLinkicon(string $linkicon): self
    {
        $this->linkicon = $linkicon;

        return $this;
    }
    public function __toString()
    {
        return $this->getLinkicon();
    }
    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }
}
