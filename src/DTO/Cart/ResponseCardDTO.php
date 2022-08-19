<?php

namespace App\DTO\Cart;


use App\DTO\Product\ResponseProductDTO;

class ResponseCardDTO
{

	private float $cost;
	private ResponseProductDTO $product;


	public function __construct(float $cost, ResponseProductDTO $product)
	{
		$this->cost = $cost;
		$this->product = $product;

	}


	public function getCost(): float
	{
		return $this->cost;
	}

	public function getProduct(): ResponseProductDTO
	{
		return $this->product;
	}



}
