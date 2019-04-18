<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 28.12.2018
 * Time: 19:27
 */

namespace App\Model;

use App\Model\Entity\ExtraPayType;
use Doctrine\ORM\EntityRepository;

class ExtraPayTypeModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\ExtraPayType';

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
	 * @param ExtraPayType $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function save( ExtraPayType $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param ExtraPayType $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( ExtraPayType $entity )
	{
		return $this->entityManager->remove($entity)->flush();
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
	 * @param ExtraPayType|null $ExtraPayType
	 * @return array|bool
	 */
	protected function arrayMapper( ExtraPayType $ExtraPayType = null ) {
		if(!$ExtraPayType)
			return false;

		$array_entity = array();
		$array_entity['form_type'] = $ExtraPayType->form_type;
		$array_entity['name'] = $ExtraPayType->name;
		$array_entity['base_type'] = $ExtraPayType->base_type;
		$array_entity['odmdr'] = $ExtraPayType->odmdr;
		$array_entity['icon_class'] = $ExtraPayType->icon_class;
		$array_entity['icon_color'] = $ExtraPayType->icon_color;
		$array_entity['note'] = $ExtraPayType->note;

		return $array_entity;
	}

}