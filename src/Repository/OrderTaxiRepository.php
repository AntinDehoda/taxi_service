<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\OrderTaxi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Taxi;

/**
 * @method OrderTaxi|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderTaxi|null findOneBy(array $criteria, array $orderBy = null)
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
        $clientId= $order->getClient()->getId();
        /** @var Client $client */
        $client = $em->getRepository('App\Entity\Client')->find($clientId);
        $order->setClient($client);

        $taxiId= $order->getTaxi()->getId();
        /** @var Taxi $taxi */
        $taxi = $em->getRepository('App\Entity\Taxi')->find($taxiId);
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
        $order->setClient($client);

        $taxiId= $order->getTaxi()->getId();
        /** @var Taxi $taxi */
        $taxi = $em->getRepository('App\Entity\Taxi')->find($taxiId);
        $order->setTaxi($taxi);

        $em->flush();
    }
    public function update()
    {
        $em = $this->getEntityManager();
        $em->flush();
    }
}
