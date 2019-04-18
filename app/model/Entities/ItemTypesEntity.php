<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 17.01.2018
 * Time: 22:47
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection,
	Gedmo\Mapping\Annotation as Gedmo;

use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 * Class ItemTypesEntity
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="ItemTypes")
 */
class ItemTypesEntity
{
	use MagicAccessors;


	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->inventory_items = new ArrayCollection();
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
	protected $code_part;

	/**
	 * @ORM\Column(type="string", length=255, unique=true, nullable=false)
	 */
	protected $name;

	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="App\Model\Entity\InventoryItemEntity", mappedBy="item_type")
	 */
	protected $inventory_items;

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