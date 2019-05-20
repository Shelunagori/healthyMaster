<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property string $product_id
 * @property string $vehicle_no
 * @property string|null $batch_no
 * @property \Cake\I18n\FrozenDate|null $dom
 * @property float $mrp
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $status
 * @property int $quantity
 * @property int|null $availiable_quantity
 * @property int $party_id
 * @property int|null $bill_no
 * @property \Cake\I18n\FrozenDate|null $bill_date
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int|null $edited_by
 * @property \Cake\I18n\FrozenTime|null $edited_on
 * @property int $is_deleted
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\Vehicle $vehicle
 * @property \App\Model\Entity\Party $party
 */
class Transaction extends Entity
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
        'product_id' => true,
        'vehicle_no' => true,
        'batch_no' => true,
        'dom' => true,
        'mrp' => true,
        'transaction_date' => true,
        'status' => true,
        'quantity' => true,
        'availiable_quantity' => true,
        'party_id' => true,
        'bill_no' => true,
        'bill_date' => true,
        'created_by' => true,
        'created_on' => true,
        'edited_by' => true,
        'edited_on' => true,
        'is_deleted' => true,
        'product' => true,
        'remarks' => true,
        'vehicle' => true,
        'edited_date' => true,
        'party' => true
    ];
}
