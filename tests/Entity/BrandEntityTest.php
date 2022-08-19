<?php

namespace App\Tests\Entity;

use App\Entity\BrandEntity;
use App\Tests\FakerEntity;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class BrandEntityTest extends KernelTestCaseEntity
{
	use FakerEntity;

	/**
	 * Проверяем создание производителя
	 */
	public function testNewBrand(): void
	{
		$brand = $this->buildBrand();
		$this->em->persist($brand);

		$this->em->flush();

		$el = $this->em->getRepository(BrandEntity::class)->findOneBy(['name' => $brand->getName()]);
		$this->assertIsObject($el, "Ожидаем созданный элемент #{$brand->getId()} / {$brand->getName()}");

		$this->assertEquals($el, $brand, 'Ожидаем одинаковый объект производителя');
	}

	public function testNewBrandNullName(): void
	{
		$brand = new BrandEntity();
		$this->em->persist($brand);

		$this->expectException(NotNullConstraintViolationException::class);
		$this->expectExceptionMessageMatches("/Column 'name' cannot be null/");
		$this->em->flush();
	}

	/**
	 * Проверяем невозможность дубля имени
	 */
	public function testNewBrandNotUnique(): void
	{
		$brand = $this->buildBrand();
		$this->em->persist($brand);
		$this->em->persist(clone $brand);

		$this->expectException(UniqueConstraintViolationException::class);
		$this->em->flush();
	}

	public function testAddModel()
	{
		$brand = $this->buildBrand();

		for ($i = 1; $i <= 10; $i++) {
			$model = $this->buildModelProduct("#$i");
			$brand->addModel($model);
		}

		$this->em->persist($brand);
		$this->em->flush();
		/** @var $el BrandEntity */
		$el = $this->em->getRepository(BrandEntity::class)->findOneBy(['name' => $brand->getName()]);
		$this->assertIsObject($el, "Ожидаем созданный элемент #{$brand->getId()} / {$brand->getName()}");

		$this->assertEquals(10, $el->getModels()->count(), 'Ожидаем 10 привязанных моделей');
	}
}

