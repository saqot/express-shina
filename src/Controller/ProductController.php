<?php

namespace App\Controller;

use App\DTO\ResponseNotFoundDTO;
use App\DTO\ResponseSuccessDTO;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
	/**
	 * @throws Exception
	 */
	#[Route('/{typeId<\d+>}', name: 'app.product', defaults: ['typeId' => null], methods: ['GET'])]
	public function listProduct(?int $typeId, ProductRepository $productRepo)
	{
		$list = $productRepo->getListForResponse($typeId);

		if ($typeId and !$list) {
			return $this->json(new ResponseNotFoundDTO("Товара с типом #{$typeId} не найдено"), 404);
		}

		return $this->json(new ResponseSuccessDTO($list));
	}
}