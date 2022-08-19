<?php

namespace App\DTO;

class ResponseErrorDTO
{
	private int $status = 500;
	private string $detail = 'ERROR';
	private string $data;

	public function __construct(string $message)
	{
		$this->data = $message;
	}

	public function getStatus(): int
	{
		return $this->status;
	}

	public function getDetail(): string
	{
		return $this->detail;
	}

	public function getData(): string
	{
		return $this->data;
	}
}
