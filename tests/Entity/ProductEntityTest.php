<?php

namespace App\Tests\Entity;

use App\Entity\ProductEntity;
use App\Entity\ModelProductEntity;
use App\Tests\FakerEntity;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;


class ProductEntityTest extends KernelTestCaseEntity
{
	use FakerEntity;

	/**
	 * Проверяем создание товара
	 */
	public function testNewProduct(): void
	{
		$product = $this->buildProduct();
		$this->em->persist($product);

		$this->em->flush();

		/** @var $el ProductEntity */
		$el = $this->em->getRepository(ProductEntity::class)->findOneBy(['name' => $product->getName()]);
		$this->assertIsObject($el, "Ожидаем созданный элемент #{$product->getId()} / {$product->getName()}");

		$this->assertEquals($el, $product, 'Ожидаем одинаковый объект товара');
	}

	/**
	 * Создаем двух товаров с разнымим именами, но одинаковыми моделями
	 */
	public function testNewTwoModels(): void
	{
		$product = $this->buildProduct();
		$productTwo = clone $product;
		$productTwo->setName('name product two');

		$this->em->persist($product);
		$this->em->persist($productTwo);

		$this->em->flush();

		/** @var $el ModelProductEntity */
		$el = $this->em->getRepository(ProductEntity::class)->findOneBy(['name' => $product->getName()]);
		$this->assertIsObject($el, "Ожидаем созданный элемент #{$product->getId()} / {$product->getName()}");

		$this->assertEquals($el, $product, 'Ожидаем одинаковый объект товара');

		/** @var $elTwo ModelProductEntity */
		$elTwo = $this->em->getRepository(ProductEntity::class)->findOneBy(['name' => $productTwo->getName()]);
		$this->assertIsObject($elTwo, "Ожидаем созданный элемент two #{$productTwo->getId()} / {$productTwo->getName()}");

		$this->assertEquals($elTwo, $productTwo, 'Ожидаем одинаковый объект товара two');
	}

	/**
	 * Проверяем создание товара без модели.
	 */
	public function testAddNullModel(): void
	{
		$product = (new ProductEntity())->setName('product name');
		$this->em->persist($product);

		$this->expectException(NotNullConstraintViolationException::class);
		$this->expectExceptionMessageMatches("/Column 'model_id' cannot be null/");
		$this->em->flush();
	}

	/**
	 * Проверяем на Unique Exception, при попытке создать товар с одним именем и одной моделью
	 */
	public function testAddNotUniqueModel(): void
	{
		$product = $this->buildProduct();
		$this->em->persist($product);
		$this->em->persist(clone $product);

		$this->expectException(UniqueConstraintViolationException::class);
		$this->expectExceptionMessageMatches("/Duplicate entry 'product/");
		$this->em->flush();
	}

}

