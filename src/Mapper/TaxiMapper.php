<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Mapper;

use App\Entity\Taxi;
use App\Model\Taxi as TaxiModel;

class TaxiMapper
{
    public static function entityToModel(Taxi $entity): TaxiModel
    {
        $model = new TaxiModel($entity->getPhone(), $entity->getFirstName(), $entity->getId());
        $model->setLastName($entity->getLastName());
        $model->setCar($entity->getCar());

        return $model;
    }

    public static function modelToEntity(TaxiModel $model): Taxi
    {
        $entity = new Taxi($model->getPhone(), $model->getFirstName(), $model->getId());
        $entity->setLastName($model->getLastName());
        $entity->setCar($model->getCar());

        return $entity;
    }
}
