<?php

namespace App\Controller;

use App\Services\MonitorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Monitor;

final class MonitorController extends AbstractController
{
    
    //#[Route('/monitors', name: 'get_monitor')]
    //public function getMonitors(): JsonResponse
    //{
    //    return $this->json([
    //        'message' => 'Welcome to your new controller!',
    //        'path' => 'src/Controller/MonitorController.php',
    //    ]);
    //}
    private MonitorService $monitorService;

    public function __construct(MonitorService $monitorService)
    {
        $this->monitorService = $monitorService;
    }

    #[Route('/monitors', methods: ['GET'])]
    public function getAllMonitors(): JsonResponse
    {
        $monitors = $this->monitorService->findAll();
        return $this->json($monitors, Response::HTTP_OK);
    }

    #[Route('/monitors', methods: ['POST'])]
    public function createMonitor(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $monitor = new Monitor();
        $monitor->setName($data['name']);
        $monitor->setEmail($data['email']);
        $monitor->setPhone($data['phone']);
        $monitor->setPhoto($data['photo']);

        $this->monitorService->save($monitor);

        return $this->json($monitor, Response::HTTP_CREATED);
    }

    #[Route('/monitors/{monitorId}', methods: ['PUT'])]
    public function updateMonitor(int $monitorId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $monitorData = new Monitor();
        $monitorData->setName($data['name']);
        $monitorData->setEmail($data['email']);
        $monitorData->setPhone($data['phone']);
        $monitorData->setPhoto($data['photo']);

        $monitor = $this->monitorService->update($monitorId, $monitorData);

        return $this->json($monitor, Response::HTTP_OK);
    }

    #[Route('/monitors/{monitorId}', methods: ['DELETE'])]
    public function deleteMonitor(int $monitorId): JsonResponse
    {
        $this->monitorService->delete($monitorId);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

}
