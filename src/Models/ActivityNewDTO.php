<?php

namespace App\Model;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ActivityNewDTO
{
    public function __construct(
        public int $id,

        // Cambiar al número de monitores por el tipo de actividad
        #[Assert\Count(min:2, 
                        max:2, 
                        minMessage: 'Debes seleccionar 2 monitores', 
                        maxMessage: 'Debes seleccionar 2 monitores')]
        public array $monitor,
        public int $activityType,

        // Validar que la hora de inicio sea 09:00, 13:30 o 17:30
        public \DateTime $dateStart,
        public \DateTime $dateEnd
    ){}
    

    public function validateDateStart(ExecutionContextInterface $context): void
    {
        // Extraer la hora y los minutos de dateStart
        $time = $this->dateStart->format('H:i');

        // Horarios permitidos
        $validTimes = ['09:00', '13:30', '17:30'];

        // Validar si el tiempo está en la lista de horarios permitidos
        if (!in_array($time, $validTimes)) {
            $context->buildViolation('La hora debe ser 09:00, 13:30 o 17:30.')
                    ->atPath('dateStart')
                    ->addViolation();
        }
    }
}
