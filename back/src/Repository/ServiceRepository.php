<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    /**
     * Requête personnalisée pour trouver les services par nom (exemple).
     *
     * @return Service[]
     */
    public function findByNom(string $nom): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.nom LIKE :nom')
            ->setParameter('nom', '%'.$nom.'%')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Requête personnalisée pour trouver un service par son ID.
     */
    public function findOneById(int $id): ?Service
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
