<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursesRepository")
 */
class Courses
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $aka;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Colleges", inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $college;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Posts", mappedBy="course")
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

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

    public function getAka(): ?string
    {
        return $this->aka;
    }

    public function setAka(string $aka): self
    {
        $this->aka = $aka;

        return $this;
    }

    public function getCollege(): ?Colleges
    {
        return $this->college;
    }

    public function setCollege(?Colleges $college): self
    {
        $this->college = $college;

        return $this;
    }

    /**
     * @return Collection|Posts[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Posts $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setCourse($this);
        }

        return $this;
    }

    public function removePost(Posts $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getCourse() === $this) {
                $post->setCourse(null);
            }
        }

        return $this;
    }
}
