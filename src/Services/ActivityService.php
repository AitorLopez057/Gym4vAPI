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

    public function getActivityByDate(DateTimeInterface $date): array
    {
        $formattedDate = $date->format('Y-m-d');
        return $this->entityManager->getRepository(Activity::class)->createQueryBuilder('a')
            ->where('a.date_start >= :dateStart')
            ->setParameter('dateStart', $formattedDate)
            ->getQuery()
            ->getResult();
    }



}