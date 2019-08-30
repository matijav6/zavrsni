<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountyRepository")
 */
class County
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
     * @ORM\OneToMany(targetEntity="App\Entity\Colleges", mappedBy="county")
     */
    private $colleges;

    public function __construct()
    {
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

    /**
     * @return Collection|Colleges[]
     */
    public function getColleges(): Collection
    {
        return $this->colleges;
    }

    public function addCollege(Colleges $college): self
    {
        if (!$this->colleges->contains($college)) {
            $this->colleges[] = $college;
            $college->setCounty($this);
        }

        return $this;
    }

    public function removeCollege(Colleges $college): self
    {
        if ($this->colleges->contains($college)) {
            $this->colleges->removeElement($college);
            // set the owning side to null (unless already changed)
            if ($college->getCounty() === $this) {
                $college->setCounty(null);
            }
        }

        return $this;
    }
}
