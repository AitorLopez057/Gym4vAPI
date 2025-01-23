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
    private \DateTimeInterface $datestart;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $dateend;

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
        return $this->datestart;
    }

    public function setDateStart(\DateTimeInterface $datestart): static
    {
        $this->datestart = $datestart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateend;
    }

    public function setDateEnd(\DateTimeInterface $dateend): static
    {
        $this->dateend = $dateend;

        return $this;
    }
}
