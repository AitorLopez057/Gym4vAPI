<?php
namespace App\Services;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\ActivityType;
use App\Entity\Monitor;
use App\Model\ActivityNewDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ActivityService
{

private EntityManagerInterface $entityManager;
private EntityRepository $activityRepository;
private EntityRepository $activityTypeRepository;
private EntityRepository $monitorRepository;

public function __construct(EntityManagerInterface $entityManager)
{
        $this->entityManager = $entityManager;
        $this->activityRepository = $entityManager->getRepository(Activity::class);
        $this->activityTypeRepository = $entityManager->getRepository(ActivityType::class);
        $this->monitorRepository = $entityManager->getRepository(Monitor::class);
    }

    public function findActivities(?string $date): array
    {
        $criteria = [];
        if ($date) {
            $criteria['date_start'] = new \DateTime($date);
        }
        return $this->activityRepository->findBy($criteria);
    }

    public function addActivity(ActivityNewDTO $dto): Activity
    {
        // Obtener tipo de actividad
        $activityType = $this->entityManager->getRepository(ActivityType::class)->find($dto->activityType);
        if (!$activityType) {
            return ["error" => "ActivityType not found"];
        }

        // Obtener monitores
        $monitors = $this->entityManager->getRepository(Monitor::class)->findBy(['id' => $dto->monitor]);
        if (count($monitors) !== 2) {
            return ["error" => "Monitores no encontrados o insuficientes"];
        }

        // Crear y persistir la actividad
        $activity = new Activity();
        $activity->setActivityType($activityType);
        $activity->setDateStart($dto->dateStart);
        $activity->setDateEnd($dto->dateEnd);

        foreach ($monitors as $monitor) {
            $activity->addMonitor($monitor);
        }

        $this->entityManager->persist($activity);
        $this->entityManager->flush();

        return $activity;
    }

    public function updateActivity(int $id, array $data): Activity
    {
        $activity = $this->activityRepository->find($id);
        if (!$activity) {
            return ["error" => "Activity not found"];
        }

        $activityType = $this->activityTypeRepository->find($data['activity_type_id']);
        if (!$activityType) {
            return ["error" => "ActivityType not found"];
        }
        
        $activity->setActivityType($activityType);
        $activity->setDateStart(new \DateTime($data['date_start']));
        $activity->setDateEnd(new \DateTime($data['date_end']));
        
        // Limpiar monitores actuales y asignar nuevos
        foreach ($activity->getMonitor() as $monitor) {
            $activity->removeMonitor($monitor);
        }
        
        $monitors = $this->monitorRepository->findBy(['id' => $data['monitors_id']]);
        foreach ($monitors as $monitor) {
            $activity->addMonitor($monitor);
        }
        
        $this->entityManager->flush();

        return $activity;
    }

    public function deleteActivity(int $id): Activity
    {
        $activity = $this->activityRepository->find($id);
        if (!$activity) {
            return ["error" => "Activity not found"];
        }

        $this->entityManager->remove($activity);
        $this->entityManager->flush();

        return $activity;
    }

}