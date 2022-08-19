<?php

namespace App\Tests\Controller;

use App\Tests\FakerEntity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CartControllerTest extends WebTestCase
{
	use FakerEntity;

	public function testAddProduct()
	{
		$client = static::createClient();

		$em = $client->getContainer()->get('doctrine')->getManager();
		$router = $client->getContainer()->get('router');

		$product = $this->buildProduct();
		$em->persist($product);
		$em->flush();

		$urlActual = $router->generate('app.cart_add', ['productId' => $product->getId()]);
		$client->jsonRequest('POST', $urlActual);
		$this->assertResponseIsSuccessful();
	}

	public function testAddProductNotFound()
	{
		$client = static::createClient();
		$router = $client->getContainer()->get('router');

		$urlActual = $router->generate('app.cart_add', ['productId' => 123000]);
		$client->jsonRequest('POST', $urlActual);
		$this->assertEquals(500, $client->getResponse()->getStatusCode(), "ждем 500 от url: {$urlActual}");
	}


	public function testDeleteProduct()
	{
		$client = static::createClient();

		$em = $client->getContainer()->get('doctrine')->getManager();
		$router = $client->getContainer()->get('router');

		$product = $this->buildProduct();
		$em->persist($product);
		$em->flush();

		$urlActual = $router->generate('app.cart_add', ['productId' => $product->getId()]);
		$client->jsonRequest('POST', $urlActual);
		$this->assertResponseIsSuccessful();


		$urlActual = $router->generate('app.cart_delete', ['productId' => $product->getId()]);
		$client->jsonRequest('DELETE', $urlActual);

		$this->assertResponseIsSuccessful();
	}

	public function testDeleteProductNotFound()
	{
		$client = static::createClient();
		$router = $client->getContainer()->get('router');

		$urlActual = $router->generate('app.cart_delete', ['productId' => 11220044]);
		$client->jsonRequest('DELETE', $urlActual);
		$this->assertEquals(500, $client->getResponse()->getStatusCode(), "ждем 500 от url: {$urlActual}");
	}
}

