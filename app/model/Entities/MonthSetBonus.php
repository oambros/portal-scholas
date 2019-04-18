<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 29.10.2018
 * Time: 11:35
 */

namespace App\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Class Team
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="month_set_bonus")
 */
class MonthSetBonus
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
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $ammount;

	/**
	 * @ORM\ManyToOne(targetEntity="MonthSet", inversedBy="hollidays")
	 * @ORM\JoinColumn(name="month_set_id", referencedColumnName="id")
	 */
	protected $month_set;

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