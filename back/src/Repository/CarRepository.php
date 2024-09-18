<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function findAllCars(): array
    {
        return $this->findBy([], ['id' => 'ASC']);
    }

    public function findCarsByPriceRange(float $minPrice, float $maxPrice): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.price >= :minPrice')
            ->andWhere('c.price <= :maxPrice')
            ->setParameter('minPrice', $minPrice)
            ->setParameter('maxPrice', $maxPrice)
            ->orderBy('c.price', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findCarsByYear(string $year): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.year = :year')
            ->setParameter('year', $year)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findCarsByMaxMileage(int $maxMileage): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.mileage <= :maxMileage')
            ->setParameter('maxMileage', $maxMileage)
            ->orderBy('c.mileage', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findCarById(int $id): ?Car
    {
        return $this->find($id);
    }
}
