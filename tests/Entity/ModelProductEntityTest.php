<?php

namespace App\Tests\Entity;

use App\Entity\ModelProductEntity;
use App\Tests\FakerEntity;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * +-----------------------------------------------------
 * + Saqot (Mihail Shirnin) <saqott@gmail.com>
 * + 18.08.2022
 * +-----------------------------------------------------
 */
class ModelProductEntityTest extends KernelTestCaseEntity
{
	use FakerEntity;

	/**
	 * Проверяем создание типа товара
	 */
	public function testNewModel(): void
	{
		$model = $this->buildModelProduct();
		$this->em->persist($model);

		$this->em->flush();

		/** @var $el ModelProductEntity */
		$el = $this->em->getRepository(ModelProductEntity::class)->findOneBy(['name' => $model->getName()]);
		$this->assertIsObject($el, "Ожидаем созданный элемент #{$model->getId()} / {$model->getName()}");

		$this->assertEquals($el, $model, 'Ожидаем одинаковый объект товара');
	}

	/**
	 * Создаем две модели с разнымим именами, но одинаковыми типом и производителем
	 */
	public function testNewTwoModels(): void
	{
		$model = $this->buildModelProduct();
		$modelTwo = clone $model;
		$modelTwo->setName('name model two');

		$this->em->persist($model);
		$this->em->persist($modelTwo);

		$this->em->flush();

		/** @var $el ModelProductEntity */
		$el = $this->em->getRepository(ModelProductEntity::class)->findOneBy(['name' => $model->getName()]);
		$this->assertIsObject($el, "Ожидаем созданный элемент #{$model->getId()} / {$model->getName()}");

		$this->assertEquals($el, $model, 'Ожидаем одинаковый объект модели');

		/** @var $elTwo ModelProductEntity */
		$elTwo = $this->em->getRepository(ModelProductEntity::class)->findOneBy(['name' => $modelTwo->getName()]);
		$this->assertIsObject($elTwo, "Ожидаем созданный элемент two #{$modelTwo->getId()} / {$modelTwo->getName()}");

		$this->assertEquals($elTwo, $modelTwo, 'Ожидаем одинаковый объект модели two');
	}


	public function testNewModelNullName(): void
	{
		$model = new ModelProductEntity();
		$this->em->persist($model);

		$this->expectException(NotNullConstraintViolationException::class);
		$this->expectExceptionMessageMatches("/Column 'name' cannot be null/");
		$this->em->flush();
	}

	public function testNewModelNullType(): void
	{
		$model = (new ModelProductEntity())
			->setName('model name')
			->setBrand($this->buildBrand());
		$this->em->persist($model);

		$this->expectException(NotNullConstraintViolationException::class);
		$this->expectExceptionMessageMatches("/Column 'type_id' cannot be null/");
		$this->em->flush();
	}

	public function testNewModelNullBrand(): void
	{
		$model = (new ModelProductEntity())
			->setName('model name')
			->setType($this->buildTypeProduct());
		$this->em->persist($model);

		$this->expectException(NotNullConstraintViolationException::class);
		$this->expectExceptionMessageMatches("/Column 'brand_id' cannot be null/");
		$this->em->flush();
	}

	/**
	 * Проверяем невозможность дубля имени
	 */
	public function testNewTypeNotUniqueType(): void
	{
		$model = $this->buildModelProduct();
		$this->em->persist($model);
		$this->em->persist(clone $model);

		$this->expectException(UniqueConstraintViolationException::class);
		$this->expectExceptionMessageMatches("/Duplicate entry 'model/");
		$this->em->flush();
	}

}

