<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 21.11.2018
 * Time: 14:11
 */

namespace App\Listeners;

use App\Model\Entity\Notification;
use App\Model\Entity\Users;
use Kdyby\Events\Subscriber;
use Nette\Object;

class NotificationListener extends Object implements Subscriber
{

	public function __construct(  )
	{
	}

	public function getSubscribedEvents()
	{
		return array('App\Model\MonthSetModel::onSaveNew' => 'onSaveNew');
	}

	/**
	 * @param MonthSet $monthSet
	 * @param string $user
	 */
	public function onSaveNew( MonthSet $monthSet, $user = 'neznámý' )
	{
		$this->createNotification('Uložení měsíční setu '.$monthSet->getMain_subject()->name.', '.$monthSet->getMonth()->format('m. Y'), $user, $monthSet->getMain_subject()->id );
	}

	/**
	 * @param $text
	 * @param Users $user
	 */
	protected function createNotification( $text, Users $user)
	{
		$log = new Notification();
		$log->setText((string)$text);
		$log->setUser($user);

		$this->logModel->save( $log );
	}
}