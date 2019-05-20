<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CartonTransactions Controller
 *
 * @property \App\Model\Table\CartonTransactionsTable $CartonTransactions
 *
 * @method \App\Model\Entity\CartonTransaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CartonTransactionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Parties']
        ];
        $cartonTransactions = $this->paginate($this->CartonTransactions);

        $this->set(compact('cartonTransactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Carton Transaction id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cartonTransaction = $this->CartonTransactions->get($id, [
            'contain' => ['Parties']
        ]);

        $this->set('cartonTransaction', $cartonTransaction);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
         $cartonTransaction = $this->CartonTransactions->newEntity();
        if ($this->request->is('post')) {
            $datas=$this->request->getData('cartontransaction');
            //pr($datas);exit;
            foreach ($datas as $key => $data) {
                $datas[$key]['vehicle_no']=$this->request->getData('vehicle_no');
                $datas[$key]['dmr_no']=$this->request->getData('dmr_no');
                $datas[$key]['transaction_date']=$this->request->getData('transaction_date');
                $datas[$key]['created_by'] = $this->Auth->user('id');
            }
            //pr($datas);exit;
            $cartonTransaction = $this->CartonTransactions->newEntities($datas);
            //pr($cartonTransaction);exit;
            if ($this->CartonTransactions->saveMany($cartonTransaction)) {
                $this->Flash->success(__('The Carton transaction has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The Carton transaction could not be saved. Please, try again.'));
        }
        $vehicles = $this->CartonTransactions->Vehicles->find('list',['keyField' => 'vehicle_no',
        'valueField' => function ($row) {
            return $row['vehicle_no'] . '  ('.$row['driver_name'].')';
        }]);
        $parties = $this->CartonTransactions->Parties->find('list')->where(['party_type'=>'Wholesale Dealer']);
        $this->set(compact('cartonTransaction', 'vehicles', 'parties'));
    }

    public function addDispatch()
    {
         $cartonTransaction = $this->CartonTransactions->newEntity();
        if ($this->request->is('post')) {
            $datas=$this->request->getData('cartontransaction');
            //pr($datas);exit;
            foreach ($datas as $key => $data) {
                $datas[$key]['vehicle_no']=$this->request->getData('vehicle_no');
                $datas[$key]['dmr_no']=$this->request->getData('dmr_no');
                $datas[$key]['transaction_date']=$this->request->getData('transaction_date');
                $datas[$key]['created_by'] = $this->Auth->user('id');
            }
            //pr($datas);
            $cartonTransaction = $this->CartonTransactions->newEntities($datas);
            //pr($cartonTransaction);exit;
            if ($this->CartonTransactions->saveMany($cartonTransaction)) {
                $this->Flash->success(__('The Carton transaction has been saved.'));

                return $this->redirect(['action' => 'addDispatch']);
            }
            $this->Flash->error(__('The Carton transaction could not be saved. Please, try again.'));
        }
        $vehicles = $this->CartonTransactions->Vehicles->find('list',['keyField' => 'vehicle_no',
        'valueField' => function ($row) {
            return $row['vehicle_no'] . '  ('.$row['driver_name'].')';
        }]);
        $parties = $this->CartonTransactions->Parties->find('list')->where(['party_type'=>'Amul']);
        $this->set(compact('cartonTransaction', 'vehicles','parties'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Carton Transaction id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cartonTransaction = $this->CartonTransactions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cartonTransaction = $this->CartonTransactions->patchEntity($cartonTransaction, $this->request->getData());
            if ($this->CartonTransactions->save($cartonTransaction)) {
                $this->Flash->success(__('The carton transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The carton transaction could not be saved. Please, try again.'));
        }
        $parties = $this->CartonTransactions->Parties->find('list');
        $this->set(compact('cartonTransaction', 'parties'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Carton Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cartonTransaction = $this->CartonTransactions->get($id);
        if ($this->CartonTransactions->delete($cartonTransaction)) {
            $this->Flash->success(__('The carton transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The carton transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function cartonReport()
    {
        $carton=$this->CartonTransactions->newEntity();

        $carton_in=$this->CartonTransactions->find('all')
            ->select($this->CartonTransactions)
            ->select(['quantities'=>'SUM(quantity)'])
            ->where(['status'=>'In']);
            //pr($carton_in->toArray());exit;   
        $carton_out=$this->CartonTransactions->find('all')
            ->select(['quantities'=>'SUM(quantity)'])
            ->where(['status'=>'Out']);

        $pop_view=$this->CartonTransactions->find('all')->contain(['Parties']);

        if($this->request->is('post'))
        {
            $datas = $this->request->getData();

            if (!empty($datas['party_id']))
            {
               $pop_view->where(['CartonTransactions.party_id'=>$datas['party_id']]);
            }

            if (!empty($datas['status']))
           {
                $pop_view->where(['status'=>$datas['status']]);
            }

            if (!empty($datas['dmr']))
           {
                $pop_view->where(['dmr_no'=>$datas['dmr']]);
            }


            if (!empty($datas['date']))
           {
               $pop_view->where(['CartonTransactions.created_on >= '=>date('Y-m-d',strtotime($datas['date']))]);
           }
           if (!empty($datas['to']))
           {
               $pop_view->where(['CartonTransactions.created_on <= '=>date('Y-m-d',strtotime($datas['to']))]); 
           }
            if (!empty($datas['to'])&&(!empty($datas['date'])))
           {
               $pop_view->where(['CartonTransactions.created_on <='=>date('Y-m-d',strtotime($datas['to'])),'CartonTransactions.created_on >='=>date('Y-m-d',strtotime($datas['date']))]); 
           }
        }

        $parties=$this->CartonTransactions->Parties->find('list');


        $this->set(compact('carton_in','carton_out','pop_view','carton','parties'));
    }
}
