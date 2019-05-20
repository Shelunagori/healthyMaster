<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\Http\ServerRequest;
use ArrayObject;

/**
 * Transactions Model
 *
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \App\Model\Table\PartiesTable|\Cake\ORM\Association\BelongsTo $Parties
 *
 * @method \App\Model\Entity\Transaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transaction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Transaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transaction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaction|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transaction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transaction findOrCreate($search, callable $callback = null, $options = [])
 */
class TransactionsTable extends Table
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
        

        $this->setTable('transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Vehicles');
        $this->belongsTo('Parties', [
            'foreignKey' => 'party_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CartonTransactions');
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
            ->maxLength('vehicle_no', 255)
            ->requirePresence('vehicle_no', 'create')
            ->allowEmptyString('vehicle_no', false);

        // $validator
        //     ->scalar('batch_no')
        //     ->maxLength('batch_no', 255)
        //     ->allowEmptyString('batch_no');

        $validator
            ->date('dom')
            ->allowEmptyDate('dom');

        $validator
            ->decimal('mrp')
            ->requirePresence('mrp', 'create')
            ->allowEmptyString('mrp', false);

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
            ->integer('availiable_quantity')
            ->allowEmptyString('availiable_quantity');

        $validator
            ->date('bill_date')
            ->allowEmptyDate('bill_date');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->allowEmptyString('created_by', false);

        // $validator
        //     ->dateTime('created_on')
        //     ->requirePresence('created_on', 'create')
        //     ->allowEmptyDateTime('created_on', false);

        $validator
            ->integer('edited_by')
            ->allowEmptyString('edited_by');

        $validator
            ->dateTime('edited_on')
            ->allowEmptyDateTime('edited_on');

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
        $r=new ServerRequest();
        $url=$r->getUri()->getPath();
        $action=explode('/', $url);
        $action=array_pop($action);

        if($action == "inamul")
        {
        $rules->add($rules->isUnique(['bill_no','product_id','party_id','dom','batch_no']));
        }
        else
            $rules->add($rules->isUnique(['bill_no','product_id','party_id']));
        $rules->add($rules->existsIn(['product_id'], 'Products'));
        $rules->add($rules->existsIn(['party_id'], 'Parties'));

        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        @$data['name'] ? $data['name'] = ucwords($data['name']) : '';

        @$data['dom'] ? $data['dom'] = date('Y-m-d',strtotime($data['dom'])) : '';
        @$data['transaction_date'] ? $data['transaction_date'] = date('Y-m-d',strtotime($data['transaction_date'])) : '';
        @$data['bill_date'] ? $data['bill_date'] = date('Y-m-d',strtotime($data['bill_date'])) : '';
    }
}
