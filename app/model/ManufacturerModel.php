<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16.01.2018
 * Time: 12:53
 */

namespace App\Model;


use App\Model\Entity\ManufacturerEntity;

class ManufacturerModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\ManufacturerEntity';

	/**
	 * @return EntityRepository
	 */
	protected function getR()
	{
		return $this->entityManager->getRepository($this->entity);
	}

	/**
	 * @param $id
	 * @return null|object
	 */
	public function find($id, $array = false)
	{
		$entity = $this->getR()->find($id);
		if ($array) {
			return $this->arrayMapper($entity);
		} else {
			return $entity;
		}
	}

	/**
	 * @param bool $by
	 * @return array
	 */
	public function getList($by = false)
	{
		return $this->getR()->findBy(array(), array('id' => 'ASC'));
	}

	/**
	 * @param ManufacturerEntity $entity
	 * @return mixed
	 */
	public function save(ManufacturerEntity $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param ManufacturerEntity $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(ManufacturerEntity $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param ManufacturerEntity $manufacturerEntity
	 * @return array
	 */
	protected function arrayMapper(ManufacturerEntity $manufacturerEntity = null)
	{
		if (!$manufacturerEntity)
			return false;

		$array_entity = array();
		$array_entity['name'] = $manufacturerEntity->name;

		return $array_entity;
	}

	public function getSelectList($default_string = 'Vyber výrobce')
	{
		$array = array();
		$array[0] = $default_string;
		$manufacturers = $this->getList();

		foreach ($manufacturers as $manufacturer) {
			$array[$manufacturer->id] = $manufacturer->name;
		}
		return $array;
	}
}