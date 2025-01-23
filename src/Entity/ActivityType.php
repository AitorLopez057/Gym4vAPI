<?php
namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ActivityTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityTypeRepository::class)]
class ActivityType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $required_monitors = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRequiredMonitors(): ?int
    {
        return $this->required_monitors;
    }

    public function setRequiredMonitors(int $required_monitors): static
    {
        $this->required_monitors = $required_monitors;

        return $this;
    }


}
