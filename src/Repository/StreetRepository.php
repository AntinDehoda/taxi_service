<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\District;
use App\Entity\Street;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|Street find($id, $lockMode = null, $lockVersion = null)
 * @method null|Street findOneBy(array $criteria, array $orderBy = null)
 * @method Street[]    findAll()
 * @method Street[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Street::class);
    }
    public function findByName($name): ?Street
    {
        try {
            return $this->createQueryBuilder('s')
                ->andWhere('s.name = :val')
                ->setParameter('val', $name)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
    public function save(Street $street): Street
    {
        $em = $this->getEntityManager();
        $district= $street->getDistrict();

        if ($district) {
            /** @var District $districtEntity */
            $districtEntity = $em->getRepository('App\Entity\District')->find($district);
            $street->setDistrict($districtEntity);
        }
        $em->persist($street);
        $em->flush();

        return $street;
    }
    public function update(Street $street)
    {
        $em = $this->getEntityManager();
        $district= $street->getDistrict();

        if ($district) {
            /** @var District $districtEntity */
            $districtEntity = $em->getRepository('App\Entity\District')->find($district);
            $street->setDistrict($districtEntity);
        }
        $em->flush();

        return $street;
    }
    // /**
    //  * @return Street[] Returns an array of Street objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Street
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
