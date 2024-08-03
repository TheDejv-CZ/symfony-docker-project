<?php

namespace App\Entity;

use App\Repository\UserInfoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserInfoRepository::class)]
class UserInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Street = null;

    #[ORM\Column(length: 100)]
    private ?string $Suite = null;

    #[ORM\Column(length: 100)]
    private ?string $City = null;

    #[ORM\Column(length: 50)]
    private ?string $ZipCode = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $sLat = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $sLng = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $CompanyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $CompanyCatchPhrase = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $CompanyBs = null;
    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getStreet(): ?string
    {
        return $this->Street;
    }
    public function setStreet(string $Street): static
    {
        $this->Street = $Street;
        return $this;
    }
    public function getSuite(): ?string
    {
        return $this->Suite;
    }
    public function setSuite(string $Suite): static
    {
        $this->Suite = $Suite;
        return $this;
    }
    public function getCity(): ?string
    {
        return $this->City;
    }
    public function setCity(string $City): static
    {
        $this->City = $City;
        return $this;
    }
    public function getZipCode(): ?string
    {
        return $this->ZipCode;
    }
    public function setZipCode(string $ZipCode): static
    {
        $this->ZipCode = $ZipCode;
        return $this;
    }
    public function getSLat(): ?string
    {
        return $this->sLat;
    }
    public function setSLat(?string $sLat): static
    {
        $this->sLat = $sLat;
        return $this;
    }
    public function getSLng(): ?string
    {
        return $this->sLng;
    }
    public function setSLng(?string $sLng): static
    {
        $this->sLng = $sLng;
        return $this;
    }
    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }
    public function setCompanyName(?string $CompanyName): static
    {
        $this->CompanyName = $CompanyName;
        return $this;
    }
    public function getCompanyCatchPhrase(): ?string
    {
        return $this->CompanyCatchPhrase;
    }
    public function setCompanyCatchPhrase(?string $CompanyCatchPhrase): static
    {
        $this->CompanyCatchPhrase = $CompanyCatchPhrase;
        return $this;
    }
    public function getCompanyBs(): ?string
    {
        return $this->CompanyBs;
    }
    public function setCompanyBs(?string $CompanyBs): static
    {
        $this->CompanyBs = $CompanyBs;
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
}
