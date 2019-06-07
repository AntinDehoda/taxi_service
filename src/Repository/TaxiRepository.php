<?php

namespace App\Repository;

use App\Entity\Taxi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;

/**
 * @method Taxi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taxi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taxi[]    findAll()
 * @method Taxi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Taxi::class);
    }
    public function findByDistrict(int $districtId): Taxi
    {
        try {
            return $this->createQueryBuilder('t')
                ->andWhere('t.districtId = :districtId')
                ->setParameter('districtId', $districtId)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult()
                ;
        } catch (NonUniqueResultException $e) {
            return null;
        }

    }
}
