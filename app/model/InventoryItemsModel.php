<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.01.2018
 * Time: 22:57
 */

namespace App\Model;


use App\Model\Entity\InventoryItemEntity;
use App\Model\Entity\ItemTypesEntity;
use Nette\Application\UI\Form;

class InventoryItemsModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\InventoryItemEntity';

	/**
	 * @return EntityRepository
	 */
	protected function getR()
	{
		return $this->entityManager->getRepository( $this->entity );
	}

	/**
	 * @param $id
	 * @return null|object
	 */
	public function find( $id, $array = false )
	{
		$entity =  $this->getR()->find($id);
		if( $array ) {
			return $this->arrayMapper( $entity );
		}
		else {
			return $entity;
		}
	}

	/**
	 * @param bool $by
	 * @return array
	 */
	public function getList( $by = false )
	{
		return $this->getR()->findBy(array(), array('id' => 'ASC'));
	}

	/**
	 * @param InventoryItemEntity $entity
	 * @return mixed
	 */
	public function save( InventoryItemEntity $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param InventoryItemEntity $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( InventoryItemEntity $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param InventoryItemEntity $itemTypesEntity
	 * @return array
	 */
	protected function arrayMapper( InventoryItemEntity $inventoryItemEntity = null ) {
		if(!$inventoryItemEntity)
			return false;

		$array_entity = array();
		$array_entity['name'] = $inventoryItemEntity->name;
		$array_entity['code'] = $inventoryItemEntity->code;
		$array_entity['manufacturer'] = $inventoryItemEntity->getManufacturer() ? $inventoryItemEntity->getManufacturer()->getId() : null;
		$array_entity['item_type'] = $inventoryItemEntity->getItem_type() ? $inventoryItemEntity->getItem_type()->getId() : null;
		$array_entity['shop'] = $inventoryItemEntity->getShop() ? $inventoryItemEntity->getshop()->getId() : null;
		$array_entity['create_date'] = $inventoryItemEntity->create_date;
		$array_entity['update_date'] = $inventoryItemEntity->update_date;

		return $array_entity;
	}

	/**
	 * @param InventoryItemEntity $entity
	 */
	public function generateCode( InventoryItemEntity $entity )
	{
		$return = '';
		$create_date = $entity->create_date->format('dmY').$entity->getItem_type()->getCode_part();

		var_dump($create_date);
	}

	public function getSelectList($default_string = 'Vyber položky')
	{
		$array = array();
		$array[0] = $default_string;
		$items = $this->getList();

		foreach ($items as $item) {
			$array[$item->id] = $item->name.'['.$item->code.']';
		}
		return $array;
	}


}