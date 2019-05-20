<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PopTransactions Controller
 *
 * @property \App\Model\Table\PopTransactionsTable $PopTransactions
 *
 * @method \App\Model\Entity\PopTransaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PopTransactionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Vehicles', 'Parties']
        ];

        $popTransactions = $this->paginate($this->PopTransactions);

        $this->set(compact('popTransactions'));
    }

   

    /**
     * View method
     *
     * @param string|null $id Pop Transaction id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $popTransaction = $this->PopTransactions->get($id, [
            'contain' => ['Vehicles', 'Parties']
        ]);

        $this->set('popTransaction', $popTransaction);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $popTransaction = $this->PopTransactions->newEntity();
        if ($this->request->is('post')) {
            $datas=$this->request->getData('poptransaction');
            //pr($datas);
            foreach ($datas as $key => $data) {
                $datas[$key]['vehicle_no']=$this->request->getData('vehicle_no');
                $datas[$key]['transaction_date']=$this->request->getData('transaction_date');
                $datas[$key]['created_by'] = $this->Auth->user('id');
                $datas[$key]['status'] = 'In';
            }
            //pr($datas);
            $popTransaction = $this->PopTransactions->newEntities($datas);
            //pr($popTransaction);exit;
            if ($this->PopTransactions->saveMany($popTransaction)) {
                $this->Flash->success(__('The pop transaction has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The pop transaction could not be saved. Please, try again.'));
        }
        $vehicles = $this->PopTransactions->Vehicles->find('list',['keyField' => 'vehicle_no',
        'valueField' => function ($row) {
            return $row['vehicle_no'] . '  ('.$row['driver_name'].')';
        }]);
        $pops = $this->PopTransactions->Pops->find('list');
        $parties = $this->PopTransactions->parties->find('list')->where(['party_type'=>'Amul']);
        $this->set(compact('popTransaction', 'vehicles','pops','parties'));
    }

    public function addDispatch()
    {
        $popTransaction = $this->PopTransactions->newEntity();
        if ($this->request->is('post')) {
            $datas=$this->request->getData('poptransaction');
            //pr($datas);
            foreach ($datas as $key => $data) {
                $datas[$key]['vehicle_no']=$this->request->getData('vehicle_no');
                $datas[$key]['transaction_date']=$this->request->getData('transaction_date');
                $datas[$key]['created_by'] = $this->Auth->user('id');
                $datas[$key]['status'] = 'Out';
            }
            //pr($datas);
            $popTransaction = $this->PopTransactions->newEntities($datas);
            //pr($popTransaction);exit;
            if ($this->PopTransactions->saveMany($popTransaction)) {
                $this->Flash->success(__('The pop transaction has been saved.'));

                return $this->redirect(['action' => 'addDispatch']);
            }
            $this->Flash->error(__('The pop transaction could not be saved. Please, try again.'));
        }
        $vehicles = $this->PopTransactions->Vehicles->find('list',['keyField' => 'vehicle_no',
        'valueField' => function ($row) {
            return $row['vehicle_no'] . '  ('.$row['driver_name'].')';
        }]);
        $pops = $this->PopTransactions->Pops->find('list');
        $parties = $this->PopTransactions->parties->find('list')->where(['party_type'=>'Wholesale Dealer']);
        $this->set(compact('popTransaction', 'vehicles','pops','parties'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pop Transaction id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $popTransaction = $this->PopTransactions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $popTransaction = $this->PopTransactions->patchEntity($popTransaction, $this->request->getData());
            if ($this->PopTransactions->save($popTransaction)) {
                $this->Flash->success(__('The pop transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pop transaction could not be saved. Please, try again.'));
        }
        $vehicles = $this->PopTransactions->Vehicles->find('list');
        $parties = $this->PopTransactions->Parties->find('list');
        $this->set(compact('popTransaction', 'vehicles', 'parties'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pop Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $popTransaction = $this->PopTransactions->get($id);
        if ($this->PopTransactions->delete($popTransaction)) {
            $this->Flash->success(__('The pop transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The pop transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function popEmptyReport()
    {
        $poptransaction = $this->PopTransactions->newEntity();
        if($this->request->is('post'))
        {
            $datas = $this->request->getData();
            if (!empty($datas['pop_id']))
            {

                $pop_in=$this->PopTransactions->find('all')
                ->select($this->PopTransactions)
                ->select(['quantities'=>'SUM(quantity)'])
                ->where(['status'=>'In','pop_id'=>$datas['pop_id']]);
                //pr($pop_in->toArray());exit;
                $pop_out=$this->PopTransactions->find('all')
                ->select(['quantities'=>'SUM(quantity)'])
                ->where(['status'=>'Out','pop_id'=>$datas['pop_id']]);

                $pop_view=$this->PopTransactions->find('all')->where(['pop_id'=>$datas['pop_id']])->contain(['Parties']);

        // $empty_carton_in=$this->PopTransactions->find('all')
        // ->select($this->PopTransactions)
        // ->select(['quantities'=>'SUM(quantity)'])
        // ->where(['status'=>'In']);

        // $empty_carton_out=$this->PopTransactions->find('all')
        // ->select($this->PopTransactions)
        // ->select(['quantities'=>'SUM(quantity)'])
        // ->where(['status'=>'Out']);
            }
        }

        $pops = $this->PopTransactions->Pops->find('list');

        $this->set(compact('pop_in','pop_out','pops','datas','poptransaction','pop_view'));
    }

}
