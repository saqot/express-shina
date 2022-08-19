<?php

namespace App\DataFixtures;

use App\Entity\TypeProductEntity;
use Doctrine\Persistence\ObjectManager;

class TypeProductFixtures extends FixtureDecorator
{
	public function load(ObjectManager $manager)
	{
		for ($i = 0; $i < 25; $i++) {
			$type = (new TypeProductEntity())->setName("type #$i");

			$manager->persist($type);
			$manager->flush();
			$this->addReference($this->buildTypeNameReference($i), $type);
		}

	}
}
