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
        $taxi = ($entity->getTaxi()) ? TaxiMapper::entityToModel($entity->getTaxi()) : null;
        $model =  new OrderModel(
            ClientMapper::entityToModel($entity->getClient()),
            AddressMapper::entityToModel($entity->getFromAddress()),
            AddressMapper::entityToModel($entity->getToAddress()),
            $taxi,
            $entity->getId()
        );
        $model
            ->setOrderDate($entity->getOrderDate())
//            ->setStatus($entity->getStatus())
        ;

        return $model;
    }

    public static function modelToEntity(OrderModel $model): OrderTaxi
    {
        $client = ClientMapper::modelToEntity($model->getClient());
        $taxi = ($model->getTaxi()) ? TaxiMapper::modelToEntity($model->getTaxi()) : null;
        $entity =  new OrderTaxi(
            $client,
            AddressMapper::modelToEntity($model->getFromAddress()),
            AddressMapper::modelToEntity($model->getToAddress()),
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
        $dto->streetFrom = $entity->getToAddress();
    }
    public static function updateEntity(OrderTaxi $entity, OrderModel $model)
    {
        $client = ClientMapper::modelToEntity($model->getClient());
        $taxi = ($model->getTaxi()) ? TaxiMapper::modelToEntity($model->getTaxi()) : null;
        $addressFrom = AddressMapper::modelToEntity($model->getFromAddress());
        $addressTo = AddressMapper::modelToEntity($model->getToAddress());

        $entity->setClient($client);
        $entity->setFromAddress($addressFrom);
        $entity->setToAddress($addressTo);
        $entity->setAmount($model->getAmount());
        $entity->setTaxi($taxi);
        
        return $entity;
    }
}
