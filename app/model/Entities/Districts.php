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
 * @ORM\Table(name="districts")
 */
class District
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->clients[] = new ArrayCollection();
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
	 * @ORM\OneToMany(targetEntity="App\Model\Entity\Client", mappedBy="district")
	 */
	protected $clients;

	/**
	 * @ORM\Column(type="smallint", nullable=true)
	 */
	protected $type;

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