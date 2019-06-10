<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Taxi;

use App\Collection\TaxiCollection;

interface TaxiServiceInterface
{
    public function getAll(): ?TaxiCollection;
}
