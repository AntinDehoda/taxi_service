<?php


namespace App\Mapper;


use App\Entity\Address;
use App\Model\Address as AddressModel;

class AddressMapper
{
    public static function entityToModel(Address $entity): AddressModel
    {
        $model = new AddressModel($entity->getStreetId(), $entity->getHouse());
        return $model;

    }
    public static function modelToEntity(AddressModel $model): Address
    {
        $entity = new Address($model->getStreet(), $model->getHouse());
        return $entity;

    }

}