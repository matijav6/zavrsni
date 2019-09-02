<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CollegesRepository")
 */
class Colleges
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
     * @ORM\ManyToOne(targetEntity="App\Entity\County", inversedBy="colleges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $county;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Courses", mappedBy="college")
     */
    private $courses;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="colleges")
     */
    private $colleges;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->colleges = new ArrayCollection();
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

    public function getCounty(): ?County
    {
        return $this->county;
    }

    public function setCounty(?County $county): self
    {
        $this->county = $county;

        return $this;
    }

    /**
     * @return Collection|Courses[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Courses $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setCollege($this);
        }

        return $this;
    }

    public function removeCourse(Courses $course): self
    {
        if ($this->courses->contains($course)) {
            $this->courses->removeElement($course);
            // set the owning side to null (unless already changed)
            if ($course->getCollege() === $this) {
                $course->setCollege(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getColleges(): Collection
    {
        return $this->colleges;
    }

    public function addCollege(User $college): self
    {
        if (!$this->colleges->contains($college)) {
            $this->colleges[] = $college;
            $college->addCollege($this);
        }

        return $this;
    }

    public function removeCollege(User $college): self
    {
        if ($this->colleges->contains($college)) {
            $this->colleges->removeElement($college);
            $college->removeCollege($this);
        }

        return $this;
    }
}
