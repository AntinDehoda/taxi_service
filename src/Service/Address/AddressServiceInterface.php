<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Address;

use App\Model\Address;
use App\Model\District;
use App\Model\Street;

interface AddressServiceInterface
{
    public function get(string $streetName, string $number, District $district): int;
    public function findAddress(int $streetId, string $number): ?int;
    public function createAddress(int $streetId, string $number): int;
    public function findStreet(string $streetName): ?int;
    public function findStreetById(int $id): ?Street;
    public function createStreet(string $streetName, District $district): int;
    public function find(?int $id): Address;
}
