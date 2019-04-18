<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.01.2018
 * Time: 22:07
 */

namespace App\Model;

use App\Model\Entity\InvoiceEntity;

class InvoiceModel extends BaseModel
{
	protected $entity = 'App\Model\Entity\InvoiceEntity';

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
	 * @param InvoiceEntity $entity
	 * @return mixed
	 */
	public function save(InvoiceEntity $entity)
	{
		return $this->entityManager->persist($entity)->flush();
	}

	/**
	 * @param InvoiceEntity $entity
	 * @return \Kdyby\Doctrine\EntityManager
	 */
	public function delete(InvoiceEntity $entity)
	{
		return $this->entityManager->remove($entity)->flush();
	}

	/**
	 * @param InvoiceEntity $users
	 * @return array
	 */
	protected function arrayMapper(InvoiceEntity $invoiceEntity = null)
	{
		if (!$invoiceEntity)
			return false;

		$array_entity = array();

		$inventory_items = array();

		foreach ($invoiceEntity->inventory_items as $item) {
			$inventory_items[] = $item->getId();
		}

		$array_entity['number'] = $invoiceEntity->number;
		$array_entity['file'] = $invoiceEntity->file;
		$array_entity['note'] = $invoiceEntity->note;
		$array_entity['inventory_items'] = $inventory_items;
		$array_entity['create_date'] = $invoiceEntity->create_date;
		$array_entity['update_date'] = $invoiceEntity->update_date;

		return $array_entity;
	}

	public function getSelectList($default_string = 'Vyber fakturu')
	{
		$array = array();
		$array[0] = $default_string;
		$invoices = $this->getList();

		foreach ($invoices as $invoice) {
			$array[$invoice->id] = $invoice->number;
		}
		return $array;
	}
}