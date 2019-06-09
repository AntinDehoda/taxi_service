<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Address;

use App\Mapper\AddressMapper;
use App\Mapper\DistrictMapper;
use App\Mapper\StreetMapper;
use App\Model\Address;
use App\Model\District;
use App\Model\Street;
use App\Repository\AddressRepository;
use App\Repository\StreetRepository;

/**
 * Class responsible for the creation and management of Street & Address entities
 *
 * @author Anton Degoda <dehoda@ukr.net>
 */
class AddressService implements AddressServiceInterface
{
    private $addressRepository;
    private $streetRepository;

    public function __construct(AddressRepository $addressRepository, StreetRepository $streetRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->streetRepository = $streetRepository;
    }

    public function findStreet(string $streetName): ?Street
    {
        $street = $this->streetRepository->findByName($streetName);

        return ($street) ? StreetMapper::entityToModel($street) : null;
    }

    public function findStreetBy(Street $streetModel): ?Street
    {
        $street = $this->streetRepository->find($streetModel);

        return  ($street) ? StreetMapper::entityToModel($street) : null;
    }

    public function createStreet(string $streetName, ?District $district): Street
    {
        $street = new Street($streetName, $district, null);
        $street = $this->streetRepository->save(StreetMapper::modelToEntity($street));

        return StreetMapper::entityToModel($street);
    }

    public function findAddress(Street $street, string $number): ?Address
    {
        $address = $this->addressRepository
            ->findAddress(StreetMapper::modelToEntity($street), $number);
        return ($address) ? AddressMapper::entityToModel($address) : null;
    }

    public function createAddress(Street $street, string $number): Address
    {
        $address = new Address($street, $number, null);
        $address = $this->addressRepository->save(AddressMapper::modelToEntity($address));
        return AddressMapper::entityToModel($address);
    }
    public function find(Address $address): ?Address
    {

        $entity = $this->addressRepository->find($address);

        return ($entity) ? AddressMapper::entityToModel($entity) : null;
    }

    /**
     * The method looks for a street or an address, and if it does not find it, it creates new.
     * @param string $streetName
     * @param string $number
     * @param District|null $district
     * @return Address
     */
    public function get(string $streetName, string $number, ?District $district): Address
    {
        $street = $this->findStreet($streetName);

        $address = null;

        if (null == $street) {
            $street = $this->createStreet($streetName, $district);
            $address = $this->createAddress($street, $number);
        } else {
            $address = $this->findAddress($street, $number) ?? $this->createAddress($street, $number);
            if (null == $street->getDistrict() && null != $district) {

                $streetEntity = $this->streetRepository->find($street->getId());
                $streetEntity->setDistrict(DistrictMapper::modelToEntity($district));
                $street = $this->streetRepository->update($streetEntity);
                $address->setStreet(StreetMapper::entityToModel($street));

            }

        }

        return $address;
    }
}
