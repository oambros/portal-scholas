<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 12.04.2019
 * Time: 12:23
 */

namespace App\Model;


use App\Model\Entity\Notification;

class NotificationModel
{
	protected $entity = 'App\Model\Entity\Notification';

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
	 * @param Notification $entity
	 * @return mixed
	 */
	public function save(Notification $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param Notification $entity
	 * @return mixed
	 */
	public function delete(Notification $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param $id integer
	 */
	public function setUnNew( $id ) {
		$notification = $this->find((int)$id);
		$notification->setNew(false);
		$this->save( $notification );
	}

	/**
	 * @param Notification|null $manufacturerEntity
	 * @return array|bool
	 */
	protected function arrayMapper(Notification $notification = null)
	{
		if (!$notification)
			return false;

		$array_entity = array();
		$array_entity['text'] = $notification->text;
		$array_entity['new'] = $notification->new;

		return $array_entity;
	}
}