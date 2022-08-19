<?php

namespace App\DTO\Product;

class ResponseModelProductDTO extends ResponseProductDecorator
{
	private ResponseTypeProductDTO $type;
	private ResponseBrandDTO $brand;

	public function __construct(int $id, string $name, ResponseTypeProductDTO $type, ResponseBrandDTO $brand)
	{
		$this->type = $type;
		$this->brand = $brand;
		parent::__construct($id, $name);
	}

	public function getType(): ResponseTypeProductDTO
	{
		return $this->type;
	}

	public function getBrand(): ResponseBrandDTO
	{
		return $this->brand;
	}
}
