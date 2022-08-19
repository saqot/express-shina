<?php

namespace App\DTO;

class ResponseNotFoundDTO
{
	private int $status = 404;
	private string $detail = 'NOT found';
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
