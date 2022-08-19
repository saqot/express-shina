<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;

abstract class FixtureDecorator extends Fixture
{
	public function buildBrandNameReference(string $suff): string
	{
		return "brand_product_{$suff}";
	}

	public function buildTypeNameReference(string $suff): string
	{
		return "type_product_{$suff}";
	}

	public function buildModelNameReference(string $suff): string
	{
		return "model_product_{$suff}";
	}

	public function buildProductNameReference(string $suff): string
	{
		return "product_{$suff}";
	}
}
