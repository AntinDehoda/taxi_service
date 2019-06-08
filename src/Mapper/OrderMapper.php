<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
            ->setOrderDate($entity->getOrderDate())
            ->setStatus($entity->getStatus())
        ;

        return $model;
    }

    public static function modelToEntity(OrderModel $model): OrderTaxi
    {
        $client = ClientMapper::modelToEntity($model->getClient());
        $taxi = ($model->getTaxi()) ? TaxiMapper::modelToEntity($model->getTaxi()) : null;
        $entity =  new OrderTaxi(
            $client,
            $model->getFromAddressId(),
            $model->getToAddressId(),
            $taxi
        );
        $entity
            ->setOrderDate($model->getOrderDate())
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
