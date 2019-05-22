<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Faq Entity
 *
 * @property int $id
 * @property int $city_id
 * @property string $question
 * @property string $answer
 * @property int $status
 *
 * @property \App\Model\Entity\City $city
 */
class Faq extends Entity
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
        'city_id' => true,
        'question' => true,
        'answer' => true,
        'status' => true,
        'city' => true
    ];
}
