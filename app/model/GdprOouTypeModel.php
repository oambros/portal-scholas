<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 04.02.2018
 * Time: 0:54
 */

namespace App\Model;


use App\Model\Entity\GdprOouType;
use Doctrine\ORM\EntityRepository;

class GdprOouTypeModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\GdprOouType';

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
		return $this->getR()->findBy(array(), array('position' => 'ASC'));
	}

	/**
 * @param GdprOouType $entity
 * @return mixed
 */
	public function save(GdprOouType $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param GdprOouType $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(GdprOouType $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	public function getCheckboxList( )
	{
		$array = array();

		$items = $this->getList();

		foreach ($items as $item) {
			$array[$item->id] = $item->name;
		}
		return $array;
	}

	/**
	 * @param GdprOouType|null $gdprOouType
	 * @return array|bool
	 */
	protected function arrayMapper( GdprOouType $gdprOouType = null)
	{
		if (!$gdprOouType)
			return false;

		$array_entity = array();
		$array_entity['name'] = $gdprOouType->name;
		$array_entity['note'] = $gdprOouType->note;
		$array_entity['position'] = $gdprOouType->position;
		$array_entity['gdpr_subjects'] = $gdprOouType->gdpr_subjects;
		$array_entity['create_date'] = $gdprOouType->create_date;
		$array_entity['update_date'] = $gdprOouType->update_date;

		return $array_entity;
	}
}