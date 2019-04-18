<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 03.12.2018
 * Time: 10:43
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
 * @ORM\Table(name="contacts")
 */
class Contract
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