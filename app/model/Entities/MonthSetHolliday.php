<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 29.10.2018
 * Time: 11:25
 */

namespace App\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Team
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="month_set_holliday")
 */
class MonthSetHolliday
{

	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
	}

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="MonthSet", inversedBy="hollidays")
	 * @ORM\JoinColumn(name="month_set_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $mset;

	/**
	 * @ORM\ManyToOne(targetEntity="Employee", inversedBy="month_set_hollidays")
	 * @ORM\JoinColumn(name="employee_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $employee;

	/**
	 * @ORM\ManyToOne(targetEntity="Commitment", inversedBy="month_set_hollidays")
	 * @ORM\JoinColumn(name="commitment_id", referencedColumnName="id", onDelete="CASCADE")
	 */
	protected $commitment;

	/**
	 * @ORM\Column(type="date", nullable=false)
	 */
	protected $start;

	/**
	 * @ORM\Column(type="date", nullable=false)
	 */
	protected $stop;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $half_day_start;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $half_day_stop;

	/**
	 * @ORM\Column(type="smallint", nullable=true)
	 */
	protected $type;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $note;

	/**
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="create")
	 */
	protected $create_date;

	/**
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="update")
	 */
	protected $update_date;


	/**
	 * @param MonthSet $monthSet
	 */
	public function setMonthSet( MonthSet $monthSet )
	{
		$this->mset = $monthSet;
	}

	/**
	 * @param Commitment $commitment
	 */
	public function setCommitment( Commitment $commitment )
	{
		$this->commitment = $commitment;
	}


	/**
	 * @param Employee $employee
	 */
	public function setEmployee( Employee $employee )
	{
		$this->employee = $employee;
	}
}