<?php


namespace App\Mapper;

use App\Entity\OrderTaxi;
use App\Form\DTO\OrderDto;
use App\Model\OrderTaxi as OrderModel;

class OrderMapper
{
    public static function entityToModel(OrderTaxi $entity): OrderModel
    {
        $model =  new OrderModel(
            ClientMapper::entityToModel($entity->getClient()),
            $entity->getFromAddressId(),
            $entity->getToAddressId(),
            TaxiMapper::entityToModel($entity->getTaxi()),
            $entity->getId()
        );
        $model
            ->setOrderDate(new \DateTime('now'))
            ->setStatus($entity->getStatus())
        ;
        return $model;
    }

    public static function modelToEntity(OrderModel $model): OrderTaxi
    {
        $entity =  new OrderTaxi(
            ClientMapper::modelToEntity($model->getClient()),
            $model->getFromAddressId(),
            $model->getToAddressId(),
            TaxiMapper::modelToEntity($model->getTaxi()));
        $entity
            ->setOrderDate(new \DateTime('now'))
        ;
        return $entity;
    }
    public static function entityToDto(OrderModel $entity)
    {
        $dto = new OrderDto();
        $dto->firstName = $entity->getClient()->getFirstName();
        $dto->lastName = $entity->getClient()->getLastName();
        $dto->phone = $entity->getClient()->getPhone();
        $dto->streetFrom = $entity->getToAddressId();

    }
    public static function updateEntity(OrderTaxi $entity, OrderModel $model)
    {
        $client = ClientMapper::modelToEntity($model->getClient());
        $taxi = TaxiMapper::modelToEntity($model->getTaxi());
        $entity->setClient($client);
        $entity->setFromAddressId($model->getFromAddressId());
        $entity->setToAddressId($model->getToAddressId());
        $entity->setAmount($model->getAmount());
        $entity->setTaxi($taxi);
        
        return $entity;
    }

}