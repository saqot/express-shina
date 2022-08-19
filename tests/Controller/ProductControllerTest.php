<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{

	public function testListProduct()
	{
		$client = static::createClient();
		$router = $client->getContainer()->get('router');

		$urlActual = $router->generate('app.product');
		$client->jsonRequest('GET', $urlActual);

		$this->assertResponseIsSuccessful();
	}

	public function testListProduct404()
	{
		$client = static::createClient();
		$router = $client->getContainer()->get('router');

		$urlActual = $router->generate('app.product', ['typeId' => '1231000123']);
		$client->jsonRequest('GET', $urlActual);

		$this->assertEquals(404, $client->getResponse()->getStatusCode(), "ждем 404 от url: {$urlActual}");
	}

	public function testListProductPost()
	{
		$client = static::createClient();
		$router = $client->getContainer()->get('router');

		$urlActual = $router->generate('app.product');
		$client->jsonRequest('POST', $urlActual);

		$this->assertEquals(405, $client->getResponse()->getStatusCode(), "ждем 405 от POST запроса на url: {$urlActual}");
	}
}

