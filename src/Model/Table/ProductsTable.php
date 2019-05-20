<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * Products Model
 *
 * @property \App\Model\Table\TransactionsTable|\Cake\ORM\Association\HasMany $Transactions
 *
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 */
class ProductsTable extends Table
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

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Transactions', [
            'foreignKey' => 'product_id'
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
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('weight')
            ->maxLength('weight', 255)
            ->requirePresence('weight', 'create')
            ->allowEmptyString('weight', false);

        $validator
            ->integer('self_life')
            ->requirePresence('self_life', 'create')
            ->allowEmptyString('self_life', false);

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->allowEmptyString('price', false);

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 255)
            ->requirePresence('product_code', 'create')
            ->allowEmptyString('product_code', false);

        $validator
            ->integer('piece_in_box')
            ->allowEmptyString('piece_in_box');

        $validator
            ->integer('box_in_crate')
            ->allowEmptyString('box_in_crate');

        $validator
            ->dateTime('created_on')
            ->allowEmptyDateTime('created_on');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 30)
            ->allowEmptyString('created_by');

        $validator
            ->scalar('edited_by')
            ->maxLength('edited_by', 30)
            ->allowEmptyString('edited_by');

        $validator
            ->dateTime('edited_on')
            ->allowEmptyDateTime('edited_on');

        $validator
            ->requirePresence('is_deleted', 'create')
            ->allowEmptyString('is_deleted', false);

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        @$data['name'] ? $data['name'] = ucwords($data['name']) : '';

        @$data['date'] ? $data['date'] = date('Y-m-d',strtotime($data['date'])) : '';
    }
}
