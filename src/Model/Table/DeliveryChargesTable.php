<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DeliveryCharges Model
 *
 * @property \App\Model\Table\PromoCodesTable|\Cake\ORM\Association\BelongsTo $PromoCodes
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\DeliveryCharge get($primaryKey, $options = [])
 * @method \App\Model\Entity\DeliveryCharge newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DeliveryCharge[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryCharge|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DeliveryCharge saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DeliveryCharge patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryCharge[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DeliveryCharge findOrCreate($search, callable $callback = null, $options = [])
 */
class DeliveryChargesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('delivery_charges');

        $this->belongsTo('Pincodes', [
            'foreignKey' => 'pincode_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'delivery_charge_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
       
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['pincode_id'], 'Pincodes'));

        return $rules;
    }
}
