<?php


namespace App\Service\Order;


use App\DBAL\EnumOrderStatus;
use App\Entity\Taxi;
use App\Form\DTO\OrderDto;
use App\Mapper\DistrictMapper;
use App\Mapper\OrderMapper;
use App\Mapper\TaxiMapper;
use App\Model\Client;
use App\Model\District;
use App\Model\OrderTaxi;
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
    )
    {
        $this->orderTaxiRepository = $orderRepository;
        $this->clientService = $clientService;
        $this->addressService = $addressService;
        $this->taxiRepository = $taxiRepository;
        $this->districtRepository = $districtRepository;
    }

    /**
     * Formed taxi order model from OrderDto data
     * @param OrderDto $orderDto
     * @return OrderTaxi
     *
     */
    private function getOrder(OrderDto $orderDto): OrderTaxi
    {
        /** @var Client $clientModel
         * Search for an entity Client by phone number
         */
        $clientModel = $this->clientService->find($orderDto->phone);

        if (null == $clientModel) {
            /** Creating a new entity Client */
            $clientModel =
                $this->clientService
                    ->create($orderDto->phone, $orderDto->firstName, $orderDto->lastName);
        }
        /** @var District $district
         * Search for an entity District
         */
        $district = DistrictMapper::entityToModel($orderDto->district);

        /** @var int $addressFromId
         * Getting id entity AddressFrom
         */
        $addressFromId =
            $this->addressService
                ->get($orderDto->streetFrom, $orderDto->streetFromNumber, $district);
        /** @var int|null $addressToId
         * Getting id entity AddressTo
         */
        $addressToId = null;
        if ($orderDto->streetTo) {
            $addressToId =
                $this->addressService
                    ->get($orderDto->streetTo, $orderDto->streetToNumber, null);
        }
        /** @var Taxi $taxiEntity
         * Search for an entity Taxi by District id
         */
        $taxiEntity = $this->taxiRepository->findByDistrict($district->getId());
        $taxiModel = ($taxiEntity) ? TaxiMapper::entityToModel($taxiEntity) : null;
        return new OrderTaxi($clientModel, $addressFromId, $addressToId, $taxiModel, null);
    }

    /** Create a taxi order
     * @param OrderDto $orderDto
     * @return OrderTaxi
     */
    public function createOrder(OrderDto $orderDto): OrderTaxi
    {
        $orderModel = $this->getOrder($orderDto);
        $entity = $this->orderTaxiRepository->save(OrderMapper::modelToEntity($orderModel));
        return OrderMapper::entityToModel($entity);

    }

    /** Search for an existing order and convert it for display in the edit form
     * @param int $id
     * @return OrderDto|null
     */
    public function edit(int $id): ?OrderDto
    {
        $orderModel =  $this->orderTaxiRepository->find($id);
        if (null != $orderModel) {
            $addressFrom = $this->addressService->find($orderModel->getFromAddressId());
            $streetFrom = $this->addressService->findStreetById($addressFrom->getStreet());

            $dto = new OrderDto();
            $dto->firstName = $orderModel->getClient()->getFirstName();
            $dto->lastName = $orderModel->getClient()->getLastName();
            $dto->phone = $orderModel->getClient()->getPhone();
            $dto->streetFrom = $streetFrom->getName();
            $dto->streetFromNumber = $addressFrom->getHouse();
            $dto->district = $this->districtRepository->findById($streetFrom->getDistrict()->getId());

            $addressTo = $this->addressService->find($orderModel->getToAddressId());

            if (null != $addressTo) {
                $streetTo = $this->addressService->findStreetById($addressTo->getStreet());
                $dto->streetTo = $streetTo->getName();
                $dto->streetToNumber = $addressTo->getHouse();
            }
            return $dto;
        }
    }

    /** Search for an existing order
     * @param int $id
     * @return OrderTaxi|null
     */
    public function find(int $id): ?OrderTaxi
    {
        $entity = $this->orderTaxiRepository->find($id);
        return OrderMapper::entityToModel($entity);
    }

    /** Order confirmation. Order status changes to executed
     * @param int $id
     */
    public function confirm(int $id): void
    {
        $order = $this->orderTaxiRepository->find($id);
        $order->setStatus(EnumOrderStatus::$static_values[1]);
        $this->orderTaxiRepository->update();
    }

    /** Order cancellation. Order status changes to cancelled. Returns client information
     * @param int $id
     * @return string
     */
    public function cancel(int $id): string
    {
        $order = $this->orderTaxiRepository->find($id);
        $order->setStatus(EnumOrderStatus::$static_values[3]);
        $this->orderTaxiRepository->update();
        return $order->getClient()->toString();
    }

    /** Order update. Order status changes to updated
     * @param OrderDto $orderDto
     * @param int $id
     */
    public function update(OrderDto $orderDto, int $id): void
    {
        $orderModel = $this->getOrder($orderDto);
        $orderEntity = $this->orderTaxiRepository->find($id);
        $orderEntity = OrderMapper::updateEntity($orderEntity, $orderModel);
        $orderEntity->setStatus(EnumOrderStatus::$static_values[4]);
        $this->orderTaxiRepository->updateOrder($orderEntity);
    }


}