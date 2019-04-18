<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 19.01.2018
 * Time: 21:56
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Kdyby\Doctrine\MagicAccessors\MagicAccessors;

/**
 *
 * Class InvoiceEntity
 * @package App\Model\Entity
 * @ORM\Entity()
 * @ORM\Table(name="invoice")
 */
class InvoiceEntity
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
	 * @ORM\Column(type="string", length=255, unique=true, nullable=true)
	 */
	protected $number;

	/**
	 * @ORM\Column(type="string", length=255, unique=true, nullable=true)
	 */
	protected $file;

	/**
	 * @var ArrayCollection
	 * @ORM\OneToMany(targetEntity="App\Model\Entity\InventoryItemEntity", mappedBy="invoice")
	 */
	protected $inventory_items;

	/**
	 * @ORM\Column(type="string", length=255, unique=true, nullable=true)
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
}