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
use App\Mapper\TaxiMapper;
use App\Entity\District;
use App\Repository\TaxiRepository;

class TaxiService implements TaxiServiceInterface
{
    private $taxiRepository;

    public function __construct(TaxiRepository $taxiRepository)
    {
        $this->taxiRepository = $taxiRepository;
    }

    public function getAll(): ?TaxiCollection
    {
        $taxis = new TaxiCollection();

        foreach ($this->taxiRepository->findAll() as $taxi) {
            $taxis->add(TaxiMapper::entityToModel($taxi));
        }

        return $taxis;
    }

    public function getAllByDistrict(District $district): ?TaxiCollection
    {
        $taxis = new TaxiCollection();

        foreach ($this->taxiRepository->findAllByDistrict($district) as $taxi) {
            $taxis->add(TaxiMapper::entityToModel($taxi));
        }

        return $taxis;
    }
}
