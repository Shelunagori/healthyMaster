<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
 * @property string $weight
 * @property int $self_life
 * @property float $price
 * @property string $product_code
 * @property int|null $piece_in_box
 * @property int|null $box_in_crate
 * @property \Cake\I18n\FrozenTime|null $created_on
 * @property string|null $created_by
 * @property string|null $edited_by
 * @property \Cake\I18n\FrozenTime|null $edited_on
 * @property int $is_deleted
 *
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Product extends Entity
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
        'weight' => true,
        'self_life' => true,
        'price' => true,
        'product_code' => true,
        'piece_in_box' => true,
        'box_in_crate' => true,
        'created_on' => true,
        'created_by' => true,
        'edited_by' => true,
        'edited_on' => true,
        'is_deleted' => true,
        'transactions' => true
    ];
}
