<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 29.10.2018
 * Time: 11:51
 */

namespace App\Model;
use App\Model\Entity\MonthSet;
use Doctrine\Common\EventArgs;
use Gedmo\DoctrineExtensions;
use Kdyby\Events\EventArgsList;

class MonthSetModel extends BaseModel
{
	public $onSaveNew = array();

	public $onLock = array();

	public $onUnlock = array();

	protected $entity = 'App\Model\Entity\MonthSet';

    /**
     * @return \Kdyby\Doctrine\EntityRepository
     * @throws \Doctrine\ORM\ORMException
     */
	protected function getR()
	{

		$emConfig = $this->entityManager->getConfiguration();
		$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\QueryMysql\Day');

		return $this->entityManager->getRepository($this->entity);
	}

    /**
     * @param $id
     * @param bool $array
     * @return array|bool|object|null
     * @throws \Doctrine\ORM\ORMException
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
     * @param array $by
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
	public function getList($by = array())
	{
		return $this->getR()->findBy($by, array('id' => 'ASC'));
	}

    /**
     * @param $main_subject_id
     * @param null $year
     * @return array
     * @throws \Doctrine\ORM\ORMException
     */
	public function getListByMainSubject( $main_subject_id, $year = null )
	{
		$by['main_subject'] = (int)$main_subject_id;

		if($year)
			return $this->getR()->createQueryBuilder('m')->where('m.main_subject = :main_subject_id AND YEAR(m.month) = :month')
				->setParameter('main_subject_id', (int)$main_subject_id)
				->setParameter('month', $year)
				->getQuery()
				->getResult();

		return $this->getR()->findBy( $by, array('month' => 'ASC'));
	}

    /**
     * @param MonthSet $entity
     * @return \Kdyby\Doctrine\EntityManager
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function save(MonthSet $entity)
	{
        return $this->entityManager->persist($entity)->flush();
	}

    /**
     * @param MonthSet $entity
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function saveNew(MonthSet $entity) {
        if( $this->save( $entity )) {
            $this->onSaveNew( $entity );
        }
    }

    /**
     * @param MonthSet $entity
     * @return \Kdyby\Doctrine\EntityManager
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function delete(MonthSet $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param MonthSet|null $entity
	 * @return array|bool
	 */
	protected function arrayMapper( MonthSet $entity = null)
	{
		if (!$entity)
			return false;

		$array_entity = array();
		$array_entity['id'] = $entity->getId();
		$array_entity['locked'] = $entity->getLocked();
		$array_entity['month'] = $entity->getMonth()->format('m/Y');
		$array_entity['note'] = $entity->getNote();
		$array_entity['hollidays'] = $entity->getHollidays();
		$array_entity['extra_pays_universal'] = $entity->getExtra_pays_universal();
		$array_entity['bunuses'] = $entity->getBonuses();

		return $array_entity;
	}

    /**
     * @param MonthSet $entity
     * @return bool
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function lockMonthSet( MonthSet $entity )
	{
		$entity->setLocked(true);
		if($this->save($entity)){
            $this->onLock( $entity );
        }
		return true;
	}

    /**
     * @param $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
	public function switchLocked( $id, $user = null)
	{
		$entity = $this->find((int)$id);

		$lock_status = $entity->getLocked();

		if( $lock_status ) {
			$entity->setLocked( false );
            $this->onLock( $entity, $user );
		}
		else {
            $entity->setLocked(true);
            $this->onUnlock( $entity, $user );
        }


		$this->save($entity);

		return true;

	}

	/**
	 * @param $main_subject_id
	 * @return array
	 * @throws \Doctrine\ORM\ORMException
	 */
	public function getYears($main_subject_id)
	{
		$return = [];

		$from = $this->getR()->findBy(array('main_subject' => (int)$main_subject_id), array('month' => 'ASC'));
		$to = $this->getR()->findBy(array('main_subject' => (int)$main_subject_id), array('month' => 'DESC'));



		$year_from = (count($from) > 0 ? (int)$from[0]->month->format('Y') : date('Y'));
		$year_to = (count($to) > 0 ? (int)$to[0]->month->format('Y') : date( 'Y' ));

		if( $year_from < $year_to ) {
			for ( $i = $year_to; $year_from <= $i; $i-- )
				$return[] = $i;
		}

		return $return;

	}

}
