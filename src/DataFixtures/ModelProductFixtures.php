<?php

namespace App\DataFixtures;

use App\Entity\ModelProductEntity;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModelProductFixtures extends FixtureDecorator implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		for ($i = 0; $i < 20; $i++) {
			$model = (new ModelProductEntity())
				->setName("model #$i")
				->setType($this->getReference($this->buildTypeNameReference(rand(0, 20))))
				->setBrand($this->getReference($this->buildBrandNameReference(rand(0, 20))));

			$manager->persist($model);
			$manager->flush();

			$this->addReference($this->buildModelNameReference($i), $model);
		}
	}

	public function getDependencies()
	{
		return [
			TypeProductFixtures::class,
			BrandFixtures::class,
		];
	}
}
