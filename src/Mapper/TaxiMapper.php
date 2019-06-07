<?php


namespace App\Mapper;

use App\Entity\Taxi;
use App\Model\Taxi as TaxiModel;

class TaxiMapper
{
    public static function entityToModel (Taxi $entity)
    {
        $model = new TaxiModel($entity->getPhone(), $entity->getFirstName(), $entity->getId());

        return $model;
    }

    public static function modelToEntity (TaxiModel $model)
    {
        $entity = new Taxi($model->getPhone(), $model->getFirstName(), $model->getId());
        return $entity;
    }
}