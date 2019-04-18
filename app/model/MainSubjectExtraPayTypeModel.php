<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 12:04
 */

namespace App\Model;

use App\Model\Entity\MainSubjectExtraPayType;
use Doctrine\ORM\EntityRepository;

class MainSubjectExtraPayTypeModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\MainSubjectExtraPayType';

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
	 * @param MainSubjectExtraPayType $entity
	 * @return mixed
	 */
	public function save( MainSubjectExtraPayType $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param MainSubjectExtraPayType $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( MainSubjectExtraPayType $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param MainSubjectExtraPayType $subject
	 * @return array
	 */
	protected function arrayMapper( MainSubjectExtraPayType $MainSubjectExtraPayType = null ) {
		if(!$MainSubjectExtraPayType)
			return false;

		$array_entity = array();
		$array_entity['name'] = $MainSubjectExtraPayType->name;
		$array_entity['note'] = $MainSubjectExtraPayType->note;
		$array_entity['main_subjects'] = $this->getMainSubjectsArray($MainSubjectExtraPayType);
		$array_entity['ept'] = $this->getEptsArray($MainSubjectExtraPayType);

		return $array_entity;
	}

	public function getCheckboxList()
	{
		$array = array();
		$types = $this->getList();

		foreach ($types as $type) {
			$array[$type->id] = $type->name;
		}
		return $array;
	}

	/**
	 * @param MainSubjectExtraPayType $type
	 * @return array
	 */
	protected function getEptsArray( MainSubjectExtraPayType $type )
	{
		$array = [];

		foreach ( $type->getEpt() as $type ) {
			$array[] = $type->id;
		}


		return $array;
	}

	/**
	 * @param MainSubjectExtraPayType $type
	 * @return array
	 */
	protected function getMainSubjectsArray( MainSubjectExtraPayType $type )
	{
		$array = [];

		foreach ( $type->getMain_subjects() as $subject ) {
			$array[] = $subject->id;
		}

		return $array;
	}

}