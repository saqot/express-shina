<?php

namespace App\DataFixtures;

use App\Entity\BrandEntity;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends FixtureDecorator
{
	public function load(ObjectManager $manager)
	{
		for ($i = 0; $i < 25; $i++) {
			$brand = (new BrandEntity())->setName("type #$i");

			$manager->persist($brand);
			$manager->flush();
			$this->addReference($this->buildBrandNameReference($i), $brand);
		}

	}
}
