<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 15.03.2018
 * Time: 13:10
 */

namespace App\AdminModule\Presenters;


use App\Model\Entity\GdprSubjectEntity;
use App\Model\GdprSubjectModel;
use App\Model\GdprTeamsModel;
use Nette\Utils\DateTime;

class GdprMapPresenter extends BasePresenter
{

	/**
	 * @var GdprSubjectModel
	 * @inject
	 */
	public $gdprSubjectModel;

	/**
	 * @var GdprTeamsModel
	 * @inject
	 */
	public $gdprTeamsModel;

	public function actionDefault( $show = 'all', $subject = null )
	{
		if( $show == 'all' ) {
			$by = array();
		}
		if ( $show == 'sign' )
			$by = array('sign' => true);
		if( $show == 'unsign' )
			$by = array('sign' => false);

		if($subject) {
			$this->template->selected_subject = $this->gdprSubjectModel->find($subject);
		}
		$this->template->Subjects = $this->gdprSubjectModel->getList($by);
		$this->template->map_choose = $show;

	}

	public function actionTeamMap( $id )
	{
		$this->template->teams_list = $this->gdprTeamsModel->getList();
		$this->template->team = $this->gdprTeamsModel->find($id);
	}

	public function actionRefreshSubjects()
	{
		$data = $this->JsonSheedMapper();
		foreach ($data as $item)
		{
			if($item->nazev == 'Celkem')
				continue;
			if( !$subject = $this->gdprSubjectModel->getBySheetId($item->id) ) {
				$subject = new GdprSubjectEntity();
			}

			$subject->setSheet_id($item->id);
			$subject->setName($item->nazev);
			$subject->setStreet($item->adresa);
			$subject->setSign($item->podepsano);
			$subject->setSubject_count((int)$item->pocet);
			$subject->setAudit_price((int)$item->cena_audit);
			$subject->setFlat_rate((int)$item->cena_pausal);
			$subject->setPriority((int)$item->priorita);
			$subject->setAudit_set((int)$item->audit_set);
			//($item->datum_auditu ? $subject->setAudit_date($item->datum_auditu) : null);

			$subject->setNote($item->poznamka);

			$coordinates = $this->getCoordinates( $item->adresa );
			if($coordinates) {
				$subject->setLat($coordinates->lat);
				$subject->setLng($coordinates->lng);
			}
			$this->gdprSubjectModel->save($subject);
		}
		$this->redirect('default');
	}

	protected function getCoordinates( $address )
	{
		$address = str_replace(' ', '+', $address);
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyDw-oKMFBGrE9h2nDGD4RDHsVJNWnE2QdU';

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$data = json_decode(curl_exec($curl));

		curl_close($curl);

		if( $data->status == 'OK' ) {
			$rerurn = $data->results[0];
			return $rerurn->geometry->location;
		}

		return false;

	}

	/**
	 * @return string
	 */
	protected function JsonSheedMapper( )
	{
		$json = file_get_contents('https://spreadsheets.google.com/feeds/list/18VhKZ675q_g_GVnwJ3BTMpuyu1p8Br7R_oyssO76s8Y/od6/public/values?alt=json');
		$data = json_decode($json, true);

		$new_data = array();

		foreach ($data['feed']['entry'] as $entry) {
			$new_data[] = array(
				'id' => $entry['id']['$t'],
				'nazev' => $entry['gsx$nazev']['$t'],
				'adresa' => $entry['gsx$adresa']['$t'],
				'pocet' => $entry['gsx$pocet']['$t'],
				'cena_audit' => $entry['gsx$audit']['$t'],
				'cena_pausal' => $entry['gsx$pausal']['$t'],
				'priorita' => (int)$entry['gsx$priorita']['$t'],
				'podepsano' => ($entry['gsx$podepsano']['$t']== 'ano' ? true : false),
				'update' => new DateTime($entry['updated']['$t']),
				//'datum_auditu' => ($entry['gsx$datumauditu']['$t'] == null ? null : DateTime::from(strtotime($entry['gsx$datumauditu']['$t'])->format('YYYY-m-d'))),
				'poznamka' => ($entry['gsx$poznamky']['$t'] == null ? null : $entry['gsx$poznamky']['$t']),
				'audit_set' => ($entry['gsx$poznamky']['$t'] == 'HOTOVÝ AUDIT' ? 1 : 0),
			);

		}

		return json_decode(json_encode($new_data));
	}


}