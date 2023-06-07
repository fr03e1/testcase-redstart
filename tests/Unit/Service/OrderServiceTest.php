<?php

namespace App\Tests\Unit\Service;

use App\Entity\Item;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\OrderRepository;
use App\Service\OrderService;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
class OrderServiceTest extends TestCase
{
    private Order $order;
    private ManagerRegistry $managerRegistry;
    private OrderRepository $orderRepository;
    private EntityManager $entityManager;
    private OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->orderRepository = $this->getMockBuilder(OrderRepository::class)
                                        ->setConstructorArgs([$this->managerRegistry])
                                        ->disableArgumentCloning()
                                        ->getMock();


        $this->entityManager = $this->createMock(EntityManager::class);

        $this->orderService = new OrderService($this->orderRepository,$this->entityManager);

        $this->order = new Order();
        $this->order->setName('Alex');
        $this->order->setTotal(1000);
        $this->order->setPhone('+78914212');
        $this->order->setIsPaid(false);

        $orderItem = new OrderItem();
        $orderItem->setPrice(100);
        $orderItem->setQty(2);

        $item = new Item();
        $item->setPrice(100);
        $item->setName('Book');

        $orderItem->setItem($item);
        $this->order->setOrderItems([$orderItem]);
    }

    public function test_get_one_order()
    {
        $this->orderRepository
                ->expects($this->once())
                ->method('findOneBy')
                ->willReturn($this->order);

        $result = $this->orderService->getOrder(1);
        $this->assertEquals($this->order, $result);
    }

    public function test_get_order_with_invalid_id()
    {

        $this->orderRepository
                ->expects($this->once())
                ->method('findOneBy')
                ->willReturn(null);


        $orderService = new OrderService($this->orderRepository,$this->entityManager);

        $result = $this->orderService->getOrder(12);
        $this->assertEquals(null, $result);
    }

    public function test_get_all_orders()
    {

        $order2 = new Order();
        $order2->setIsPaid(false);
        $order2->setPhone('+85435345');
        $order2->setName('Alex2');
        $order2->setTotal(1000);

        $this->orderRepository
                ->expects($this->any())
                ->method('findAll')
                ->willReturn([$this->order,$order2]);

        $em = $this->createMock(EntityManager::class);


        $result = $this->orderService->getAllOrders();

        $this->assertEquals($result, $result);
    }

    public function test_add_order()
    {

        $this->orderRepository
                ->expects($this->any())
                ->method('save');

        $result = $this->orderService->addOrder($this->order);

        $this->assertEquals($this->order, $result);
    }

    public function test_update_order()
    {
       $this->order->setName('newName');
        $this->order->setTotal(1000);
        $this->order->setPhone('+78914212');
        $this->order->setIsPaid(false);

        $orderItem = new OrderItem();
        $orderItem->setPrice(100);
        $orderItem->setQty(2);

        $item = new Item();
        $item->setPrice(12);
        $item->setName('Phone');

        $orderItem->setItem($item);
        $this->order->setOrderItems([$orderItem]);

        $this->orderRepository
                ->expects($this->any())
                ->method('save');

        $this->entityManager->expects($this->once())
            ->method('getConnection')
            ->willReturn($this->entityManager);


        $result = $this->orderService->updatedOrder($this->order);

        $this->assertEquals($this->order, $result);
    }

    public function update_with_several_fields()
    {

        $this->order->setName('New Name');
        $this->order->setTotal(1);
        $this->order->setPhone('+7819123412');
        $this->order->setIsPaid(false);


        $this->orderRepository
                ->expects($this->any())
                ->method('save');

        $this->entityManager->expects($this->once())
                ->method('getConnection')
                ->willReturn($this->entityManager);


        $result = $this->orderService->updatedOrder($this->order);

        $this->assertEquals($this->order, $result);
    }

    public function test_delete_with_invalid_id()
    {

        $this->orderRepository
                ->expects($this->any())
                ->method('remove');

        $result = $this->orderService->deleteOrder(12);

        $this->assertEquals(null, $result);
    }


    public function test_delete_order()
    {

        $this->orderRepository->method('findOneBy')->id('1')->willReturn($this->order);

        $result = $this->orderService->deleteOrder(1);
        $this->assertEquals('success',$result);

    }

    public function test_check_payment()
    {
        $this->orderRepository->method('find')->willReturn($this->order);
        $result = $this->orderService->checkPayment(1,1000);
        $this->assertEquals('success',$result);
    }

    public function test_check_payment_with_invalid_id()
    {
        $this->orderRepository->method('find')->willReturn(null);
        $result = $this->orderService->checkPayment(1,1000);
        $this->assertEquals(null,$result);
    }

    public function test_check_payment_with_invalid_payment()
    {
        $this->orderRepository->method('find')->willReturn($this->order);
        $result = $this->orderService->checkPayment(1,10);
        $this->assertEquals('Error',$result);
    }
}