<?php

namespace App\Tests\Entity;

use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class KernelTestCaseEntity extends KernelTestCase
{
	protected ?ObjectManager $em;

	/**
	 * @throws Exception
	 */
	public function setUp(): void
	{
		$kernel = self::bootKernel();
		$this->em = $kernel->getContainer()->get('doctrine')->getManager();

		parent::setUp();
	}

	protected function tearDown(): void
	{
		parent::tearDown();

		$this->em->close();
		$this->em = null;
	}

}