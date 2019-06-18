<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pincode Entity
 *
 * @property int $id
 * @property int $state_id
 * @property int $city_id
 * @property int $pincode
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\City $city
 */
class Pincode extends Entity
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
        'state_id' => true,
        'city_id' => true,
        'pincode' => true,
        'state' => true,
        'city' => true,
		'we_deliver' => true,
		'delivery_reason' => true
    ];
}
