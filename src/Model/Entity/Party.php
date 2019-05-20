<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Party Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $mobile_no
 * @property string $owner_name
 */
class Party extends Entity
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
        'name' => true,
        'address' => true,
        'mobile_no' => true,
        'party_type' => true,
        'owner_name' => true
    ];
}
