<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostsRepository")
 */
class Posts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PostTypes", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Courses", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PostsLikesDislikes", mappedBy="post", cascade={"persist", "remove"})
     */
    private $likesDislikes;

    /**
     * @ORM\Column(type="text")
     */
    private $data;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?PostTypes
    {
        return $this->type;
    }

    public function setType(?PostTypes $type): self
    {
        $this->type = $type;

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

    public function getCourse(): ?Courses
    {
        return $this->course;
    }

    public function setCourse(?Courses $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getLikesDislikes(): ?PostsLikesDislikes
    {
        return $this->likesDislikes;
    }

    public function setLikesDislikes(PostsLikesDislikes $likesDislikes): self
    {
        $this->likesDislikes = $likesDislikes;

        // set the owning side of the relation if necessary
        if ($this !== $likesDislikes->getPost()) {
            $likesDislikes->setPost($this);
        }

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }
}
