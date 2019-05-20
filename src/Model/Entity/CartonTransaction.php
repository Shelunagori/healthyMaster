<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CartonTransaction Entity
 *
 * @property int $id
 * @property string $vehicle_no
 * @property int $party_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $status
 * @property int $quantity
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int|null $edited_by
 * @property \Cake\I18n\FrozenTime|null $edited_on
 * @property int $is_deleted
 *
 * @property \App\Model\Entity\Party $party
 */
class CartonTransaction extends Entity
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
        'status' => true,
        'quantity' => true,
        'dmr_no' => true,
        'created_by' => true,
        'created_on' => true,
        'edited_by' => true,
        'edited_on' => true,
        'is_deleted' => true,
        'party' => true
    ];
}
