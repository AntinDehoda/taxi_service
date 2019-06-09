<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Mapper;

use App\Entity\Street;
use App\Model\Street as StreetModel;

class StreetMapper
{
    public static function entityToModel(Street $entity): StreetModel
    {
        $district = ($entity->getDistrict()) ? DistrictMapper::entityToModel($entity->getDistrict()) : null;
        $model = new StreetModel($entity->getName(), $district, $entity->getId());

        return $model;
    }

    public static function modelToEntity(StreetModel $model): Street
    {
        $district = ($model->getDistrict()) ? DistrictMapper::modelToEntity($model->getDistrict()) : null;
        $entity =  new Street($model->getName(), $district, $model->getId());

        return $entity;
    }
}
