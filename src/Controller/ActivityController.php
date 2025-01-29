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
use Symfony\Component\HttpFoundation\Request;



#[Route('/activities')]
final class ActivityController extends AbstractController
{

    //public $activities = [];
//
    //public function __construct(private LoggerInterface $logger, private ActivityService $activityService)
    //{
    //    $activities = $this->activityService->getAllActivities();
    //}
//
    //#[Route('/activities', name: 'get_activities_by_date', methods:['GET'])]
    //public function getActivityTypes (#[MapQueryParameter] ?string $date): JsonResponse
    //{
    //    $this->logger->info("Quiero las actividades para la fecha: ".$date);
    //    // Convertimos la cadena a un objeto DateTime
    //    try {
    //        $dateTime = new DateTime($date);
    //    } catch (\Exception $e) {
    //        // Si no se puede convertir la fecha, devolver un error o un mensaje adecuado
    //        return $this->json(['error' => 'Invalid date format'], 400);
    //    }
//
    //    return $this->json($this->activityService->getActivityByDate($dateTime));
    //}
//
    //#[Route('/all-activities', name: 'get_activities')]
    //public function getActivities(): JsonResponse
    //{
    //    return $this->json($this->activityService->getAllActivities());
    //}
//
//
    //
    //#[Route('/activities', name: 'post_activities', methods:['POST'], format: 'json')]
    //public function newActivities(#[MapRequestPayload(acceptFormat: 'json',validationFailedStatusCode: Response::HTTP_BAD_REQUEST)] ActivityNewDTO $activityNewtDto): JsonResponse
    //{
    //    // Inserto el objeto
    //    array_push($this->activities, $activityNewtDto);
//
    //    //Contesto
    //    return $this->json($this->activities[sizeof($this->activities) - 1]);
    //    
    //}


    

    private ActivityService $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    #[Route('', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $date = $request->query->get('date');
        return $this->json($this->activityService->findActivities($date));
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        try {
            $dto = new ActivityNewDTO(
                $data['activityType'],
                $data['monitor'],
                new \DateTime($data['dateStart']),
                new \DateTime($data['dateEnd'])
            );
    
            return $this->json($this->activityService->addActivity($dto));
        } catch (\Exception $e) {
            return $this->json(["error" => $e->getMessage()], 400);
        }
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        return $this->json($this->activityService->updateActivity($id, $data));
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return $this->json($this->activityService->deleteActivity($id));
    }
}