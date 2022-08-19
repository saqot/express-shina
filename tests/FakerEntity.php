<?php

namespace App\Tests;

use App\Entity\BrandEntity;
use App\Entity\ModelProductEntity;
use App\Entity\ProductEntity;
use App\Entity\TypeProductEntity;


trait FakerEntity
{
	private string $brandName = 'brand name';
	private string $typeName = 'type name';
	private string $modelName = 'model name';
	private string $productName = 'product name';

	public function buildBrand(?string $nameSuff = null):BrandEntity
	{
		return (new BrandEntity())->setName( $this->brandName . $nameSuff ?: '');
	}

	public function buildTypeProduct(?string $nameSuff = null):TypeProductEntity
	{
		return (new TypeProductEntity())->setName($this->typeName . $nameSuff ?: '');
	}

	public function buildModelProduct(?string $nameSuff = null):ModelProductEntity
	{
		return (new ModelProductEntity())
			->setName($this->modelName . $nameSuff ?: '')
			->setBrand($this->buildBrand($nameSuff))
			->setType($this->buildTypeProduct($nameSuff))
			;
	}

	public function buildProduct(?string $nameSuff = null):ProductEntity
	{
		return (new ProductEntity())
			->setName($this->productName . $nameSuff ?: '')
			->setModel($this->buildModelProduct($nameSuff))
			;
	}
}
