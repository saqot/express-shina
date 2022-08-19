<?php

namespace App\DTO\Product;

interface ResponseProductInterface
{
	public function getId(): int;
	public function getName(): string;
}