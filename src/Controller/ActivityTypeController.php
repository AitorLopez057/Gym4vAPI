<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\ActivityTypeService;

final class ActivityTypeController extends AbstractController
{

    public function __construct(private ActivityTypeService $activityTypeService)
    {}

    #[Route('/activity/type', name: 'app_activity_type')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ActivityTypeController.php',
        ]);
    }

    #[Route('/activity-types', name: 'get_activity_types')]
    public function getActivityTypes(): JsonResponse
    {
        return $this->json($this->activityTypeService->getAllActivityTypes());
    }
}
