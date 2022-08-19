<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'product', options: ['comment' => 'Товар'])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_NAME_PRODUCT_MODEL', columns: ['name', 'model_id'])]
class ProductEntity
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(name: 'name', type: 'string', length: 150)]
	private string $name;

	#[ORM\ManyToOne(targetEntity: ModelProductEntity::class, cascade: ['persist'], inversedBy: 'products')]
	#[ORM\JoinColumn(name: 'model_id', referencedColumnName: 'id', nullable: false)]
	private ModelProductEntity $model;

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 *
	 * @return ProductEntity
	 */
	public function setId(int $id): ProductEntity
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return ProductEntity
	 */
	public function setName(string $name): ProductEntity
	{
		$this->name = $name;
		return $this;
	}

	public function getModel(): ModelProductEntity
	{
		return $this->model;
	}

	public function setModel(ModelProductEntity $model): ProductEntity
	{
		$this->model = $model;
		return $this;
	}


}

