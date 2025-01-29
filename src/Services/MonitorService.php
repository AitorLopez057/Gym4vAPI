<?php
namespace App\Services;

use App\Entity\Monitor;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeInterface;
use App\Repository\MonitorRepository;

class MonitorService
{

    private MonitorRepository $monitorRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(MonitorRepository $monitorRepository, EntityManagerInterface $entityManager)
    {
        $this->monitorRepository = $monitorRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        return $this->monitorRepository->findAll();
    }

    public function save(Monitor $monitor): Monitor
    {
        $this->entityManager->persist($monitor);
        $this->entityManager->flush();
        return $monitor;
    }

    public function update(int $id, Monitor $monitorData): Monitor
    {
        $monitor = $this->monitorRepository->find($id);
        if (!$monitor) {
            throw new NotFoundHttpException("Monitor not found");
        }

        $monitor->setName($monitorData->getName());
        $monitor->setEmail($monitorData->getEmail());
        $monitor->setPhone($monitorData->getPhone());
        $monitor->setPhoto($monitorData->getPhoto());

        $this->entityManager->flush();
        return $monitor;
    }

    public function delete(int $id): void
    {
        $monitor = $this->monitorRepository->find($id);
        if (!$monitor) {
            throw new NotFoundHttpException("Monitor not found");
        }

        $this->entityManager->remove($monitor);
        $this->entityManager->flush();
    }
}