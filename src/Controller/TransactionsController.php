<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\View\Helper\UrlHelper;

/**
 * Transactions Controller
 *
 * @property \App\Model\Table\TransactionsTable $Transactions
 *
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products','Parties']
        ];

         $data=$this->Transactions->find()->where(['Transactions.is_deleted'=>0]);

        $transaction = $this->Transactions->newEntity();

        $datas = $this->request->getQuery();
        $datas=array_filter($datas);
        if(!empty($datas))
        {
            
            //pr($datas);
            if (!empty($datas['product_id']))
               $data->where(['product_id'=>$datas['product_id']]);
           if (!empty($datas['from_date']))
           {
               $data->where(['Transactions.transaction_date >='=>date('Y-m-d',strtotime($datas['from_date']))]);
           }
           if (!empty($datas['to_date']))
           {
               $data->where(['Transactions.transaction_date <='=>date('Y-m-d',strtotime($datas['to_date']))]); 
           }
           if (!empty($datas['status']))
           {
                $data->where(['status'=>$datas['status']]);
            }
            if (!empty($datas['party_id']))
                $data->where(['party_id'=>$datas['party_id']]);
        }
        else
        {
           $data->where(['Transactions.transaction_date >='=>date('Y-m-d',time() - 60* 60* 24),'Transactions.transaction_date <='=>date('Y-m-d')]);

        }
        
        $transactions = $this->paginate($data);

        $products = $this->Transactions->Products->find('all');
        $parties = $this->Transactions->Parties->find('list');
        $this->set(compact('transactions','products','parties','transaction'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => ['Products', 'Vehicles', 'Parties']
        ]);

        $this->set('transaction', $transaction);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transaction = $this->Transactions->newEntity();
        if ($this->request->is('post')) {

            $datas=$this->request->getData('transaction');
            foreach ($datas as $key => $data) {
                $datas[$key]['vehicle_id']=$this->request->getData('vehicle_id');
                $datas[$key]['transaction_date']=$this->request->getData('transaction_date');
                $datas[$key]['created_by'] = $this->Auth->user('id');
            }
            //pr($datas);
            
            $transaction = $this->Transactions->newEntities($datas);
            
            //pr($transaction);exit;
            if ($this->Transactions->saveMany($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $products = $this->Transactions->Products->find('list');
        $vehicles = $this->Transactions->Vehicles->find('list');
        $parties = $this->Transactions->Parties->find('list')->where(['id >' => 1]);
        $this->set(compact('transaction', 'products', 'vehicles', 'parties'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $products = $this->Transactions->Products->find('list');
        $parties = $this->Transactions->Parties->find('list');
        $this->set(compact('transaction', 'products','parties'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transaction = $this->Transactions->get($id);
        $transaction->is_deleted=1;
        if ($this->Transactions->save($transaction)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function inAmul()
    {

        $status='In';
        $transaction = $this->Transactions->newEntity();
        if ($this->request->is('post')) {

            $datas=$this->request->getData('transaction');
            
                
            foreach ($datas as $key => $data) {
                $datas[$key]['availiable_quantity']=$datas[$key]['quantity'];
                $datas[$key]['bill_no']=$this->request->getData('bill_no');
                $datas[$key]['remarks']=$this->request->getData('remarks');
                $datas[$key]['bill_date']=$this->request->getData('bill_date');
                $datas[$key]['vehicle_no']=$this->request->getData('vehicle_no');

                $datas[$key]['transaction_date']=$this->request->getData('transaction_date');
                $datas[$key]['party_id']=$this->request->getData('party_id');
                $datas[$key]['created_by'] = $this->Auth->user('id');
                $datas[$key]['status']=$status;

            }
            $transaction = $this->Transactions->newEntities($datas);
            
            //pr($transaction);exit;
            if ($this->Transactions->saveMany($transaction)) {

                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['controller'=>'transactions','action' => 'inamul']);
            }
            //pr($transaction);exit;
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $products = $this->Transactions->Products->find('all')->order(['name']);
        $vehicles = $this->Transactions->Vehicles->find('list',['keyField' => 'vehicle_no',
        'valueField' => function ($row) {
            return $row['vehicle_no'] . '  ('.$row['driver_name'].')';
        }]);
        $parties = $this->Transactions->Parties->find('list')->where(['party_type'=>'Amul']);
        $this->set(compact('transaction','products','vehicles','parties'));
    }
    public function outAmul()
    {
        $status='Out';
        $transaction = $this->Transactions->newEntity();
        if ($this->request->is('post')) {
            $datas=$this->request->getData('transaction');
            foreach ($datas as $key => $data) {
                $datas[$key]['vehicle_no']=$this->request->getData('vehicle_no');
                $datas[$key]['transaction_date']=$this->request->getData('transaction_date');
                $datas[$key]['created_by'] = $this->Auth->user('id');
                $datas[$key]['status']=$status;

            }
            //pr($datas);
            $transaction = $this->Transactions->newEntities($datas);
            
            //pr($transaction);exit;
            if ($this->Transactions->saveMany($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'outamul']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $products = $this->Transactions->Products->find('all')->order(['name']);
        $vehicles = $this->Transactions->Vehicles->find('list',['keyField' => 'vehicle_no',
        'valueField' => function ($row) {
            return $row['vehicle_no'] . '  ('.$row['driver_name'].')';
        }]);
        $parties = $this->Transactions->Parties->find('list')->where(['party_type'=>'Amul']);
        $this->set(compact('transaction','products','vehicles','parties'));
    }
   
    public function inWendor()
    {
        $status='In';
        $transaction = $this->Transactions->newEntity();
        if ($this->request->is('post')) {

            $datas=$this->request->getData('transaction');
            foreach ($datas as $key => $data) {
                $datas[$key]['vehicle_no']=$this->request->getData('vehicle_no');
                $datas[$key]['transaction_date']=$this->request->getData('transaction_date');
                $datas[$key]['created_by'] = $this->Auth->user('id');
                $datas[$key]['status'] = $status;
            }
            //pr($datas);
            
            $transaction = $this->Transactions->newEntities($datas);
            
            //pr($transaction);exit;
            if ($this->Transactions->saveMany($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'inwendor']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $products = $this->Transactions->Products->find('all')->order(['name']);
        $vehicles = $this->Transactions->Vehicles->find('list',['keyField' => 'vehicle_no',
        'valueField' => function ($row) {
            return $row['vehicle_no'] . '  ('.$row['driver_name'].')';
        }]);
        $parties = $this->Transactions->Parties->find('list')->where(['party_type'=>'Wholesale Dealer']);
        $this->set(compact('transaction', 'products', 'vehicles', 'parties'));
    }
     public function outWendor()
    {
        $status='Out';
        $Transaction = $this->Transactions->newEntity();
        if ($this->request->is('post')) {

            $datas=$this->request->getData('transaction');
            //pr($datas);
            foreach ($datas as $key => $data) {
                $datas[$key]['vehicle_no']=$this->request->getData('vehicle_no');
                $datas[$key]['transaction_date']=$this->request->getData('transaction_date');
                $datas[$key]['created_by'] = $this->Auth->user('id');
                $datas[$key]['status'] = $status;

                $out_quantity=$datas[$key]['quantity'];
                //pr($out_quantity);

                $availiable_quantities=$this->Transactions->find()->where(['status'=>'In','product_id'=>$data['product_id'],'availiable_quantity >'=>0])->order('dom');
                //pr($availiable_quantities->toArray());  

                $total_available=$this->Transactions->find();
                $total_available->select(['total'=>$total_available
                    ->func()->sum('availiable_quantity')])
                ->where(['status'=>'In','product_id'=>$data['product_id'],'availiable_quantity >'=>0])
                ->group('product_id')
                ->first();
                //pr($total_available->toArray());exit;
                if($total_available >= $out_quantity)
                {
                    foreach ($availiable_quantities as $value) {
                        $availiable_quantity=$value['availiable_quantity'];
                        if($availiable_quantity >= $out_quantity)
                        {
                            $transaction=$this->Transactions->get($value->id);
                            $transaction->availiable_quantity-=$out_quantity;
                            $transaction->edited_date=date('Y-m-d',strtotime($this->request->getData('transaction_date')));
                            $this->Transactions->save($transaction);
                            break;
                        }
                        else
                        {
                            $out_quantity -= $availiable_quantity;
                            $transaction=$this->Transactions->get($value->id);
                            $transaction->availiable_quantity= 0;
                            $transaction->edited_date=date('Y-m-d',strtotime($this->request->getData('transaction_date')));
                            $this->Transactions->save($transaction);
                        }
                    }
                }
                else
                {
                    $failed=1;
                    unset($datas[$key]);
                }
            }
            //pr($datas);
            
            $transactions = $this->Transactions->newEntities($datas);
            
            //pr($transactions);exit;
            if ($this->Transactions->saveMany($transactions)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'outwendor']);
            }
            //pr($transactions);exit;
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $products = $this->Transactions->Products->find('all')
        ->select($this->Transactions->Products)
        ->select(['total'=>'SUM(Transactions.availiable_quantity)'])
        ->innerJoinWith('Transactions')->group('Transactions.product_id')->order(['name']);
        //pr($products->toArray());exit;
        $vehicles = $this->Transactions->Vehicles->find('list',['keyField' => 'vehicle_no',
        'valueField' => function ($row) {
            return $row['vehicle_no'] . '  (' . $row['driver_name'].')';
        }]);
        $parties = $this->Transactions->Parties->find('list')->where(['party_type'=>'Wholesale Dealer']);
        $this->set(compact('Transaction', 'products', 'vehicles', 'parties'));
    }
    public function showAvailable()
    {
        $crate=1;
        $transaction = $this->Transactions->newEntity();
        if($this->request->is('post'))
        {
            $datas = $this->request->getData();
            if (!empty($datas['product_id']))
            {
                
                $data=$this->Transactions->find()
                ->select(['dom','amount_sum'=>'sum(availiable_quantity)'])
                ->where(['product_id'=>$datas['product_id'],'status'=>'In','availiable_quantity >'=>0])->group('dom');
                //pr($data->toArray());
                $crate=$this->Transactions->Products->find()->where(['id'=>$datas['product_id']]);
            }
        }
        $products = $this->Transactions->Products->find('all');
        
        $this->set(compact('products','data','transaction','crate'));

    }
    public function stockReport()
    {
        $stockReport = $this->Transactions->newEntity();

        $data = $this->Transactions->Products->find('all')
        ->select($this->Transactions->Products)
        ->select(['expiry_date'=>'DATE_ADD(Transactions.dom,INTERVAL Products.self_life DAY)','dom'=>'Transactions.dom','amount_sum'=>'SUM(Transactions.availiable_quantity)'])
        ->innerJoinWith('Transactions')
        ->where(['Transactions.status'=>'In','Transactions.availiable_quantity >'=>0])
        ->group(['Transactions.dom','Transactions.product_id'])
        ->order(['expiry_date']);
        if($this->request->is('post'))
        {
            $datas = $this->request->getData();

            if (!empty($datas['product_id']))
            {
               $data->where(['product_id'=>$datas['product_id']]);
            }

            if (!empty($datas['date']))
           {
               $data->where(['dom >= '=>date('Y-m-d',strtotime($datas['date']))]);
           }
           if (!empty($datas['to']))
           {
               $data->where(['dom <= '=>date('Y-m-d',strtotime($datas['to']))]); 
           }
            if (!empty($datas['to'])&&(!empty($datas['date'])))
           {
               $data->where(['dom <='=>date('Y-m-d',strtotime($datas['to'])),'dom >='=>date('Y-m-d',strtotime($datas['date']))]); 
           }
        }


        //pr($data->toArray());exit;
        $products = $this->Transactions->Products->find('all');
        $this->set(compact('data','stockReport','products'));

    }
    public function dashboard()
    {
       $arrival_today=$this->Transactions->find()
       ->select(['crate'=>'round(SUM(Transactions.quantity / Products.box_in_crate),1)'])
       ->innerJoinWith('Products')
       ->where(['Transactions.status'=>'In','Transactions.transaction_date'=>date('Y-m-d')])
       ->first();

       //pr($arrival_today);exit;
       
       $dispatch_today=$this->Transactions->find()
       ->select(['crate'=>'round(SUM(Transactions.quantity / Products.box_in_crate),1)'])
       ->innerJoinWith('Products')
       ->where(['Transactions.status'=>'Out','Transactions.transaction_date'=>date('Y-m-d')])
       ->first();

       //pr($dispatch_today);exit;

       $arrival_yesterday=$this->Transactions->find()
       ->select(['crate'=>'round(SUM(Transactions.quantity / Products.box_in_crate),1)'])
       ->innerJoinWith('Products')
       ->where(['Transactions.status'=>'In','Transactions.transaction_date <'=>date('Y-m-d')])
       ->group(['Transactions.product_id'])
       ->first();

       //pr($arrival_yesterday);

       $dispatch_yesterday=$this->Transactions->find()
       ->select(['crate'=>'round(SUM(Transactions.quantity / Products.box_in_crate),1)'])
       ->innerJoinWith('Products')
       ->where(['Transactions.status'=>'Out','Transactions.transaction_date <'=>date('Y-m-d')])
       ->group(['Transactions.product_id'])
       ->first();

       $data = $this->Transactions->Products->find('all')
        ->select($this->Transactions->Products)
        ->select(['expiry_date'=>'DATE_ADD(Transactions.dom,INTERVAL Products.self_life DAY)','dom'=>'Transactions.dom','amount_sum'=>'SUM(Transactions.availiable_quantity)'])
        ->innerJoinWith('Transactions')
        ->where(['Transactions.status'=>'In','Transactions.availiable_quantity >'=>0])
        ->group(['Transactions.dom','Transactions.product_id'])
        ->order(['expiry_date']);

        $empty_carton_in=$this->Transactions->CartonTransactions->find('all')
        ->select(['total_quantity'=>'SUM(quantity)'])
        ->where(['status'=>'In'])
        ->first();

        $empty_carton_out=$this->Transactions->CartonTransactions->find('all')
        ->select(['total_quantity'=>'SUM(quantity)'])
        ->where(['status'=>'Out'])
        ->first();
       
       $this->set(compact('arrival_today','dispatch_today','arrival_yesterday','dispatch_yesterday','data','empty_carton_in','empty_carton_out'));
    }

    public function dailySales()
    {
        

        $dailysale=$this->Transactions->newEntity();
        $data=$this->Transactions->find()->where(['status'=>'Out','Transactions.transaction_date <='=>date('Y.m.d',time() - 60* 60* 24)])->contain(['Products']);
        $products = $this->Transactions->Products->find('list');
        $this->set(compact('data','dailysale','products'));
    }

    public function dispatchSummary()
    {
        $this->viewBuilder()->setLayout('pdf_layout');
        $name='DisaptachReport'.date('d-M-Y').'.pdf';

        $this->paginate = [
            'contain' => ['Products','Parties']
        ];

         $data=$this->Transactions->find()->where(['Transactions.is_deleted'=>0,'Transactions.status'=>'Out','or'=>[['Transactions.transaction_date'=>date('Y-m-d')],['Transactions.transaction_date'=>date('Y.m.d',time() - 60* 60* 24)]]]);
        
        $transactions = $this->paginate($data);

        $products = $this->Transactions->Products->find('all');
        $parties = $this->Transactions->Parties->find('list');
        $this->set(compact('transactions','products','parties','transaction','head_title','name'));
    }

   
}
