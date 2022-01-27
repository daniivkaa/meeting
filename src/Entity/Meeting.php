<?php

namespace App\Entity;

use App\Repository\MeetingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MeetingRepository::class)
 */
class Meeting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateMeeting;

    /**
     * @ORM\Column(type="time")
     */
    private $timeMeeting;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $arrivalTime;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $startTime;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSuccessful;

    /**
     * @ORM\ManyToOne(targetEntity=Subject::class, inversedBy="meetings")
     */
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="meeting")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMeeting(): ?\DateTimeInterface
    {
        return $this->dateMeeting;
    }

    public function setDateMeeting(\DateTimeInterface $dateMeeting): self
    {
        $this->dateMeeting = $dateMeeting;

        return $this;
    }

    public function getTimeMeeting(): ?\DateTimeInterface
    {
        return $this->timeMeeting;
    }

    public function setTimeMeeting(\DateTimeInterface $timeMeeting): self
    {
        $this->timeMeeting = $timeMeeting;

        return $this;
    }

    public function getArrivalTime(): ?\DateTimeInterface
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(?\DateTimeInterface $arrivalTime): self
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(?\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getIsSuccessful(): ?bool
    {
        return $this->isSuccessful;
    }

    public function setIsSuccessful(?bool $isSuccessful): self
    {
        $this->isSuccessful = $isSuccessful;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setMeeting($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMeeting() === $this) {
                $comment->setMeeting(null);
            }
        }

        return $this;
    }
}
