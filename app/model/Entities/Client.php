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
 * Class Team
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="Clients")
 */
class Client
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
	 * @ORM\Column(type="string", length=255, unique=true, nullable=false)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $street;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $cp;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $town;

	/**
	 * @ORM\ManyToOne(targetEntity="District", inversedBy="clients")
	 * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
	 */
	protected $district;

	/**
	 * @ORM\ManyToOne(targetEntity="ClientType", inversedBy="clients")
	 * @ORM\JoinColumn(name="client_type_id", referencedColumnName="id")
	 */
	protected $type;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $director;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $tel;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	protected $email;

	/**
	 * @ORM\ManyToOne(targetEntity="Users", inversedBy="clients")
	 * @ORM\JoinColumn(name="salesman_id", referencedColumnName="id")
	 */
	protected $salesman;


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