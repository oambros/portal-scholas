<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 31.01.2018
 * Time: 21:35
 */

namespace App\Model;

use App\Model\Entity\GdprOouType;
use App\Model\Entity\GdprSubjectEntity;
use Nette\Application\UI\Form;
use Nette\DateTime;

class GdprSubjectModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\GdprSubjectEntity';

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
	public function getList( $by = array() )
	{
		return $this->getR()->findBy($by, array('id' => 'ASC'));
	}

	/**
	 * @param $sheet_id
	 * @return mixed
	 */
	public function getBySheetId( $sheet_id )
	{
		return $this->getR()->findOneBy(array('sheet_id' => $sheet_id));
	}

	/**
	 * @param GdprSubjectEntity $entity
	 * @return mixed
	 */
	public function save( GdprSubjectEntity $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param GdprSubjectEntity $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( GdprSubjectEntity $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param GdprSubjectEntity $itemTypesEntity
	 * @return array
	 */
	protected function arrayMapper( GdprSubjectEntity $gdprSubjectEntity = null ) {
		if(!$gdprSubjectEntity)
			return false;

		$array_entity = array();
		$array_entity['name'] = $gdprSubjectEntity->name;
		$array_entity['note'] = $gdprSubjectEntity->note;
		$array_entity['street'] = $gdprSubjectEntity->street;
		$array_entity['cp'] = $gdprSubjectEntity->cp;
		$array_entity['city'] = $gdprSubjectEntity->city;
		$array_entity['zip'] = $gdprSubjectEntity->zip;
		$array_entity['create_date'] = $gdprSubjectEntity->create_date;
		$array_entity['update_date'] = $gdprSubjectEntity->update_date;
		$array_entity['gdpr_oou_types'] = $this->getOouTypesArray($gdprSubjectEntity->gdpr_oou_types);
		$array_entity['gdpr_subject_type'] = (isset($gdprSubjectEntity->gdpr_subject_type->id) ? $gdprSubjectEntity->gdpr_subject_type->id : 0);
		$array_entity['sheet_id'] = $gdprSubjectEntity->sheet_id;
		$array_entity['lat'] = $gdprSubjectEntity->lat;
		$array_entity['lng'] = $gdprSubjectEntity->lng;
		$array_entity['sign'] = $gdprSubjectEntity->sign;
		$array_entity['audit_price'] = $gdprSubjectEntity->audit_price;
		$array_entity['flat_rate'] = $gdprSubjectEntity->flat_rate;
		$array_entity['subject_count'] = $gdprSubjectEntity->subject_count;
		$array_entity['audit_date'] = $gdprSubjectEntity->audit_date;
		$array_entity['team'] = (isset($gdprSubjectEntity->team->id) ? $gdprSubjectEntity->team->id : 0);
		$array_entity['priority'] = $gdprSubjectEntity->priority;
		$array_entity['audit_date'] = $gdprSubjectEntity->audit_date;
		$array_entity['audit_set'] = (isset($gdprSubjectEntity->audit_set) ? 1 : 0);

		return $array_entity;
	}

	/**
	 * @param null $gdpr_oou_types
	 * @return array
	 */
	protected function getOouTypesArray( $gdpr_oou_types = null )
	{
		$array = array();
		foreach ( $gdpr_oou_types as $type ) {
			$array[$type->id] = 1;
		}
		return $array;
	}

}