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

    #[ORM\Column(name: "number_monitors", type: "integer")]
    private ?int $requiredMonitors = null;


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
        return $this->requiredMonitors;
    }

    public function setRequiredMonitors(int $requiredMonitors): static
    {
        $this->requiredMonitors = $requiredMonitors;

        return $this;
    }


}
