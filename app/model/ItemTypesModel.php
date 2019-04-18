<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.01.2018
 * Time: 22:57
 */

namespace App\Model;


use App\Model\Entity\ItemTypesEntity;

class ItemTypesModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\ItemTypesEntity';

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
	 * @param ItemTypesEntity $entity
	 * @return mixed
	 */
	public function save( ItemTypesEntity $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param ItemTypesEntity $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( ItemTypesEntity $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param ItemTypesEntity $itemTypesEntity
	 * @return array
	 */
	protected function arrayMapper( ItemTypesEntity $itemTypesEntity = null ) {
		if(!$itemTypesEntity)
			return false;

		$array_entity = array();
		$array_entity['name'] = $itemTypesEntity->name;
		$array_entity['code_part'] = $itemTypesEntity->code_part;
		$array_entity['inventory_items'] = $itemTypesEntity->inventory_items;

		return $array_entity;
	}

	public function getSelectList($default_string = 'Vyber typ')
	{
		$array = array();
		$array[0] = $default_string;
		$types = $this->getList();

		foreach ($types as $type) {
			$array[$type->id] = $type->name.' ['.$type->code_part.']';
		}
		return $array;
	}
}