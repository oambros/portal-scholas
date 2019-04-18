<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.03.2018
 * Time: 22:06
 */

namespace App\Model;


use App\Model\Entity\GdprTeam;

class GdprTeamsModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\GdprTeam';

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
	 * @param GdprTeam $entity
	 * @return mixed
	 */
	public function save(GdprTeam $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param GdprTeam $entity
	 */
	public function editPrepare( GdprTeam $entity )
	{
		$this->entityManager->persist($entity);
	}

	/**
	 * @param GdprTeam $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(GdprTeam $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	protected function arrayMapper(GdprTeam $gdprTeam = null)
	{
		if (!$gdprTeam)
			return false;

		$array_entity = array();

		$users= array();

		foreach ($gdprTeam->users as $item) {
			$users[] = $item->getId();
		}

		$gdpr_subjects = array();
		foreach ( $gdprTeam->gdpr_subjects as $subject ) {
			$gdpr_subjects[] = $subject->getId();
		}

		$array_entity['name'] = $gdprTeam->name;
		$array_entity['note'] = $gdprTeam->note;
		$array_entity['users'] = $users;
		$array_entity['gdpr_subjects'] = $gdpr_subjects;
		$array_entity['type'] = $gdprTeam->type;
		$array_entity['create_date'] = $gdprTeam->create_date;
		$array_entity['update_date'] = $gdprTeam->update_date;

		return $array_entity;
	}

	public function getSelectList($default_string = 'Vyber team')
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