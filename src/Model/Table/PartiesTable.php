<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * Parties Model
 *
 * @property |\Cake\ORM\Association\HasMany $PopTransactions
 * @property |\Cake\ORM\Association\HasMany $Transactions
 *
 * @method \App\Model\Entity\Party get($primaryKey, $options = [])
 * @method \App\Model\Entity\Party newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Party[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Party|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Party|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Party patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Party[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Party findOrCreate($search, callable $callback = null, $options = [])
 */
class PartiesTable extends Table
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

        $this->setTable('parties');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('PopTransactions', [
            'foreignKey' => 'party_id'
        ]);
        $this->hasMany('Transactions', [
            'foreignKey' => 'party_id'
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('address')
            ->allowEmptyString('address');

        $validator
            ->scalar('mobile_no')
            ->maxLength('mobile_no', 10)
            ->allowEmptyString('mobile_no');

        $validator
            ->scalar('owner_name')
            ->maxLength('owner_name', 40)
            ->requirePresence('owner_name', 'create')
            ->allowEmptyString('owner_name', false);

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        @$data['name'] ? $data['name'] = ucwords($data['name']) : '';

        @$data['date'] ? $data['date'] = date('Y-m-d',strtotime($data['date'])) : '';
    }
}
