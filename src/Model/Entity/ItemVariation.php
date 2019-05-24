<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemVariation Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $unit_id
 * @property float $minimum_stock
 * @property string $ready_to_sale
 * @property float $print_rate
 * @property float $sales_rate
 * @property int $out_of_stock
 * @property int $minimum_quantity_purchase
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Unit $unit
 */
class ItemVariation extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'item_id' => true,
		'quantity_variation' => true,
        'unit_id' => true,
        'minimum_stock' => true,
        'ready_to_sale' => true,
        'print_rate' => true,
        'sales_rate' => true,
        'out_of_stock' => true,
        'minimum_quantity_purchase' => true,
        'item' => true,
        'unit' => true
    ];
}
