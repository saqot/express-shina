<?php

namespace App\Entity;

use App\Repository\ModelProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'product_model', options: ['comment' => 'Модель товара'])]
#[ORM\Entity(repositoryClass: ModelProductRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_NAME_MODEL_TYPE_BRAND2', columns: ['name', 'type_id', 'brand_id'])]

class ModelProductEntity
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private int $id;

	#[ORM\Column(name: 'name', type: 'string', length: 150)]
	private string $name;

	#[ORM\OneToMany(mappedBy: 'model', targetEntity: ProductEntity::class, cascade: ['persist', 'remove'])]
	private Collection $products;

	#[ORM\ManyToOne(targetEntity: TypeProductEntity::class, cascade: ['persist'], inversedBy: 'types')]
	#[ORM\JoinColumn(name: 'type_id', referencedColumnName: 'id', nullable: false)]
	private TypeProductEntity $type;


	#[ORM\ManyToOne(targetEntity: BrandEntity::class, cascade: ['persist'], inversedBy: 'types')]
	#[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id', nullable: false)]
	private BrandEntity $brand;

	public function __construct() {
		$this->products = new ArrayCollection();
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

	public function getProducts(): Collection
	{
		return $this->products;
	}

	public function setProducts(Collection $products): self
	{
		$this->products = $products;
		return $this;
	}

	public function addProduct(ModelProductEntity $product): self
	{
		if (!$this->products->contains($product)) {
			$this->products->add($product);
		}
		return $this;
	}

	public function getType(): TypeProductEntity
	{
		return $this->type;
	}

	public function setType(TypeProductEntity $type): self
	{
		$this->type = $type;
		return $this;
	}

	public function getBrand(): BrandEntity
	{
		return $this->brand;
	}

	public function setBrand(BrandEntity $brand): self
	{
		$this->brand = $brand;
		return $this;
	}

}
