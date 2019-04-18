<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 15.01.2018
 * Time: 11:59
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection,
	Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 *
 * Class InventotyItemEntity
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="inventoryItem")
 */
class InventoryItemEntity
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
	 * @ORM\Column(type="string", length=255, unique=true, nullable=true)
	 */
	protected $code;

	/**
	 * @ORM\Column(type="string", length=255, unique=true, nullable=false)
	 */
	protected $name;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Model\Entity\ManufacturerEntity", inversedBy="inventory_items")
	 * @ORM\JoinColumn(name="manufacturer_id", referencedColumnName="id")
	 */
	protected $manufacturer;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Model\Entity\ItemTypesEntity", inversedBy="inventory_items")
	 * @ORM\JoinColumn(name="item_type_id", referencedColumnName="id")
	 */
	protected $item_type;

	/**
 * @ORM\ManyToOne(targetEntity="App\Model\Entity\ShopEntity", inversedBy="shop_items")
 * @ORM\JoinColumn(name="shop_id", referencedColumnName="id")
 */
	protected $shop;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Model\Entity\InvoiceEntity", inversedBy="inventory_items")
	 * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
	 */
	protected $invoice;

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