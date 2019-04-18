<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16.01.2018
 * Time: 12:34
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection,
	Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 *
 * Class ShopEntity
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="shops")
 */
class ShopEntity
{
	use MagicAccessors;

	public function __construct()
	{
		$this->create_date = new \DateTime();
		$this->update_date = new \DateTime();
		$this->shop_items = new ArrayCollection();

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
	 * @ORM\Column(type="string", unique=true, nullable=true)
	 */
	protected $url;

	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="App\Model\Entity\InventoryItemEntity", mappedBy="shop")
	 */
	protected $shop_items;

	/**
	 * @ORM\Column(type="datetime", nullable=false)
	 * @Gedmo\Timestampable(on="create")
	 */
	protected $create_date;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @Gedmo\Timestampable(on="create")
	 */
	protected $update_date;
}