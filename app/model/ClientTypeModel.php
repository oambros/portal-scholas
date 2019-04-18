<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 21:28
 */

namespace App\Model;

use App\Model\Entity\ClientType;

class ClientTypeModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\ClientType';

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
	 * @param ClientType $entity
	 * @return mixed
	 */
	public function save(ClientType $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param ClientType $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(ClientType $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param Client|null $clientType
	 * @return array|bool
	 */
	protected function arrayMapper( ClientType $clientType= null)
	{
		if (!$clientType)
			return false;

		$array_entity = array();
		$array_entity['name'] = $clientType->name;
		$array_entity['note'] = $clientType->note;
		$array_entity['clients'] = $clientType->clients;
		$array_entity['create_date'] = $clientType->create_date;
		$array_entity['update_date'] = $clientType->update_date;

		return $array_entity;
	}


	public function getSelectList($default_string = 'Vyber položku')
	{
		$array = array();
		$array[0] = $default_string;
		$items = $this->getList();

		foreach ($items as $item) {
			$array[$item->id] = $item->name;
		}
		return $array;
	}
}