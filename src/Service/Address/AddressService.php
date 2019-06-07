<?php


namespace App\Service\Address;


use App\Mapper\AddressMapper;
use App\Mapper\StreetMapper;
use App\Model\Address;
use App\Model\District;
use App\Model\Street;
use App\Repository\AddressRepository;
use App\Repository\StreetRepository;

class AddressService implements AddressServiceInterface
{

    private $addressRepository;
    private $streetRepository;

    public function __construct(AddressRepository $addressRepository, StreetRepository $streetRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->streetRepository = $streetRepository;
    }

    public function findAddress(int $streetId, string $number): ?int
    {
        return $this->addressRepository->findAddress($streetId, $number);
    }

    public function createAddress(int $streetId, string $number): int
    {
        $address = new Address($streetId, $number);
        return $this->addressRepository->save(AddressMapper::modelToEntity($address));
    }

    public function findStreet(string $streetName): ?int
    {
        $streetId = $this->streetRepository->findByName($streetName);
        return $streetId;
    }

    public function findStreetById(int $id): ?Street
    {
        $street = $this->streetRepository->find($id);
        return StreetMapper::entityToModel($street);
    }

    public function createStreet(string $streetName, ?District $district): int
    {
        $street = new Street($streetName, $district, null);
        $street = $this->streetRepository->save(StreetMapper::modelToEntity($street));
        return $street->getId();
    }

    public function get(string $streetName, string $number, ?District $district): int
    {
        $streetId = $this->findStreet($streetName);
        $addressId = null;

        if (null == $streetId) {
            $streetId = $this->createStreet($streetName, $district);
            $addressId = $this->createAddress($streetId, $number);
        } else {
            $addressId = $this->findAddress($streetId, $number) ?? $this->createAddress($streetId, $number);
        }
        return $addressId;
    }

    public function find(?int $id): Address
    {
        $entity = $this->addressRepository->find($id);
        return AddressMapper::entityToModel($entity);
    }
}