<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'brand', options: ['comment' => 'Производители'])]
#[ORM\Entity(repositoryClass: BrandRepository::class)]
class BrandEntity
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(name: 'name', type: 'string', length: 150, unique: true)]
	private string $name;

	#[ORM\OneToMany(mappedBy: 'brand', targetEntity: ModelProductEntity::class, cascade: ['persist', 'remove'])]
	private Collection $models;

	public function __construct() {
		$this->models = new ArrayCollection();
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}

	public function getModels(): Collection
	{
		return $this->models;
	}

	public function setModels(Collection $models): self
	{
		$this->models = $models;
		return $this;
	}

	public function addModel(ModelProductEntity $model): self
	{
		if (!$this->models->contains($model)) {
			$this->models->add($model);
		}
		return $this;
	}

}
