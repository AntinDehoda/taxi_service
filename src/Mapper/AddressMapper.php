<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Mapper;

use App\Entity\Address;
use App\Model\Address as AddressModel;

class AddressMapper
{
    public static function entityToModel(Address $entity): AddressModel
    {
        $street = StreetMapper::entityToModel($entity->getStreet());
        $model = new AddressModel($street, $entity->getHouse(), $entity->getId());

        return $model;
    }
    public static function modelToEntity(AddressModel $model): Address
    {
        $street = StreetMapper::modelToEntity($model->getStreet());
        $entity = new Address($street, $model->getHouse(), $model->getId());

        return $entity;
    }
}
