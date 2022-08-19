<?php

namespace App\DTO\Cart;


class ResponseCardsDTO
{
	private int $count = 0;
	private float $totalCost = 0;
	/**
	 * @var array|ResponseCardDTO[]
	 */
	private array $list = [];

	public function getCount(): int
	{
		return $this->count;
	}

	public function getTotalCost(): float
	{
		return round($this->totalCost, 3);
	}


	/**
	 * @return array|ResponseCardDTO[]
	 */
	public function getList(): array
	{
		return $this->list;
	}


	public function attToList(ResponseCardDTO $card): self
	{
		$this->count ++;
		$this->totalCost += $card->getCost();
		$this->list[] = $card;
		return $this;
	}


}
