<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Mapper;

use App\Entity\Client;
use App\Model\Client as ClientModel;

class ClientMapper
{
    public static function entityToModel(Client $entity): ClientModel
    {
        $model = new ClientModel(
            $entity->getPhone(),
            $entity->getFirstName(),
            $entity->getLastName(),
            $entity->getId()
        );

        return $model;
    }
    public static function modelToEntity(ClientModel $model): Client
    {
        $entity = new Client(
            $model->getPhone(),
            $model->getFirstName(),
            $model->getLastName(),
            $model->getId()
        );

        return $entity;
    }
}
