<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Client;

use App\Model\Client;

interface ClientServiceInterface
{
    public function create(string $phone, string $firstName, ?string $lastName): Client;
    public function find(string $phone): ?Client;
}
