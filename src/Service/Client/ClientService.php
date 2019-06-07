<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Client;

use App\Mapper\ClientMapper;
use App\Model\Client;
use App\Repository\ClientRepository;

class ClientService implements ClientServiceInterface
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function create(string $phone, string $firstName, ?string $lastName): Client
    {
        $client = new Client($phone, $firstName, $lastName, null);
        $entity = $this->clientRepository->save(ClientMapper::modelToEntity($client));

        return ClientMapper::entityToModel($entity);
    }

    public function find(string $phone): ?Client
    {
        $entity = $this->clientRepository->findByPhone($phone);

        if ($entity) {
            return ClientMapper::entityToModel($entity);
        }

        return null;
    }
}
