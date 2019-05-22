<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemVariations Model
 *
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\UnitsTable|\Cake\ORM\Association\BelongsTo $Units
 *
 * @method \App\Model\Entity\ItemVariation get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemVariation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemVariation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemVariation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemVariation|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemVariation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemVariation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemVariation findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemVariationsTable extends Table
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

        $this->setTable('item_variations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Units', [
            'foreignKey' => 'unit_id',
            'joinType' => 'INNER'
        ]);
		
		$this->hasOne('Wishlists', [
            'foreignKey' => 'item_variation_id'
        ]);
		
		$this->hasOne('Carts', [
            'foreignKey' => 'item_variation_id'
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
        // $validator
        //     ->integer('id')
        //     ->allowEmptyString('id', 'create');

        // $validator
        //     ->decimal('minimum_stock')
        //     ->requirePresence('minimum_stock', 'create')
        //     ->allowEmptyString('minimum_stock', false);

        // $validator
        //     ->scalar('ready_to_sale')
        //     ->maxLength('ready_to_sale', 10)
        //     ->requirePresence('ready_to_sale', 'create')
        //     ->allowEmptyString('ready_to_sale', false);

        // $validator
        //     ->decimal('print_rate')
        //     ->requirePresence('print_rate', 'create')
        //     ->allowEmptyString('print_rate', false);

        // $validator
        //     ->decimal('sales_rate')
        //     ->requirePresence('sales_rate', 'create')
        //     ->allowEmptyString('sales_rate', false);

        // $validator
        //     ->requirePresence('out_of_stock', 'create')
        //     ->allowEmptyString('out_of_stock', false);

        // $validator
        //     ->integer('minimum_quantity_purchase')
        //     ->requirePresence('minimum_quantity_purchase', 'create')
        //     ->allowEmptyString('minimum_quantity_purchase', false);

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
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['unit_id'], 'Units'));

        return $rules;
    }
}
