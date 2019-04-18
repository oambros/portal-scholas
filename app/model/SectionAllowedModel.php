<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 24.10.2018
 * Time: 12:33
 */

namespace App\Model;

use App\Model\Entity\PayMonth;
use App\Model\Entity\SectionAllowed;
use Doctrine\ORM\EntityRepository;

class SectionAllowedModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\SectionAllowed';

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
	 * @param SectionAllowed $entity
	 * @return mixed
	 */
	public function save( SectionAllowed $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param SectionAllowed $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( SectionAllowed $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param SectionAllowed $subject
	 * @return array
	 */
	protected function arrayMapper( SectionAllowed $sectionAllowed = null ) {
		if(!$sectionAllowed)
			return false;

		$array_entity = array();
		$array_entity['name'] = $sectionAllowed->getName();
		$array_entity['name'] = $sectionAllowed->getName();
		$array_entity['presenter_name'] = $sectionAllowed->getPresenter_name();
		$array_entity['note'] = $sectionAllowed->getNote();

		return $array_entity;
	}
}