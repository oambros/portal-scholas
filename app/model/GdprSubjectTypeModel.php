<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 21:28
 */

namespace App\Model;

use App\Model\Entity\GdprSubjectType;

class GdprSubjectTypeModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\GdprSubjectType';

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
	 * @param GdprSubjectType $entity
	 * @return mixed
	 */
	public function save(GdprSubjectType $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param GdprSubjectType $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(GdprSubjectType $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param GdprSubjectType|null $gdprSubjectType
	 * @return array|bool
	 */
	protected function arrayMapper( GdprSubjectType $gdprSubjectType = null)
	{
		if (!$gdprSubjectType)
			return false;

		$array_entity = array();
		$array_entity['name'] = $gdprSubjectType->name;
		$array_entity['note'] = $gdprSubjectType->note;
		$array_entity['gdpr_subjects'] = $gdprSubjectType->gdpr_subjects;
		//$array_entity['gdpr_oou_types'] = $this->getOouTypesDefault($gdprSubjectType->gdpr_oou_types);
		$array_entity['create_date'] = $gdprSubjectType->create_date;
		$array_entity['update_date'] = $gdprSubjectType->update_date;

		return $array_entity;
	}

	protected function getOouTypesDefault( $gdpr_oou_types = null )
	{
		$array = array();
		if( $gdpr_oou_types ) {
			foreach ( $gdpr_oou_types as $type) {
				$array[$type->id] = 1;
			}
		}
		return $array;
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