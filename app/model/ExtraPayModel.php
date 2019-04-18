<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 12:04
 */

namespace App\Model;


use App\Model\Entity\ExtraPay;
use App\Model\Entity\MainSubjectExtraPayType;
use App\Model\Entity\MonthSet;
use Doctrine\ORM\EntityRepository;

class ExtraPayModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\ExtraPay';

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
	 * @param $mset integer
	 * @param $extra_pay_type integer
	 * @return array
	 */
	public function getListByMsetExtraPayType( $mset, $extra_pay_type )
	{
		return $this->getR()->findBy(array('month_set' => (int)$mset, 'extra_pay_type' => (int)$extra_pay_type));
	}

	/**
	 * @param ExtraPay $entity
	 * @return mixed
	 */
	public function save( ExtraPay $entity )
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param ExtraPay $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete( ExtraPay $entity )
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param ExtraPay $subject
	 * @return array
	 */
	protected function arrayMapper( ExtraPay $ExtraPay = null ) {
		if(!$ExtraPay)
			return false;

		$array_entity = array();
		$array_entity['name'] = $ExtraPay->name;
		$array_entity['amount'] = $ExtraPay->amount;
		$array_entity['type_id'] = $ExtraPay->type_id;
		$array_entity['note'] = $ExtraPay->note;

		return $array_entity;
	}

	public function getCountPaysByEptMset( $ept_id, MonthSet $monthSet)
	{
		$qb = $this->entityManager->createQueryBuilder();

		$qb->select('count(ep.id)');
		$qb
			->from('App\Model\Entity\ExtraPay','ep')
			->where('ep.month_set = :mset AND ep.extra_pay_type = :ept_id')
			->setParameter('mset', $monthSet->getId())
			->setParameter('ept_id', $ept_id);
		$count = $qb->getQuery()->getSingleScalarResult();

		return $count;
	}

}