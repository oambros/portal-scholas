<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 11.01.2018
 * Time: 12:01
 */

namespace App\Model;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Events\EventManager;
use Nette\Object;

class BaseModel extends Object
{
	/**
	 * @var EntityManager
	 */
	protected $entityManager;

	/**
	 * @var EventManager
	 */
	protected $eventManager;

	/**
	 * BaseModel constructor.
	 * @param EntityManager $entityManager
	 */
	public function __construct( EntityManager $entityManager, EventManager $eventManager )
	{
		$this->entityManager = $entityManager;
		$this->eventManager = $eventManager;
	}


}