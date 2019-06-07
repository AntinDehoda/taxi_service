<?php


namespace App\Mapper;


use App\Entity\District;
use App\Model\District as DistrictModel;

class DistrictMapper
{
    public static function entityToModel(District $entity): DistrictModel
    {
        $model = new DistrictModel($entity->getName(), $entity->getId());
        return $model;

    }
    public static function  modelToEntity(DistrictModel $model): District
    {
        $entity = new District($model->getName(), $model->getId());
        return $entity;
    }
}