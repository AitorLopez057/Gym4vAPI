<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\ActivityService;
use DateTime;
use Doctrine\DBAL\Types\DateType;

final class ActivityController extends AbstractController
{

    public function __construct(private LoggerInterface $logger, private ActivityService $activityService)
    {}

    #[Route('/activities', name: 'get_activities_by_date', methods:['GET'])]
    public function getActivityTypes (#[MapQueryParameter] ?string $date): JsonResponse
    {
        $this->logger->info("Quiero las actividades para la fecha: ".$date);
        if ($date !== null) {
            // Convertimos la cadena a un objeto DateTime
            try {
                $dateTime = new DateTime($date);
            } catch (\Exception $e) {
                // Si no se puede convertir la fecha, devolver un error o un mensaje adecuado
                return $this->json(['error' => 'Invalid date format'], 400);
            }

            return $this->json($this->activityService->getActivityByDate($dateTime));
        }else{
            return $this->json($this->activityService->getAllActivities());
        }
    }
}  