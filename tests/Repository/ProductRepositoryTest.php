<?php

namespace App\Tests\Repository;

use App\DTO\Product\ResponseProductDTO;
use App\Entity\ProductEntity;
use App\Tests\Entity\KernelTestCaseEntity;
use App\Tests\FakerEntity;

class ProductRepositoryTest extends KernelTestCaseEntity
{
	use FakerEntity;

	public function testGetListForResponse()
	{
		$product = $this->buildProduct();
		$this->em->persist($product);

		for ($i = 1; $i <= 10; $i++) {
			$this->em->persist($this->buildProduct($i));
		}

		$this->em->flush();

		$el = $this->em->getRepository(ProductEntity::class)->getListForResponse($product->getModel()->getType()->getId());
		$this->assertIsArray($el, 'Ожидаем массив');
		$this->assertCount(1, $el, 'Должен быть один отфильтрованный элемент');

		$this->assertEquals($el[0]->getModel()->getType()->getId(),
			$product->getModel()->getType()->getId(),
			"Ожидаем объект типа #{$product->getModel()->getType()->getId()}");
	}

	public function testGetListForResponseNullTypeId()
	{
		for ($i = 1; $i <= 10; $i++) {
			$this->em->persist($this->buildProduct($i));
		}
		$this->em->flush();

		$el = $this->em->getRepository(ProductEntity::class)->getListForResponse(null);
		$this->assertIsArray($el, 'Ожидаем массив');
		$this->assertCount(10, $el, 'Должено быть 10 элементов');

		$this->assertInstanceOf(ResponseProductDTO::class, $el[0], "Ожидаем объект товара ResponseProductDTO");

	}
}

