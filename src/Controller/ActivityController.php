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