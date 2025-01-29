<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?ActivityType $ActivityType = null;

    /**
     * @var Collection<int, Monitor>
     */
    #[ORM\ManyToMany(targetEntity: Monitor::class, inversedBy: 'activities')]
    private Collection $monitor;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $date_start;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $date_end;

    public function __construct()
    {
        $this->monitor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getActivityType(): ?ActivityType
    {
        return $this->ActivityType;
    }

    public function setActivityType(?ActivityType $ActivityType): static
    {
        $this->ActivityType = $ActivityType;

        return $this;
    }

    /**
     * @return Collection<int, Monitor>
     */
    public function getMonitor(): Collection
    {
        return $this->monitor;
    }

    public function addMonitor(Monitor $monitor): static
    {
        if (!$this->monitor->contains($monitor)) {
            $this->monitor->add($monitor);
        }

        return $this;
    }

    public function removeMonitor(Monitor $monitor): static
    {
        $this->monitor->removeElement($monitor);

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): static
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): static
    {
        $this->date_end = $date_end;

        return $this;
    }
}
