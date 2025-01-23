<?php
namespace App\Services;

use App\Entity\Activity;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeInterface;

class ActivityService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    public function getAllActivities(): array
    {
        return $this->entityManager->getRepository(Activity::class)->findAll();
    }

    public function getActivityByDate(DateTime $date): array
    {
        return $this->entityManager->getRepository(Activity::class)->findBy(['datestart' => $date]);
    }
}