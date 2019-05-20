<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PopTransaction Entity
 *
 * @property int $id
 * @property int $vehicle_id
 * @property int $party_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $Item
 * @property string $status
 * @property int $quantity
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int|null $edited_by
 * @property \Cake\I18n\FrozenTime|null $edited_on
 * @property int $is_deleted
 *
 * @property \App\Model\Entity\Vehicle $vehicle
 * @property \App\Model\Entity\Party $party
 */
class PopTransaction extends Entity
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
        'vehicle_no' => true,
        'party_id' => true,
        'transaction_date' => true,
        'item' => true,
        'status' => true,
        'quantity' => true,
        'created_by' => true,
        'created_on' => true,
        'edited_by' => true,
        'edited_on' => true,
        'is_deleted' => true,
        'pop_id' => true,
        'vehicle' => true,
        'pop' => true,
        'party' => true
    ];
}
