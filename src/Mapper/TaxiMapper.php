<?php


namespace App\Mapper;

use App\Entity\Taxi;
use App\Model\Taxi as TaxiModel;

class TaxiMapper
{
    public static function entityToModel (Taxi $entity): TaxiModel
    {
        return new TaxiModel($entity->getPhone(), $entity->getFirstName(), $entity->getId());
    }

    public static function modelToEntity (TaxiModel $model): Taxi
    {
        return new Taxi($model->getPhone(), $model->getFirstName(), $model->getId());

    }
}