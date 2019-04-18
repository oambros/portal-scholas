<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 26.07.2018
 * Time: 11:56
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * Class ExtraPay
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="extra_pay")
 */
class ExtraPay
{
	use MagicAccessors;

	public function __construct() {
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
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $amount;

	/**
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $hours;

	/**
	 * @ORM\Column(type="text"), nullable=false)
	 */
	protected $note;

	/**
	 * @ORM\ManyToOne(targetEntity="ExtraPayType", inversedBy="extra_pays")
	 * @ORM\JoinColumn(name="extra_pay_type_id", referencedColumnName="id")
	 */
	protected $extra_pay_type;

	/**
	 * @ORM\ManyToOne(targetEntity="MonthSet", inversedBy="extra_pays")
	 * @ORM\JoinColumn(name="month_set_id", referencedColumnName="id")
	 */
	protected $month_set;

	/**
	 * @ORM\ManyToOne(targetEntity="Employee", inversedBy="extra_pays")
	 * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
	 */
	protected $employee;

	/**
	 * @ORM\ManyToOne(targetEntity="Commitment", inversedBy="extra_pays")
	 * @ORM\JoinColumn(name="commitment_id", referencedColumnName="id")
	 */
	protected $commitment;

	/**
	 * @ORM\ManyToOne(targetEntity="Financing", inversedBy="extra_pays")
	 * @ORM\JoinColumn(name="financing_id", referencedColumnName="id", nullable=true)
	 */
	protected $financing;

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
}