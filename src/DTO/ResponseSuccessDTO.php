<?php

namespace App\DTO;

class ResponseSuccessDTO
{
	private int $status = 200;
	private string $detail = 'OK';
	private object|array|string $data;

	public function __construct(object|array|string $data)
	{
		$this->data = $data;
	}

	public function getStatus(): int
	{
		return $this->status;
	}

	public function getDetail(): string
	{
		return $this->detail;
	}

	public function getData(): object|array|string
	{
		return $this->data;
	}
}
