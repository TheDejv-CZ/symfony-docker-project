<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'user')]
    private Collection $posts;
    #[ORM\OneToMany(targetEntity: UserInfo::class, mappedBy: 'user')]
    private Collection $info;
    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->info = new ArrayCollection();
        $this->DateCreated = new \DateTime();
    }
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $Name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $DateCreated;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column(length: 100)]
    private ?string $Username = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Website = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->Name;
    }
    public function setName(string $Name): static
    {
        $this->Name = $Name;
        return $this;
    }
    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->DateCreated;
    }
    public function setDateCreated(\DateTimeInterface $DateCreated): static
    {
        $this->DateCreated = $DateCreated;
        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }
    public function getPosts(): Collection
    {
        return $this->posts;
    }
    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setUser($this);
        }
        return $this;
    }
    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }
        return $this;
    }
    public function getInfo(): Collection
    {
        return $this->info;
    }
    public function addInfo(UserInfo $info): self
    {
        if (!$this->info->contains($info)) {
            $this->info->add($info);
            $info->setUser($this);
        }
        return $this;
    }
    public function removeInfo(UserInfo $info): self
    {
        if ($this->info->removeElement($info)) {
            if ($info->getUser() === $this) {
                $info->setUser(null);
            }
        }
        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->Username;
    }
    public function setUsername(string $Username): static
    {
        $this->Username = $Username;
        return $this;
    }
    public function getPhone(): ?string
    {
        return $this->Phone;
    }
    public function setPhone(?string $Phone): static
    {
        $this->Phone = $Phone;
        return $this;
    }
    public function getWebsite(): ?string
    {
        return $this->Website;
    }
    public function setWebsite(?string $Website): static
    {
        $this->Website = $Website;
        return $this;
    }
}
