<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 21.11.2018
 * Time: 14:11
 */

namespace App\Listeners;

use App\Model\Entity\Log;
use App\Model\Entity\MonthSet;
use App\Model\LogModel;
use App\Model\MainSubjectModel;
use App\Model\MonthSetModel;
use Kdyby\Events\Subscriber;
use Nette\Object;

class MonthSetListener extends Object implements Subscriber
{
	/**
	 * @var LogModel
	 */
	protected $logModel;

    /**
     * @var MainSubjectModel
     */
	protected $mainSubjectModel;

    /**
     * MonthSetListener constructor.
     * @param LogModel $logModel
     * @param MainSubjectModel $mainSubjectModel
     */
	public function __construct( LogModel $logModel, MainSubjectModel $mainSubjectModel )
	{
		$this->logModel = $logModel;
		$this->mainSubjectModel = $mainSubjectModel;
	}

	public function getSubscribedEvents()
	{
		return array('App\Model\MonthSetModel::onSaveNew' => 'onSaveNew', 'App\Model\MonthSetModel::onLock' => 'onLock', 'App\Model\MonthSetModel::onUnlock' => 'onUnlock');
	}

	public function onSaveNew( MonthSet $monthSet, $user = 'neznámý' )
	{
		$this->logModel->createLog('Uložení měsíční setu '.$monthSet->getMain_subject()->name.', '.$monthSet->getMonth()->format('m. Y'), $user, $monthSet->getMain_subject() );
	}

    public function onLock( MonthSet $monthSet, $user = 'neznámý' )
    {
	    $this->logModel->createLog('Uzamčení měsíčního setu '.$monthSet->getMain_subject()->name.', '.$monthSet->getMonth()->format('m. Y'), $user, $monthSet->getMain_subject());
    }

    public function onUnlock( MonthSet $monthSet, $user = 'neznámý' )
    {
	    $this->logModel->createLog('Odemčení měsíčního setu '.$monthSet->getMain_subject()->name.', '.$monthSet->getMonth()->format('m. Y'), $user, $monthSet->getMain_subject()
	    );
    }

	public function onBeforeDelete( MonthSetModel $monthSetModel, MonthSet $monthSet )
	{

	}

}