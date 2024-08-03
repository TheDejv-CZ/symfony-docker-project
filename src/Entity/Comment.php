<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5000)]
    private ?string $Body = null;
    
    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    #[ORM\Column(length: 100)]
    private ?string $Name = null;

    #[ORM\Column(length: 150)]
    private ?string $Email = null;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getBody(): ?string
    {
        return $this->Body;
    }
    public function setBody(string $Body): static
    {
        $this->Body = $Body;
        return $this;
    }
    public function getPost(): ?Post
    {
        return $this->post;
    }
    public function setPost(?Post $post): self
    {
        $this->post = $post;
        return $this;
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
    public function getEmail(): ?string
    {
        return $this->Email;
    }
    public function setEmail(string $Email): static
    {
        $this->Email = $Email;
        return $this;
    }
}
