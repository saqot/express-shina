<?php

namespace App\Controller;

use App\DTO\ResponseSuccessDTO;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController
{
	#[Route('/cart/{typeId<\d+>}', name: 'app.product', defaults: ['typeId' => null], methods: ['GET'])]
	public function listProduct(?int $typeId, Request $request, ProductRepository $productRepo)
	{

		//$session = $request->getSession();
		//$session->set('foo', (new ProductEntity())->setName('cart'));
		//
		//$foo = $session->get('foo');
		//dd($typeId);
		return $this->json(new ResponseSuccessDTO([]));
	}
}
