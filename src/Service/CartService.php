<?php

namespace App\Service;

use App\CardException;
use App\DTO\Cart\ResponseCardDTO;
use App\DTO\Cart\ResponseCardsDTO;
use App\DTO\Product\ResponseProductDTO;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;


class CartService
{
	private Session $session;
	private ProductRepository $productRepo;
	private string $ssid;


	public function __construct(RequestStack $requestStack, ProductRepository $productRepo)
	{
		$this->session = $requestStack->getSession();
		$this->productRepo = $productRepo;

		$ssid = $this->session->getId();
		if (!$ssid) {
			$this->session->start();
			$ssid = $this->session->getId();
		}
		$this->ssid = $ssid;
	}


	/**
	 * @throws Exception
	 */
	public function listProducts(): ResponseCardsDTO
	{
		$responseCards = new ResponseCardsDTO();

		$cards = $this->session->get($this->ssid, []);

		if ($cards) {
			$pids = array_column($cards, 'productId');
			$products = $this->productRepo->getListForCard($pids);

			foreach ($cards as $card) {
				$product = array_filter($products, function (ResponseProductDTO $product) use ($card) {
					return $product->getId() == $card['productId'];
				});

				if ($product) {
					$responseCards->attToList(new ResponseCardDTO($card['cost'], reset($product)));
				}
			}

		}


		return $responseCards;
	}

	/**
	 * @throws CardException
	 */
	public function addProduct(int $productId)
	{
		if (!$this->productRepo->isExistCard($productId)) {
			throw new CardException("Товара с ID {$productId} не существует");
		}

		$cards = $this->session->get($this->ssid, []);

		if ($cards) {
			// логика не обязательная, но допустим будет так
			// ------------------------------------------------
			$found = array_filter($cards, function (array $card) use ($productId) {
				return $productId == $card['productId'];
			});

			if ($found) {
				throw new CardException("В корзине уже есть товар с ID {$productId}");
			}
			// ------------------------------------------------
		}


		$cards[] =  ['cost' => rand(10, 1000), 'productId' => $productId];

		$this->session->set($this->ssid, $cards);
	}

	/**
	 * @throws CardException
	 */
	public function deleteProduct(int $productId)
	{
		$cards = $this->session->get($this->ssid, []);

		$found = array_filter($cards, function (array $card) use ($productId) {
			return $productId == $card['productId'];
		});

		if (!$found) {
			throw new CardException("В корзине нет товара с ID {$productId}");
		}

		$cards = array_filter($cards, function (array $card) use ($productId) {
			return $productId != $card['productId'];
		});

		$this->session->set($this->ssid, $cards);
	}
}
