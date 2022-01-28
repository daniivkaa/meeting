<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubjectRepository::class)
 */
class Subject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
    private $teacherFirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teacherLastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teacherPatronymic;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="subjects")
     */
    private $session;

    /**
     * @ORM\OneToMany(targetEntity=Meeting::class, mappedBy="subject", cascade={"persist", "remove"})
     */
    private $meetings;

    public function __construct()
    {
        $this->meetings = new ArrayCollection();
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

    public function getTeacherFirstName(): ?string
    {
        return $this->teacherFirstName;
    }

    public function setTeacherFirstName(string $teacherFirstName): self
    {
        $this->teacherFirstName = $teacherFirstName;

        return $this;
    }

    public function getTeacherLastName(): ?string
    {
        return $this->teacherLastName;
    }

    public function setTeacherLastName(string $teacherLastName): self
    {
        $this->teacherLastName = $teacherLastName;

        return $this;
    }

    public function getTeacherPatronymic(): ?string
    {
        return $this->teacherPatronymic;
    }

    public function setTeacherPatronymic(string $teacherPatronymic): self
    {
        $this->teacherPatronymic = $teacherPatronymic;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return Collection|Meeting[]
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): self
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings[] = $meeting;
            $meeting->setSubject($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): self
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getSubject() === $this) {
                $meeting->setSubject(null);
            }
        }

        return $this;
    }
}
