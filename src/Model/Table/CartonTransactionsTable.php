<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * CartonTransactions Model
 *
 * @property \App\Model\Table\PartiesTable|\Cake\ORM\Association\BelongsTo $Parties
 *
 * @method \App\Model\Entity\CartonTransaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\CartonTransaction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CartonTransaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CartonTransaction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CartonTransaction|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CartonTransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CartonTransaction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CartonTransaction findOrCreate($search, callable $callback = null, $options = [])
 */
class CartonTransactionsTable extends Table
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

        $this->setTable('carton_transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Parties', [
            'foreignKey' => 'party_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Vehicles');
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
            ->scalar('vehicle_no')
            ->maxLength('vehicle_no', 200)
            ->requirePresence('vehicle_no', 'create')
            ->allowEmptyString('vehicle_no', false);

        $validator
            ->date('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->allowEmptyDate('transaction_date', false);

        $validator
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->allowEmptyString('status', false);

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->allowEmptyString('quantity', false);

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->allowEmptyString('created_by', false);

        // $validator
        //     ->dateTime('created_on')
        //     ->requirePresence('created_on', 'create')
        //     ->allowEmptyDateTime('created_on', false);

        // $validator
        //     ->integer('edited_by')
        //     ->allowEmptyString('edited_by');

        // $validator
        //     ->dateTime('edited_on')
        //     ->allowEmptyDateTime('edited_on');

        // $validator
        //     ->requirePresence('is_deleted', 'create')
        //     ->allowEmptyString('is_deleted', false);

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
        $rules->add($rules->existsIn(['party_id'], 'Parties'));

        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        @$data['name'] ? $data['name'] = ucwords($data['name']) : '';

        @$data['transaction_date'] ? $data['transaction_date'] = date('Y-m-d',strtotime($data['transaction_date'])) : '';
    }
}
