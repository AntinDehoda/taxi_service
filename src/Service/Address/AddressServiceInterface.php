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
    public function get(string $streetName, string $number, ?District $district): Address;
    public function findAddress(Street $street, string $number): ?Address;
    public function createAddress(Street $street, string $number): Address;
    public function findStreet(string $streetName): ?Street;
    public function findStreetBy(Street $street): ?Street;
    public function createStreet(string $streetName, District $district): Street;
    public function find(Address $address): ?Address;
}
