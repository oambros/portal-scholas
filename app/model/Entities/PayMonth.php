<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 26.07.2018
 * Time: 11:56
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="pay_month")
 */
class PayMonth
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
	 * @ORM\Column(type="date", nullable=false)
	 */
	protected $date;

	/**
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $num_free_days;

	/**
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $num_free_days_np;

	/**
	 * @ORM\Column(type="float", nullable=true)
	 */
	protected $num_extra_days;

	/**
	 * @ORM\ManyToOne(targetEntity="Commitment", inversedBy="pay_months")
	 * @ORM\JoinColumn(name="commitment_id", referencedColumnName="id")
	 */
	protected $commitment;

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