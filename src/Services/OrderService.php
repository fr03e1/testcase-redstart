<?php

namespace App\Services;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityNotFoundException;

class OrderService
{
    public function __construct(
            private OrderRepository $orderRepository,
    )
    {
    }

    public function getOrder(int $orderId): Order
    {
        $order = $this->orderRepository->find($orderId);
        if(!$order) {
            throw new EntityNotFoundException('Заказ с id ' . $orderId . ' не существует');
        }

        return $order;
    }

    public function getAllOrders(): ?array
    {
        return $this->orderRepository->findAll();
    }

//    public function addOrder(OrderDTO $orderDTO): Order
//    {
//        $this->orderRepository->save($order);
//        return $order;
//    }

//    public function updateArticle(int $articleId, ArticleDTO $articleDTO): Article
//    {
//        $article = $this->articleRepository->findById($articleId);
//        if (!$article) {
//            throw new EntityNotFoundException('Article with id '.$articleId.' does not exist!');
//        }
//        $article = $this->articleAssembler->updateArticle($article, $articleDTO);
//        $this->articleRepository->save($article);
//
//        return $article;
//    }

//    public function deleteArticle(int $articleId): void
//    {
//        $article = $this->articleRepository->findById($articleId);
//        if (!$article) {
//            throw new EntityNotFoundException('Article with id '.$articleId.' does not exist!');
//        }
//
//        $this->articleRepository->delete($article);
//    }
}