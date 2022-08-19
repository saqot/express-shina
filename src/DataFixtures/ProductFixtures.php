<?php

namespace App\DataFixtures;

use App\Entity\ProductEntity;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends FixtureDecorator implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		for ($i = 0; $i < 15; $i++) {
			$product = (new ProductEntity())
				->setName("product #$i")
				->setModel($this->getReference($this->buildModelNameReference(rand(0, 15))));
			$manager->persist($product);
		}

		$manager->flush();


	}

	public function getDependencies()
	{
		return [
			ModelProductFixtures::class,
		];
	}
}