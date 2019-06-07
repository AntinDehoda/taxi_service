<?php


namespace App\Service\Order;


use App\DBAL\EnumOrderStatus;
use App\Form\DTO\OrderDto;
use App\Mapper\DistrictMapper;
use App\Mapper\OrderMapper;
use App\Mapper\TaxiMapper;
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

    private function getOrder(OrderDto $orderDto): OrderTaxi
    {
        $clientModel = $this->clientService->find($orderDto->phone);

        if (null == $clientModel) {
            $clientModel =
                $this->clientService
                    ->create($orderDto->phone, $orderDto->firstName, $orderDto->lastName);
        }
        $district = DistrictMapper::entityToModel($orderDto->district);
        $addressFromId =
            $this->addressService
                ->get($orderDto->streetFrom, $orderDto->streetFromNumber, $district);

        $addressToId = null;
        if ($orderDto->streetTo) {
            $addressToId =
                $this->addressService
                    ->get($orderDto->streetTo, $orderDto->streetToNumber, null);
        }
        $taxiEntity = $this->taxiRepository->findByDistrict($district->getId());
        $taxiModel = TaxiMapper::entityToModel($taxiEntity);
        return new OrderTaxi($clientModel, $addressFromId, $addressToId, $taxiModel, null);
    }
    public function createOrder(OrderDto $orderDto): OrderTaxi
    {
        $orderModel = $this->getOrder($orderDto);
        $entity = $this->orderTaxiRepository->save(OrderMapper::modelToEntity($orderModel));
        return OrderMapper::entityToModel($entity);

    }

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

    public function find(int $id): ?OrderTaxi
    {
        $entity = $this->orderTaxiRepository->find($id);
        return OrderMapper::entityToModel($entity);
    }

    public function confirm(int $id): void
    {
        $order = $this->orderTaxiRepository->find($id);
        $order->setStatus(EnumOrderStatus::$static_values[1]);
        $this->orderTaxiRepository->update();
    }

    public function cancel(int $id): string
    {
        $order = $this->orderTaxiRepository->find($id);
        $order->setStatus(EnumOrderStatus::$static_values[3]);
        $this->orderTaxiRepository->update();
        return $order->getClient()->toString();
    }

    public function update(OrderDto $orderDto, int $id): void
    {
        $orderModel = $this->getOrder($orderDto);
        $orderEntity = $this->orderTaxiRepository->find($id);
        $orderEntity = OrderMapper::updateEntity($orderEntity, $orderModel);
        $orderEntity->setStatus(EnumOrderStatus::$static_values[4]);
        $this->orderTaxiRepository->updateOrder($orderEntity);


    }


}