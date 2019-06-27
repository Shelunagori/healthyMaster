<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 *
 * @method \App\Model\Entity\Customer[] paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		$customers = $this->Customers->find();  
		
        $this->set(compact('customers'));
        $this->set('_serialize', ['customers']);
    }

    public function customerLedger($id=null)
    {
    	$this->viewBuilder()->layout('index_layout');
    	$customers = $this->Customers->get($id, [
            'contain' => ['JainCashPoints'=>function($query){
				return $query->select([
					'total_point' => $query->func()->sum('point'),
					'total_used_point' => $query->func()->sum('used_point'),'customer_id'
				]);
			}
		]
	]);
    	$customer_address=$this->Customers->CustomerAddresses->find()->where(['CustomerAddresses.customer_id'=>$id]);
    	$orders = $this->Customers->Orders->find()->where(['Orders.customer_id'=>$id])
    	->contain(['OrderDetails']);
    	foreach ($orders as $order) {
    		$order_id=$order->id;
    		$points=$this->Customers->JainCashPoints->find()->where(['order_id'=>$order_id]);
    	}
    	$carts=$this->Customers->Carts->find()->where(['Carts.customer_id'=>$id])->contain(['Items','ItemVariations'=>['Units']]);
    	$wishlists=$this->Customers->Wishlists->find()->where(['Wishlists.customer_id'=>$id])->contain(['Items','ItemVariations'=>['Units']]);
    	//pr($id);
    	//pr($points->toArray());exit;
    	 $this->set(compact('customers','orders','carts','wishlists','customer_address','points'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$id;
		$Customers = $this->Customers->get($id, [
            'contain' => ['JainCashPoints'=>function($query){
				return $query->select([
					'total_point' => $query->func()->sum('point'),
					'total_used_point' => $query->func()->sum('used_point'),'customer_id'
				]);
			},'Wallets'=>function($query){
				return $query->select([
					'total_advance' => $query->func()->sum('advance'),
					'total_consumed' => $query->func()->sum('consumed'),'customer_id',
				]);
			},'Orders'=>function($query){
				return $query->select([
					
					'total_order' => $query->func()->count('customer_id'),'customer_id',
				]);
			}
				]
        ]);
		$jain_cash_gains=$this->Customers->ReferralDetails->find()->where(['from_customer_id'=>$id])->contain(['fromCustomer']);
		$jain_cash_uses=$this->Customers->JainCashPoints->find()->where(['JainCashPoints.customer_id'=>$id, 'order_id !='=>0])->contain(['Customers', 'Orders']);
		
		$wallet_advances=$this->Customers->Wallets->find()->where(['Wallets.customer_id'=>$id,'Wallets.order_id ='=>0])->contain(['Customers', 'Orders', 'Plans']);
		$wallet_consumes=$this->Customers->Wallets->find()->where(['Wallets.customer_id'=>$id,'Wallets.plan_id ='=> 0])->contain(['Customers', 'Orders']);
		$Orders=$this->Customers->Orders->find()->where(['Orders.customer_id'=>$id]);
        $this->set(compact('Customers', 'status', 'id', 'jain_cash_gains', 'jain_cash_uses', 'wallet_advances', 'wallet_consumes', 'Orders'));
        $this->set('_serialize', ['Customers', 'jain_cash_gains', 'jain_cash_uses', 'wallet_advances', 'wallet_consumes', 'Orders']);
    }

	
	public function totalWallet()
	{	
	
		$cusData = $this->Customers->find()->select('id');
		$sno = 1;
		echo '<table style="width:100%;">
						<thead>
							<tr>
								<td>Sno</td>
								<td>Customer Id</td>
								<td>Customer Name</td>
								<td>Customer Mobile</td>
								<td>Total Added</td>
								<td>Total total_consumed</td>
								<td>Avaliable Balance</td>
							</tr>
						</thead>';
		$i = 1;				
		foreach($cusData as $data)
		{  $id =  $data->id;
			$Customers = $this->Customers->get($id, [
				'contain' => ['Wallets'=>function($query){
					return $query->select([
						'total_advance' => $query->func()->sum('advance'),
						'total_consumed' => $query->func()->sum('consumed'),'customer_id',
					]);
				}]
			]);		
			
			$amount = 0.00;
			$added = 0.00;
			$consumed = 0.00;
			if(!empty($Customers->wallets))
			{
				$added = $Customers->wallets[0]->total_advance;
				$consumed = $Customers->wallets[0]->total_consumed;
				$amount =  $Customers->wallets[0]->total_advance - $Customers->wallets[0]->total_consumed;				
			}

			echo '<tbody>
							<tr>
								<td>'.$sno.'</td>
								<td>'.$Customers->id.'</td>
								<td>'.$Customers->name.'</td>
								<td>'.$Customers->mobile.'</td>
								<td>'.$added.'</td>
								<td>'.$consumed.'</td>
								<td>'.$amount.'</td>
							</tr>						
						</tbody>';
			$sno++;
			
			
		}
		echo '</table>';

	exit;
		
	}
	
	
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id=null)
    {
        $this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$customer = $this->Customers->newEntity();
		if ($this->request->is(['post'])) {
			$customer->status='completed';
			$customer->first_time_win_status='No';
			$customer->new_scheme='Yes';
			$customer->created_on=date('Y-m-d');
			$customer->notification_key='AAAAXmNqxY4:APA91bG0X6RHVhwJKXUQGNSSCas44hruFdR6_CFd6WHPwx9abUr-WsrfEzsFInJawElgrp24QzaE4ksfmXu6kmIL6JG3yP487fierMys5byv-I1agRtMPIoSqdgCZf8R0iqsnds-u4CU';
			//pr($customer);
			// $de=$this->request->getData();
			// pr($de);exit;

            $customer= $this->Customers->patchEntity($customer, $this->request->getData());
            //pr($customer->toArray());exit;
            if ($this->Customers->save($customer)) {
			
                $this->Flash->success(__('The customer has been saved.'));
                return $this->redirect(['action' => 'index','controller'=>'CustomerAddresses/index/'.$customer->id]);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $customer = $this->Customers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

	public function customerDetail($id=Null)
    {
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$customers = $this->Customers->get($id, [
            'contain' => ['JainCashPoints'=>function($query){
				return $query->select([
					'total_point' => $query->func()->sum('point'),
					'total_used_point' => $query->func()->sum('used_point'),'customer_id'
				]);
			},'Wallets'=>function($query){
				return $query->select([
					'total_advance' => $query->func()->sum('advance'),
					'total_consumed' => $query->func()->sum('consumed'),'customer_id'
				]);
			},'Orders']
        ]);		
		
        $this->set(compact('customers'));
        $this->set('_serialize', ['customers']);
    }


	public function ajaxCustomerReport()
    {
		$this->viewBuilder()->layout('ajax'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$customer = $this->Customers->get($this->request->data['customer_id'], [
            'contain' => ['JainCashPoints'=>function($query){
				return $query->select([
					'total_point' => $query->func()->sum('point'),
					'total_used_point' => $query->func()->sum('used_point'),'customer_id'
				]);
			},'Wallets'=>function($query){
				return $query->select([
					'total_advance' => $query->func()->sum('advance'),
					'total_consumed' => $query->func()->sum('consumed'),'customer_id'
				]);
			},'Orders']
        ]);
		
		$this->set(compact('customer'));
    }


	public function defaultAddress($id = null)
    { 
		$this->viewBuilder()->layout('');
		//pr($id);exit;
		if(empty($id)){
			echo ''; exit;
		}
		$defaultAddress = $this->Customers->CustomerAddresses->find('all')->where(['customer_id' => $id,'default_address' => 1])->order(['CustomerAddresses.id'=>'DESC'])->first();
		if(!empty($defaultAddress)){
			echo $defaultAddress->house_no.$defaultAddress->address." - ".$defaultAddress->locality;
			exit;
		}else{
			echo " ";   exit;
		}
    }
	
	public function defaultAddress1($id = null)
    { 
		$this->viewBuilder()->layout('');
		//pr($id);
		if(empty($id)){
			echo ''; exit;
		}
		$defaultAddress = $this->Customers->CustomerAddresses->find('all')->where(['customer_id' => $id,'default_address' => 1])->order(['CustomerAddresses.id'=>'DESC'])->first();
		if(!empty($defaultAddress)){
			echo $defaultAddress->id;			
			exit;
		}else{
			echo " ";   exit;
		}
    }
	
	public function addressList($id = null)
    {
		$this->viewBuilder()->layout('ajax_layout');
		
		if(empty($id)){
			echo 'Please Select Customer First.'; exit;
		}
        $customer = $this->Customers->get($id, [
            'contain' => ['CustomerAddresses']
        ]);
		
		
        $this->set('customer', $customer);
        $this->set('_serialize', ['customer']);
    }
	
    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function sendMessage()
    {
	$customers = $this->Customers->find(); 
	foreach($customers as $customer)
	{
		$customer_id=$customer->id;
		$mobile_no=$customer->mobile;
		/////////////////SMS//START///////////////////////////
		$sms='Order fresh fruits and vegetables https://goo.gl/RFnBP8';

		$working_key='A7a76ea72525fc05bbe9963267b48dd96';
		$sms_sender='JAINTE';
		$sms2=str_replace(' ', '+', $sms);
		/* echo file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_no.'&message='.$sms2.'');
		 */
		echo file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile_no.'&text='.$sms2.'&route=7');
		
		  
		////////////////SMS//END////////////////////////////////
					 
					echo "<br>";
		}
		exit;
	}
	
	public function report()
    {
	$this->viewBuilder()->layout('index_layout');
	
	$customers = $this->Customers->find(); 
	$customerName=[];
	$customerOrder=[];
	$cus_name=[];
	$cus_ord=[];
	foreach($customers as $customer)
	{
		$customer_id=$customer->id;
		$mobile_no=$customer->mobile;
		  
		  $customer_count_status=$this->Customers->Orders->find()->where(['Orders.customer_id'=>$customer_id,'Orders.status'=>'Delivered'])->count();
		  
		  if($customer_count_status>0){
			  
				$customer_id;
				$Customer_name=$customer->name;
				$mobile=$customer->mobile;
				$final_name=$Customer_name.' ('.$mobile.')';
				$customerName[$customer_id]=$final_name;
				$customerOrder[$customer_id]=$customer_count_status;
		  }
		  
		}
			 $this->set('customerName', $customerName);
			 $this->set('customerOrder', $customerOrder);
	}
	
	
	public function walletReport()
    {
	$this->viewBuilder()->layout('index_layout');
	
	$this->loadmodel('Wallets');
	
	$wallet_customers=$this->Wallets->find()->group('Wallets.customer_id')->contain(['Customers']);
	$remainings=[];
	foreach($wallet_customers as $data){
		$customer_id=$data->customer_id;
		$query = $this->Wallets->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['advance > ' => 0]),
				$query->newExpr()->add(['advance']),
				'integer'
			); 
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['consumed > ' => 0]),
				$query->newExpr()->add(['consumed']),
				'integer'
			);
			$query->select([
			'total_advanced' => $query->func()->sum($totalInCase),
			'total_consumed' => $query->func()->sum($totalOutCase),'id','customer_id'
		])
		->where(['Wallets.customer_id' => $customer_id])
		->autoFields(true);
		$wallets = ($query);
		//pr($wallets->toArray());
		foreach($wallets as $wallet){
			
			$total_advanced=$wallet->total_advanced;
			$total_consumed=$wallet->total_consumed;
			$remaining=$total_advanced-$total_consumed;
			
		}
		$remainings[$customer_id]=$remaining;
		
	}
//pr($wallet_customers->toArray()); exit;
			 $this->set('wallet_customers', $wallet_customers);
			 $this->set('remainings', $remainings);
	}
	
	
	
	public function holidaySms()
    {
	$customers = $this->Customers->find(); 
	foreach($customers as $customer)
	{
		$customer_id=$customer->id;
		$mobile_no=$customer->mobile;
		  
		  $customer_count_status=$this->Customers->Orders->find()->where(['Orders.customer_id'=>$customer_id,'Orders.status'=>'Delivered'])->count();
		  
		  if($customer_count_status>0){
			  
			 echo 'Cust_id-'.$customer_id.' Count-'.$customer_count_status;
			 
			 $sms=str_replace(" ", "+", "Dear Customer,%0aOn the occasion of Raksha Bandhan, all order will be delivered on 27th August 2018. %0aTeam JainThela");
	
			echo $mobile_no;
			$sms_sender='JAINTE';
			$sms=str_replace(' ', '+', $sms);
		  
			//$res=file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile_no.'&text='.$sms.'&route=7'); 
			////////////////SMS//END////////////////////////////////
	
			 echo "<br>";
		  }
		  
		}
		exit;
	}
}
