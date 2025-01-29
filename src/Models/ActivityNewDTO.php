<?php

namespace App\Model;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ActivityNewDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type("int")]
        public int $activityType,

        #[Assert\NotBlank]
        #[Assert\Count(
            min: 2, // No se como validarlo correctamente
            max: 2, // No se como validarlo correctamente
            minMessage: "Debes seleccionar 2 monitores",
            maxMessage: "Debes seleccionar 2 monitores"
        )]
        public array $monitor,

        #[Assert\NotBlank]
        #[Assert\Type("datetime")]
        public \DateTime $dateStart,

        #[Assert\NotBlank]
        #[Assert\Type("datetime")]
        public \DateTime $dateEnd
    ) {
        $this->validateDateConstraints();
    }


    public function validateDateConstraints(): void
    {
        // Validar horarios permitidos
        $validTimes = ['09:00', '13:30', '17:30'];
        $time = $this->dateStart->format('H:i');

        if (!in_array($time, $validTimes)) {
            throw new \InvalidArgumentException('La hora de inicio debe ser 09:00, 13:30 o 17:30.');
        }

        // Validar duración exacta de 90 minutos
        $interval = $this->dateStart->diff($this->dateEnd);
        if ($interval->h !== 1 || $interval->i !== 30) {
            throw new \InvalidArgumentException('Las clases deben durar exactamente 90 minutos.');
        }
    }
}
