<?php

namespace App\DTO\Product;

class ResponseProductDTO extends ResponseProductDecorator
{
	private ResponseModelProductDTO $model;

	public function __construct(int $id, string $name, ResponseModelProductDTO $model)
	{
		$this->model = $model;
		parent::__construct($id, $name);
	}

	public function getModel(): ResponseModelProductDTO
	{
		return $this->model;
	}

}
