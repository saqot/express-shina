<?php

namespace App\Tests\Entity;

use App\Entity\TypeProductEntity;
use App\Tests\FakerEntity;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class TypeProductEntityTest extends KernelTestCaseEntity
{
	use FakerEntity;

	/**
	 * Проверяем создание типа товара
	 */
	public function testNewType(): void
	{
		$type = $this->buildTypeProduct();
		$this->em->persist($type);

		$this->em->flush();

		$el = $this->em->getRepository(TypeProductEntity::class)->findOneBy(['name' => $type->getName()]);
		$this->assertIsObject($el, "Ожидаем созданный элемент #{$type->getId()} / {$type->getName()}");

		$this->assertEquals($el, $type, 'Ожидаем одинаковый объект товара');
	}

	public function testNewTypeNullName(): void
	{
		$type = new TypeProductEntity();
		$this->em->persist($type);

		$this->expectException(NotNullConstraintViolationException::class);
		$this->expectExceptionMessageMatches("/Column 'name' cannot be null/");
		$this->em->flush();
	}

	/**
	 * Проверяем невозможность дубля имени
	 */
	public function testNewTypeNotUnique(): void
	{
		$type = $this->buildTypeProduct();
		$this->em->persist($type);
		$this->em->persist(clone $type);

		$this->expectException(UniqueConstraintViolationException::class);
		$this->em->flush();
	}


	public function testAddModel()
	{
		$type = $this->buildTypeProduct();

		for ($i = 1; $i <= 10; $i++) {
			$model = $this->buildModelProduct("#$i");
			$type->addModel($model);
		}

		$this->em->persist($type);
		$this->em->flush();

		/** @var $el TypeProductEntity */
		$el = $this->em->getRepository(TypeProductEntity::class)->findOneBy(['name' => $type->getName()]);
		$this->assertIsObject($el, "Ожидаем созданный элемент #{$type->getId()} / {$type->getName()}");

		$this->assertEquals(10, $el->getModels()->count(), 'Ожидаем 10 привязанных моделей');
	}
}

