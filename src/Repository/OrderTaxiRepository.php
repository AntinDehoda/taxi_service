<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Address;
use App\Entity\Client;
use App\Entity\OrderTaxi;
use App\Entity\Taxi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|OrderTaxi find($id, $lockMode = null, $lockVersion = null)
 * @method null|OrderTaxi findOneBy(array $criteria, array $orderBy = null)
 * @method OrderTaxi[]    findAll()
 * @method OrderTaxi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderTaxiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OrderTaxi::class);
    }
    public function save(OrderTaxi $order): OrderTaxi
    {
        $em = $this->getEntityManager();

        /** @var Client $client */
        $client = $em->getRepository('App\Entity\Client')->find($order->getClient());
        /** @var Address $addressFrom */
        $addressFrom = $em->getRepository('App\Entity\Address')->find($order->getFromAddress());
        /** @var Address $addressTo */
        $addressTo = $em->getRepository('App\Entity\Address')->find($order->getToAddress());
        /** @var Taxi $taxi */
        $taxi = $em->getRepository('App\Entity\Taxi')->find($order->getTaxi());

        $order->setClient($client);
        $order->setFromAddress($addressFrom);
        $order->setToAddress($addressTo);
        $order->setTaxi($taxi);
        $em->persist($order);
        $em->flush();

        return $order;
    }
    public function updateOrder(OrderTaxi $order)
    {
        $em = $this->getEntityManager();
        $clientId= $order->getClient()->getId();
        /** @var Client $client */
        $client = $em->getRepository('App\Entity\Client')->find($clientId);
        /** @var Address $addressFrom */
        $addressFrom = $em->getRepository('App\Entity\Address')->find($order->getFromAddress());
        /** @var Address $addressTo */
        $addressTo = $em->getRepository('App\Entity\Address')->find($order->getToAddress());
        $taxiId= $order->getTaxi()->getId();
        /** @var Taxi $taxi */
        $taxi = $em->getRepository('App\Entity\Taxi')->find($taxiId);

        $order->setClient($client);
        $order->setFromAddress($addressFrom);
        $order->setToAddress($addressTo);
        $order->setTaxi($taxi);

        $em->flush();
    }
    public function update()
    {
        $em = $this->getEntityManager();
        $em->flush();
    }
    // /**
    //  * @return OrderTaxi[] Returns an array of OrderTaxi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderTaxi
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
