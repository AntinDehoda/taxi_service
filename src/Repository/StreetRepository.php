<?php

namespace App\Repository;

use App\Entity\District;
use App\Entity\Street;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Street|null find($id, $lockMode = null, $lockVersion = null)
 * @method Street|null findOneBy(array $criteria, array $orderBy = null)
 * @method Street[]    findAll()
 * @method Street[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Street::class);
    }

    public function findByName($value): ?int
    {
        try {
            $result = $this->createQueryBuilder('s')
                ->select('s.id')
                ->andWhere('s.name = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        } catch (NonUniqueResultException $e) {
            return null;
        }
        return $result['id'];
    }
    public function save(Street $street): Street
    {
        $em = $this->getEntityManager();
        $districtExist= $street->getDistrict();
        if ($districtExist) {
            $DistrictId = $districtExist->getId();
            /** @var District $district */
            $district = $em->getRepository('App\Entity\District')->findById($DistrictId);
            $street->setDistrict($district);
        }
        $em = $this->getEntityManager();
        $em->persist($street);
        $em->flush();
        return $street;
    }
}
