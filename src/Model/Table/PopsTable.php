<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * Pops Model
 *
 * @method \App\Model\Entity\Pop get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pop newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pop[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pop|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pop|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pop patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pop[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pop findOrCreate($search, callable $callback = null, $options = [])
 */
class PopsTable extends Table
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

        $this->setTable('pops');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->maxLength('name', 30)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        @$data['name'] ? $data['name'] = ucwords($data['name']) : '';

        @$data['date'] ? $data['date'] = date('Y-m-d',strtotime($data['date'])) : '';
    }
}
