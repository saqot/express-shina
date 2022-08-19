<?php

namespace App\DTO\Product;

abstract class ResponseProductDecorator implements ResponseProductInterface
{
	protected int $id;
	protected string $name;

	public function __construct(int $id, string $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}
}
