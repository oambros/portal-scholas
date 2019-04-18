<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 12:04
 */

namespace App\Model;


use App\Model\Entity\MainSubject;
use Doctrine\ORM\EntityRepository;

class MainSubjectModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\MainSubject';

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
	 * @param $user_id
	 * @return array
	 */
	public function getMainSubjectByUserId( $user_id )
	{
		return $this->getR()->findBy(array('users' => (int)$user_id), array('id' => 'ASC'));
	}

	/**
	 * @param $string
	 * @param null $user_id
	 * @return array
	 */
	public function getListByNameLike( $string, $user_id = null )
	{
		return $this->getR()->createQueryBuilder('ms')->where('ms.name LIKE :string')
			->setParameter('string', $string.'%')
			->getQuery()
			->getResult();
	}

	/**
	 * @param bool $by
	 * @return array
	 */
	public function getSelectList($by = false)
	{
		$list = array();
		$subjects = $this->getR()->findBy(array(), array('name' => 'ASC'));
		foreach ($subjects as $subject) {
			$list[$subject->getId()] = $subject->getName();
		}

		return $list;
	}

	/**
	 * @param MainSubject $entity
	 * @return mixed
	 */
	public function save(MainSubject $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param MainSubject $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(MainSubject $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param MainSubject $subject
	 * @return array
	 */
	protected function arrayMapper(MainSubject $subject = null)
	{
		if (!$subject)
			return false;

		$array_entity = array();
		$array_entity['name'] = $subject->getName();
		$array_entity['street'] = $subject->getStreet();
		$array_entity['cp'] = $subject->getCp();
		$array_entity['town'] = $subject->getTown();
		$array_entity['type'] = $subject->getType();
		$array_entity['zip'] = $subject->getZip();
		$array_entity['ico'] = $subject->getIco();
		$array_entity['dic'] = $subject->getDic();
		$array_entity['note'] = $subject->getNote();

		return $array_entity;
	}


}