<?php

namespace App\Controller;

use App\Model\ActivityNewDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\ActivityService;
use DateTime;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\Response;



final class ActivityController extends AbstractController
{

    public $activities = [];

    public function __construct(private LoggerInterface $logger, private ActivityService $activityService)
    {
        $activities = $this->activityService->getAllActivities();
    }

    #[Route('/activities', name: 'get_activities_by_date', methods:['GET'])]
    public function getActivityTypes (#[MapQueryParameter] ?string $date): JsonResponse
    {
        $this->logger->info("Quiero las actividades para la fecha: ".$date);
        // Convertimos la cadena a un objeto DateTime
        try {
            $dateTime = new DateTime($date);
        } catch (\Exception $e) {
            // Si no se puede convertir la fecha, devolver un error o un mensaje adecuado
            return $this->json(['error' => 'Invalid date format'], 400);
        }

        return $this->json($this->activityService->getActivityByDate($dateTime));
    }

    #[Route('/all-activities', name: 'get_activities')]
    public function getActivities(): JsonResponse
    {
        return $this->json($this->activityService->getAllActivities());
    }


    
    #[Route('/activities', name: 'post_activities', methods:['POST'], format: 'json')]
    public function newActivities(#[MapRequestPayload(acceptFormat: 'json',validationFailedStatusCode: Response::HTTP_BAD_REQUEST)] ActivityNewDTO $activityNewtDto): JsonResponse
    {
        // Inserto el objeto
        array_push($this->activities, $activityNewtDto);

        //Contesto
        return $this->json($this->activities[sizeof($this->activities) - 1]);
        
    }
}  