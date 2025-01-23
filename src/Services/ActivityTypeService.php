<?php
namespace App\Services;
use App\Entity\ActivityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ActivityTypeService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    public function getAllActivityTypes(): array
    {
        $activityTypes = $this->entityManager->getRepository(ActivityType::class)->findAll();
        return $activityTypes;

         // Transformamos cada entidad a un array
        return array_map(function ($activityType) {
            return [
                'id' => $activityType->getId(),
                'name' => $activityType->getName(),
                'number-monitors' => $activityType->getRequiredMonitors(),
            ];
        }, $activityTypes);
    }
}