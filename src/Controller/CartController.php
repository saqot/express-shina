<?php

namespace App\Controller;

use App\CardException;
use App\DTO\ResponseErrorDTO;
use App\DTO\ResponseSuccessDTO;
use App\Service\CartService;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
	public CartService $cartService;

	/**
	 * @param CartService $cartService
	 */
	public function __construct(CartService $cartService)
	{
		$this->cartService = $cartService;
	}

	/**
	 * @throws Exception
	 */
	#[Route('/cart', name: 'app.cart_list', methods: ['GET'])]
	public function listProducts()
	{
		$list = $this->cartService->listProducts();

		return $this->json(new ResponseSuccessDTO($list));
	}


	#[Route('/cart/{productId<\d+>}', name: 'app.cart_add', methods: ['POST'])]
	public function addProduct(int $productId)
	{
		try {
			$this->cartService->addProduct($productId);
		} catch (CardException $e) {
			return $this->json(new ResponseErrorDTO($e->getMessage()),500);
		}
		return $this->json(new ResponseSuccessDTO('Товар добавлен в корзину'));
	}


	#[Route('/cart/{productId<\d+>}', name: 'app.cart_delete', methods: ['DELETE'])]
	public function deleteProduct(int $productId)
	{
		try {
			$this->cartService->deleteProduct($productId);
		} catch (CardException $e) {
			return $this->json(new ResponseErrorDTO($e->getMessage()),500);
		}
		return $this->json(new ResponseSuccessDTO('Товар удален из корзины'));
	}

}
