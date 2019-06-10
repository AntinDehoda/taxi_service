<?php

/*
 *
 * (c) Anton Dehoda <dehoda@ukr.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Order;

use App\Form\DTO\OrderDto;
use App\Mapper\DistrictMapper;
use App\Mapper\OrderMapper;
use App\Mapper\TaxiMapper;
use App\Model\Client;
use App\Model\District;
use App\Model\OrderTaxi;
use App\Entity\OrderTaxi as OrderEntity;
use App\Entity\Taxi;
use App\Service\Address\AddressServiceInterface;
use App\Service\Client\ClientServiceInterface;
use App\Repository\OrderTaxiRepository;
use App\Repository\TaxiRepository;
use App\Repository\DistrictRepository;

class OrderService implements OrderServiceInterface
{
    /**
     * @var OrderTaxiRepository
     */
    private $orderTaxiRepository;
    /**
     * @var ClientServiceInterface
     */
    private $clientService;
    /**
     * @var AddressServiceInterface
     */
    private $addressService;
    /**
     * @var TaxiRepository
     */
    private $taxiRepository;
    /**
     * @var DistrictRepository
     */
    private $districtRepository;

    public function __construct(
        OrderTaxiRepository $orderRepository,
        ClientServiceInterface $clientService,
        AddressServiceInterface $addressService,
        TaxiRepository $taxiRepository,
        DistrictRepository $districtRepository
    ) {
        $this->orderTaxiRepository = $orderRepository;
        $this->clientService = $clientService;
        $this->addressService = $addressService;
        $this->taxiRepository = $taxiRepository;
        $this->districtRepository = $districtRepository;
    }

    /**
     * Formed taxi order model from OrderDto data
     *
     * @param OrderDto $orderDto
     *
     * @return OrderTaxi
     *
     */
    private function get(OrderDto $orderDto): OrderTaxi
    {
        /** @var Client
         * Search for an entity Client by phone number
         */
        $clientModel = $this->clientService->find($orderDto->phone);

        if (null == $clientModel) {
            /** Creating a new entity Client */
            $clientModel =
                $this->clientService
                    ->create($orderDto->phone, $orderDto->firstName, $orderDto->lastName);
        }
        /** @var District
         * Search for an entity District
         */
        $district = DistrictMapper::entityToModel($this->districtRepository->find($orderDto->district));

        /** @var int
         * Getting id entity AddressFrom
         */
        $addressFromModel =
            $this->addressService
                ->get($orderDto->streetFrom, $orderDto->streetFromNumber, $district);
        /** @var null|int
         * Getting id entity AddressTo
         */
        $addressToModel = null;

        if ($orderDto->streetTo) {
            $addressToModel =
                $this->addressService
                    ->get($orderDto->streetTo, $orderDto->streetToNumber, null);
        }
        /** @var Taxi
         * Search for an entity Taxi by District id
         */
        $taxiEntity = $this->taxiRepository
            ->findByDistrict(DistrictMapper::modelToEntity($addressFromModel->getStreet()->getDistrict()));
        $taxiModel = ($taxiEntity) ? TaxiMapper::entityToModel($taxiEntity) : null;

        return new OrderTaxi($clientModel, $addressFromModel, $addressToModel, $taxiModel, null);
    }

    /** Create a taxi order
     * @param OrderDto $orderDto
     *
     * @return OrderTaxi
     */
    public function create(OrderDto $orderDto): OrderTaxi
    {
        $orderModel = $this->get($orderDto);
        $entity = $this->orderTaxiRepository->save(OrderMapper::modelToEntity($orderModel));

        return OrderMapper::entityToModel($entity);
    }

    /** Search for an existing order and convert it for display in the edit form
     * @param int $id
     *
     * @return null|OrderDto
     */
    public function edit(int $id): ?OrderDto
    {
        $order =  $this->orderTaxiRepository->find($id);
        $orderModel = OrderMapper::entityToModel($order);

        if (null != $orderModel) {
            $dto = new OrderDto();
            $addressFrom = $orderModel->getFromAddress();
            $streetFrom = $addressFrom->getStreet();

            $dto->firstName = $orderModel->getClient()->getFirstName();
            $dto->lastName = $orderModel->getClient()->getLastName();
            $dto->phone = $orderModel->getClient()->getPhone();
            $dto->streetFrom = $streetFrom->getName();
            $dto->streetFromNumber = $addressFrom->getHouse();
            $dto->district = $streetFrom->getDistrict();

            $addressTo = $orderModel->getToAddress();

            if (null != $addressTo) {
                $streetTo = $addressTo->getStreet();
                $dto->streetTo = $streetTo->getName();
                $dto->streetToNumber = $addressTo->getHouse();
            }

            return $dto;
        }
    }


    /** Search for an existing order
     * @param int $id
     *
     * @return null|OrderTaxi
     */
    public function find(int $id): ?OrderEntity
    {
        $entity = $this->orderTaxiRepository->find($id);

        return $entity;
    }

    /** Order confirmation. Order status changes to executed
     * @param OrderEntity $order
     */
    public function confirm(OrderEntity $order): void
    {
        $order->confirm();
        $this->orderTaxiRepository->update();
    }

    /** Order cancellation. Order status changes to cancelled. Returns client information
     * @param OrderEntity $order
     *
     * @return string
     */
    public function cancel(OrderEntity $order): string
    {
        $order->cancel();
        $this->orderTaxiRepository->update();

        return (string) $order->getClient() . ', ' . (string) $order->getFromAddress();
    }

    /** Order update. Order status changes to updated
     * @param OrderDto $orderDto
     * @param int $id
     */
    public function update(OrderDto $orderDto, int $id): void
    {
        $orderModel = $this->get($orderDto);
        $orderEntity = $this->orderTaxiRepository->find($id);
        $orderEntity = OrderMapper::updateEntity($orderEntity, $orderModel);
        $orderEntity->update();
        $this->orderTaxiRepository->updateOrder($orderEntity);
    }
}
