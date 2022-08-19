<?php

namespace App\Repository;

use App\DTO\Product\ResponseBrandDTO;
use App\DTO\Product\ResponseModelProductDTO;
use App\DTO\Product\ResponseProductDTO;
use App\DTO\Product\ResponseTypeProductDTO;
use App\Entity\ProductEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, ProductEntity::class);
	}

	/**
	 * @return array|ResponseProductDTO[]
	 * @throws Exception
	 */
	public function getListForResponse(?int $typeId): array
	{
		if ($typeId) {
			$whereTypeId = "WHERE `model`.type_id = {$typeId}";
		} else {
			$whereTypeId = '';
		}

		$sql = "SELECT
                p.id,
                p.name,
                model.id AS `model.id`,
                model.name AS `model.name`,
                type.id AS `type.id`,
                type.name AS `type.name`,
                brand.id AS `brand.id`,
                brand.name AS `brand.name`
            FROM
                product p
            LEFT JOIN `product_model` `model` ON `model`.id = `p`.model_id
            LEFT JOIN `product_type` `type` ON `type`.id = `model`.type_id
            LEFT JOIN `brand` ON `brand`.id = `model`.brand_id
			{$whereTypeId}
            ";

		$items = $this->_em->getConnection()->fetchAllAssociative($sql);

		// здесь по сути необходимо через билдер делать, что бы четко контролировать тестами, но в рамках текущего ТЗ не стал
		foreach ($items as $i => $item) {
			$brand = new ResponseBrandDTO($item['brand.id'], $item['brand.name']);
			$type = new ResponseTypeProductDTO($item['type.id'], $item['type.name']);
			$model = new ResponseModelProductDTO($item['type.id'], $item['type.name'], $type,$brand);
			$product = new ResponseProductDTO($item['id'], $item['name'], $model);
			$items[$i] = $product;
		}

		return $items;
	}

}
