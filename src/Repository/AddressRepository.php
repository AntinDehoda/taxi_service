<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function findAddress(int $streetId, string $house): ?int
    {
        try {
            $result =  $this->createQueryBuilder('a')
                ->select('a.id')
                ->andWhere('a.streetId = :streetId')
                ->setParameter('streetId', $streetId)
                ->andWhere('a.house = :house')
                ->setParameter('house', $house)
                ->getQuery()
                ->getOneOrNullResult()
                ;
            return $result['id'];
        } catch (NonUniqueResultException $e) {
            return null;
        }

    }
    public function save(Address $address): int
    {
        $em = $this->getEntityManager();
        $em->persist($address);
        $em->flush();
        return $address->getId();
    }
}
