<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
use Cake\ORM\TableRegistry;
class OrdersController extends AppController
{
	public function updateOnlinePaymentStatus()
    {
		
		$order_id=$this->request->query('order_id');
		$online_payment_status=$this->request->query('online_payment_status');

		$orderStatus = $this->Orders->query();
					$result = $orderStatus->update()
						->set(['online_payment_status' => $online_payment_status])
						->where(['transaction_order_no' => $order_id])
						->execute();
					exit;
    }
	
    public function trackOrder()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$customer_id=$this->request->query('customer_id');
		$orders_data = $this->Orders->find()
						->where(['customer_id' => $customer_id, 'jain_thela_admin_id' => $jain_thela_admin_id, 'status' => 'In Process'])
						->order(['order_date' => 'DESC'])
						->contain(['OrderDetails'=>function($q){
							return $q->contain(['Items'])->limit(1);
						}])
						->autoFields(true);


					foreach($orders_data as $data)
					{
						$data->created_date=date('D M j, Y H:i a', strtotime($data->order_date));
						$data->order_date=date('D M j, Y H:i a', strtotime($data->order_date));
                        $data->delivery_date=date('D M j, Y H:i a', strtotime($data->delivery_date)); 

					}
						
		foreach($orders_data as $order){
			$order->image_url='http://healthymaster.in'.$this->request->webroot.'img/item_images/'.@$order->order_details[0]->item->image;
			unset($order->order_details);
		}
		
		$status=true;
		$error="";
        $this->set(compact('status', 'error','orders_data'));
        $this->set('_serialize', ['status', 'error', 'orders_data']);
    }
	public function viewMyTrackOrder()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$customer_id=$this->request->query('customer_id');
		$order_id=$this->request->query('order_id');
		
		$orders_details_data = $this->Orders->get($order_id, ['contain'=>
		['OrderDetails'=>	
			['ItemVariations' =>['Units','Items'=>function($q)
			{
			   return $q->select(['image_path' => $q->func()->concat(['http://healthymaster.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])])
			   ->autoFields(true);
			}]]
			
		]]);
	
		if(!empty($orders_details_data->toArray()))
		{
			
			foreach($orders_details_data->order_details as $details)
			{
				$details->item = $details->item_variation->item;
				unset($details->item_variation->item);
				$details->item->item_variation = [$details->item_variation];
				unset($details->item_variation);
			}
			//pr($orders_details_data);exit;
			
			$orders_details_data->invoice_link = '';
			
			$orders_details_data->curent_date=date('D M j, Y H:i a', strtotime($orders_details_data->curent_date));
			$orders_details_data->order_date=date('D M j, Y H:i a', strtotime($orders_details_data->order_date));
			$orders_details_data->delivery_date=date('D M j, Y H:i a', strtotime($orders_details_data->delivery_date));
			
			 $c_a_id=$orders_details_data->customer_address_id;
			 $customer_addresses=$this->Orders->CustomerAddresses->find()
			->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.id'=>$c_a_id])->first();
			
			if(empty($customer_addresses)) { $customer_addresses = (object)[]; }
			
			 $cancellation_reasons=$this->Orders->CancelReasons->find();
			

			$status=true;
			$error="Order data found successfully";			
		}
		else
		{
			$status=false;
			$error="No data Found";			
		}			

        $this->set(compact('status', 'error','orders_details_data','customer_addresses','cancellation_reasons'));
        $this->set('_serialize', ['status', 'error', 'orders_details_data','customer_addresses','cancellation_reasons']);
    }

	public function myOrder()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$customer_id=$this->request->query('customer_id');
		
		$orders_data = $this->Orders->find()
		->where(['customer_id' => $customer_id, 'jain_thela_admin_id' => $jain_thela_admin_id, 'status IN' => ['Delivered','Cancel','In Process','Placed'] ])
		->order(['order_date' => 'DESC'])
		->contain(['OrderDetails'=>function($q){
				return $q->contain(['ItemVariations' =>['Items','Units']]);
			}])
			->autoFields(true);
		if($orders_data->toArray())
		{
			foreach($orders_data as $data)
			{
				$data->created_date=date('D M j, Y H:i a', strtotime($data->order_date));
				$data->order_date=date('D M j, Y H:i a', strtotime($data->order_date));
				$data->delivery_date=date('D M j, Y H:i a', strtotime($data->delivery_date)); 
			}
							
			//pr($orders_data->toArray());exit;
							
			foreach($orders_data as $order){
				$order->total_item_count = sizeof($order->order_details);
				
				$order->item_name = @$order->order_details[0]->item_variation->item->name;
				$order->quantity = @$order->order_details[0]->quantity;  
				$order->varitation_name	=	@$order->order_details[0]->item_variation->quantity_variation .' '.@$order->order_details[0]->item_variation->unit->shortname;
				$order->image_url='http://healthymaster.in'.$this->request->webroot.'img/item_images/'.@$order->order_details[0]->item_variation->item->image;
				unset($order->order_details);
			} 
			$status=true;
			$error="Order list found successfully";			
		}else {
			$status=false;
			$error="No data found";			
		}			
        $this->set(compact('status', 'error','orders_data'));
        $this->set('_serialize', ['status', 'error', 'orders_data']);
    }
	
	public function cancelOrder()
    {
		$customer_id=$this->request->query('customer_id');
		$order_id=$this->request->query('order_id');
		@$cancel_id=$this->request->query('cancel_id');
		@$other_comment=$this->request->query('other_comment');
 		
		if(empty($cancel_id))
		{
			$cancel_id = 3;
		}
		
		
		$odrer_datas=$this->Orders->get($order_id);
		$o_date=$odrer_datas->order_date;
		//$amount_from_wallet=$odrer_datas->amount_from_wallet;
		$amount_from_wallet = 0;
		$amount_from_jain_cash=$odrer_datas->amount_from_jain_cash;
		$amount_from_promo_code=$odrer_datas->amount_from_promo_code;
		$online_amount=$odrer_datas->online_amount;
		
		//$return_amount=$amount_from_wallet + $amount_from_jain_cash + $amount_from_promo_code+$online_amount;
				
		$order_cancel = $this->Orders->query();
		$result = $order_cancel->update()
			->set(['status' => 'Cancel',
			'cancel_id' => $cancel_id, 'order_date' => $o_date,'other_comment' => $other_comment])
			->where(['id' => $order_id])
			->execute();
						
						
		$query = $this->Orders->JainCashPoints->query();
		$query->insert(['customer_id', 'point','is_refered','order_id','narration'])
				->values([
				'customer_id' => $customer_id,
				'point' => $amount_from_jain_cash,
				'is_refered' => 'Yes',
				'order_id' => $order_id,
				'narration' => 'Amount Return form Order'				
				])
		->execute();

		//end this code///		

		
		$customer_details=$this->Orders->Customers->find()
		->where(['Customers.id' => $customer_id])->first();
		$mobile=$customer_details->mobile;

		$sms=str_replace(' ', '+', 'Your order has been cancelled.' );
		$working_key='A7a76ea72525fc05bbe9963267b48dd96';
		$sms_sender='JAINTE';
		$sms=str_replace(' ', '+', $sms);
				
		//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile.'&text='.$sms.'&route=7');
		
		$status=true;
		$error="Thank you, your order has been cancelled.";
        $this->set(compact('status', 'error'));
        $this->set('_serialize', ['status', 'error']);
    }
	public function deliveredOrder()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$order_id=$this->request->query('order_id');
		$is_login=$this->request->query('is_login'); ///warehouse or driver///
		$driver_warehouse_id=$this->request->query('driver_warehouse_id');
		$transaction_date=date('Y-m-d');
		if($is_login=='warehouse')
		{
 			    $odrer_datas=$this->Orders->get($order_id);
				$o_date=$odrer_datas->order_date;
				$discount_percent=$odrer_datas->discount_percent;
				$delivery_date=date('Y-m-d 00:00:00');
				$current_time=date('h:i:s:a');
			        $order_delivered = $this->Orders->query();
					$result = $order_delivered->update()
						->set(['status' => 'Delivered',
						'delivery_date'=>$delivery_date,
						'actual_deliver_time'=>$current_time])
						->where(['id' => $order_id])
						->execute();
		//end tis code///
                    
					$delivery_details=$this->Orders->OrderDetails->find()
					->where(['order_id' => $order_id]);
					foreach($delivery_details as $deliver_data)
					{
					 $item_type=$this->Orders->Items->find()
					->where(['Items.id' => $deliver_data->item_id])->first();
				      $is_virtual=$item_type->is_virtual;
					  $is_id=$item_type->id;
					  $parent_item_id=$item_type->parent_item_id;
					  $is_combo=$item_type->is_combo;
					  $combo_offer_id=$item_type->combo_offer_id;
					  $combo_actual_quantity=$deliver_data->actual_quantity;
					  $rate=$deliver_data->rate;
					  $amount=$deliver_data->amount;
					  
					  $discount_amount=round(($amount*$discount_percent)/100);
					  $actual_amount=($amount-$discount_amount);
					  $actual_rate=$actual_amount/$combo_actual_quantity;
					  
				  if($is_combo=='no')
				  {
					  if($is_virtual=='yes')
					  {
							$query = $this->Orders->ItemLedgers->query();
					        $query->insert(['jain_thela_admin_id', 'warehouse_id', 'item_id', 'rate', 'amount', 'quantity', 'inventory_transfer','transaction_date', 'order_id', 'status'])
							->values([
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'warehouse_id' => $driver_warehouse_id,
							'item_id' => $parent_item_id,
							'rate' => $deliver_data->rate,
							'amount' => $deliver_data->amount,
							'quantity' => $deliver_data->actual_quantity,
							'inventory_transfer' => 'no',
							'transaction_date'=>$transaction_date,
							'order_id'=>$order_id,
							'status'=>'out'
							])
					        ->execute(); 
					  }
					  else if($is_virtual=='no'){
						  $query = $this->Orders->ItemLedgers->query();
					        $query->insert(['jain_thela_admin_id', 'warehouse_id', 'item_id', 'rate', 'amount','quantity', 'inventory_transfer','transaction_date','order_id', 'status'])
							->values([
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'warehouse_id' => $driver_warehouse_id,
							'item_id' => $is_id,
							'rate' => $actual_rate,
							'amount' => $actual_amount,
							'quantity' => $deliver_data->actual_quantity,
							'inventory_transfer' => 'no',
							'transaction_date'=>$transaction_date,
							'order_id'=>$order_id,
							'status'=>'out'
							])
					        ->execute(); 
					  }
					 
					}
					else{
					  $combo_details=$this->Orders->ComboOfferDetails->find()
					->where(['ComboOfferDetails.combo_offer_id' => $combo_offer_id]);
					
					for($k=1;$k<=$combo_actual_quantity;$k++)
					{
						
					  foreach($combo_details as $combo_details_data)
					  {
					  $item_type=$this->Orders->Items->find()
					->where(['Items.id' => $combo_details_data->item_id])->first();
				      $is_virtual=$item_type->is_virtual;
					  $is_id=$item_type->id;
					  $parent_item_id=$item_type->parent_item_id;
					  $is_combo=$item_type->is_combo;
					  
					  if($is_virtual=='yes')
					  {
							$query = $this->Orders->ItemLedgers->query();
					        $query->insert(['jain_thela_admin_id', 'warehouse_id', 'item_id', 'rate', 'amount', 'quantity', 'inventory_transfer','transaction_date','order_id', 'status'])
							->values([
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'warehouse_id' => $driver_warehouse_id,
							'item_id' => $parent_item_id,
							'rate' => $combo_details_data->rate,
							'amount' => $combo_details_data->amount,
							'quantity' => $combo_details_data->quantity,
							'inventory_transfer' => 'no',
							'transaction_date'=>$transaction_date,
							'order_id'=>$order_id,
							'status'=>'out'
							])
					        ->execute(); 
					  }
					  else if($is_virtual=='no'){
						  $query = $this->Orders->ItemLedgers->query();
					        $query->insert(['jain_thela_admin_id', 'warehouse_id', 'item_id', 'rate', 'amount', 'quantity', 'inventory_transfer','transaction_date','order_id', 'status'])
							->values([
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'warehouse_id' => $driver_warehouse_id,
							'item_id' => $is_id,
							'rate' => $combo_details_data->rate,
							'amount' => $combo_details_data->amount,
							'quantity' => $combo_details_data->quantity,
							'inventory_transfer' => 'no',
							'transaction_date'=>$transaction_date,
							'order_id'=>$order_id,
							'status'=>'out'
							])
					        ->execute(); 
					  }  
					 }
					}
					}
					  
				}
		}
		else if($is_login=='driver')
		{
					$odrer_datas=$this->Orders->get($order_id);
					$o_date=$odrer_datas->order_date;
					$discount_percent=$odrer_datas->discount_percent;
			        $delivery_date=date('Y-m-d 00:00:00');
					$current_time=date('h:i:s:a');
			        $order_delivered = $this->Orders->query();
					$result = $order_delivered->update()
						->set(['status' => 'Delivered',
						'delivery_date' => $delivery_date,
						'actual_deliver_time' => $current_time])
						->where(['id' => $order_id])
						->execute();
                    
					$delivery_details=$this->Orders->OrderDetails->find()
					->where(['order_id' => $order_id]);
					foreach($delivery_details as $deliver_data)
					{
					 $item_type=$this->Orders->Items->find()
					->where(['Items.id' => $deliver_data->item_id])->first();
						$is_virtual=$item_type->is_virtual;
						$is_id=$item_type->id;
						$parent_item_id=$item_type->parent_item_id;
						$is_combo=$item_type->is_combo;
						$combo_offer_id=$item_type->combo_offer_id;
						$combo_actual_quantity=$deliver_data->actual_quantity;
						$rate=$deliver_data->rate;
						$amount=$deliver_data->amount;

						$discount_amount=round(($amount*$discount_percent)/100);
						$actual_amount=($amount-$discount_amount);
						$actual_rate=$actual_amount/$combo_actual_quantity;
					  
				  if($is_combo=='no')
				  {
					  if($is_virtual=='yes')
					  {
							$query = $this->Orders->ItemLedgers->query();
					        $query->insert(['jain_thela_admin_id', 'driver_id', 'item_id', 'rate','amount', 'quantity', 'inventory_transfer','transaction_date','order_id', 'status'])
							->values([
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'driver_id' => $driver_warehouse_id,
							'item_id' => $parent_item_id,
							'rate' => $deliver_data->rate,
							'amount' => $deliver_data->amount,
							'quantity' => $deliver_data->actual_quantity,
							'inventory_transfer' => 'no',
							'transaction_date'=>$transaction_date,
							'order_id'=>$order_id,
							'status'=>'out'
							])
					        ->execute(); 
					  }
					  else if($is_virtual=='no'){
						  $query = $this->Orders->ItemLedgers->query();
					        $query->insert(['jain_thela_admin_id', 'driver_id', 'item_id', 'rate', 'amount','quantity', 'inventory_transfer','transaction_date','order_id','status'])
							->values([
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'driver_id' => $driver_warehouse_id,
							'item_id' => $is_id,
							'rate' => $actual_rate,
							'amount' => $actual_amount,
							'quantity' => $deliver_data->actual_quantity,
							'inventory_transfer' => 'no',
							'transaction_date'=>$transaction_date,
							'order_id'=>$order_id,
							'status'=>'out'
							])
					        ->execute(); 
					  }
					 
					}
					else{
					  $combo_details=$this->Orders->ComboOfferDetails->find()
					->where(['ComboOfferDetails.combo_offer_id' => $combo_offer_id]);
					for($g=1;$g<=$combo_actual_quantity;$g++)
					{
						
					  foreach($combo_details as $combo_details_data)
					  {
					  $item_type=$this->Orders->Items->find()
					->where(['Items.id' => $combo_details_data->item_id])->first();
				      $is_virtual=$item_type->is_virtual;
					  $is_id=$item_type->id;
					  $parent_item_id=$item_type->parent_item_id;
					  $is_combo=$item_type->is_combo;
					  
					  if($is_virtual=='yes')
					  {
							$query = $this->Orders->ItemLedgers->query();
					        $query->insert(['jain_thela_admin_id', 'driver_id', 'item_id', 'rate', 'amount', 'quantity', 'inventory_transfer','transaction_date','order_id','status'])
							->values([
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'driver_id' => $driver_warehouse_id,
							'item_id' => $parent_item_id,
							'rate' => $combo_details_data->rate,
							'amount' => $combo_details_data->amount,
							'quantity' => $combo_details_data->quantity,
							'inventory_transfer' => 'no',
							'transaction_date'=>$transaction_date,
							'order_id'=>$order_id,
							'status'=>'out'
							])
					        ->execute(); 
					  }
					  else if($is_virtual=='no'){
						  $query = $this->Orders->ItemLedgers->query();
					        $query->insert(['jain_thela_admin_id', 'driver_id', 'item_id', 'rate', 'amount', 'quantity', 'inventory_transfer','transaction_date','order_id', 'status'])
							->values([
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'driver_id' => $driver_warehouse_id,
							'item_id' => $is_id,
							'rate' => $combo_details_data->rate,
							'amount' => $combo_details_data->amount,
							'quantity' => $combo_details_data->quantity,
							'inventory_transfer' => 'no',
							'transaction_date'=>$transaction_date,
							'order_id'=>$order_id,
							'status'=>'out'
							])
					        ->execute(); 
					  }  
					 }
					}
					}
					  
				}
		}
					$order_details=$this->Orders->find()
					->where(['id' => $order_id])->first();
					$order_no=$order_details->order_no;
					$grand_total=$order_details->grand_total;
					$customer_id=$order_details->customer_id;
					$delivery_date=date('D M j, Y H:i a', strtotime($order_details->delivery_date));
					
					$customer_details=$this->Orders->Customers->find()
					->where(['Customers.id' => $customer_id])->first();
					$mobile=$customer_details->mobile;
					$API_ACCESS_KEY=$customer_details->notification_key;
					$device_token=$customer_details->device_token;
					$device_token1=rtrim($device_token);
                    $time1=date('Y-m-d G:i:s');
					
 if(!empty($device_token1))
					{
					
	$msg = array
	(
	'message' 	=> 'Thank You, your order delivered successfully',
	'image' 	=> '',
	'button_text'	=> 'See Your Order',
    'link' => 'jainthela://my_order?id='.$order_details->id,	
    'notification_id'	=> 1,
	);

$url = 'https://fcm.googleapis.com/fcm/send';
$fields = array
(
	'registration_ids' 	=> array($device_token1),
	'data'			=> $msg
);
$headers = array
(
	'Authorization: key=' .$API_ACCESS_KEY,
	'Content-Type: application/json'
);

  //echo json_encode($fields);
  $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
$result001 = curl_exec($ch);
if ($result001 === FALSE) {
	die('FCM Send Error: ' . curl_error($ch));
}
curl_close($ch);
					}  
					/*....................................*/

					$sms=str_replace(' ', '+', 'Thank You, Your order has been delivered successfully. your order no. is: '.$order_no.'' );
					$working_key='A7a76ea72525fc05bbe9963267b48dd96';
					$sms_sender='JAINTE';
					$sms=str_replace(' ', '+', $sms);
					/* file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms.''); */
					
					file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile.'&text='.$sms.'&route=7');
					
		$status=true;
		$error="Thank you, order delivered successfully.";
        $this->set(compact('status', 'error'));
        $this->set('_serialize', ['status', 'error']);
    }
	
	public function placeOrder()
    {
		$customer_id=$this->request->data('customer_id');		
		$customer_address_id=$this->request->data('customer_address_id');
		$order_type=$this->request->data('order_type');		
		$order_from=$this->request->data('order_from');
		$grand_total=$this->request->data('total_amount');
		$online_amount=$this->request->data('online_amount');
		$jain_cash_amount=$this->request->data('redeem_points');	
		$payment_status=$this->request->data('payment_status');
		$promocode=$this->request->data('promo_code');		
		$order_no=$this->request->data('temp_order_no');
		$discount_amount= 0;
		$discount_amount=$this->request->data('discount_amount');
		$delivery_charge=$this->request->data('delivery_charge');
		
		$warehouse_id=1;
		$order = $this->Orders->newEntity();
		$curent_date=date('Y-m-d');
		$order_date=date('Y-m-d');
		$order_time=date('h:i:s:a');
		
		
		$cdate = strtotime("+7 day");
        $deliverydate = date('Y-m-d', $cdate);
		 
	
		
		$jain_thela_admin_id = 1;		
			$last_order_no = $this->Orders->find()
			->select(['get_auto_no'])
			->order(['get_auto_no'=>'DESC'])->first();

			if(!empty($last_order_no)){
				$get_auto_no = h(str_pad(number_format($last_order_no->get_auto_no+1),6, '0', STR_PAD_LEFT));
			}else{
				$get_auto_no=h(str_pad(number_format(1),6, '0', STR_PAD_LEFT));
			}
			$get_date=str_replace('-','',$curent_date);
			$exact_order_no=h('W'.$get_date.$get_auto_no);
			
			
			$this->loadModel('Carts');
			$carts_data=$this->Carts->find()->where(['customer_id'=>$customer_id])
			->contain(['ItemVariations' => 'Items']);
			if(!empty($carts_data->toArray()))
			{
				if(!empty($promocode))
				{
					$ts = Time::now('Asia/Kolkata');
					$current_timestamp = date('Y-m-d H:i:s',strtotime($ts));
					$this->loadModel('PromoCodes');
					$promoCodeLists = $this->PromoCodes->find()->where(['PromoCodes.valid_from <' =>$current_timestamp, 'PromoCodes.valid_to >' =>$current_timestamp,'PromoCodes.code'=>$promocode])->first();	
					$promo_code_id = $promoCodeLists->id;	
				} 
				else { $promo_code_id = 0; }	
				
				$i=0;
					foreach($carts_data as $carts_data_fetch)
					{
						$amount=$carts_data_fetch->cart_count*$carts_data_fetch->item_variation->sales_rate;
						$this->request->data['order_details'][$i]['item_variation_id']=$carts_data_fetch->item_variation->id;	$this->request->data['order_details'][$i]['item_id']=$carts_data_fetch->item_variation->item_id;
						$this->request->data['order_details'][$i]['quantity']=$carts_data_fetch->cart_count;
						$this->request->data['order_details'][$i]['rate']=$carts_data_fetch->item_variation->sales_rate;
						$this->request->data['order_details'][$i]['amount']=$amount;
						$this->request->data['order_details'][$i]['is_combo']=$carts_data_fetch->is_combo;
						
						$this->request->data['order_details'][$i]['status']='Placed';
						$i++;
					}
					
					$pay_amount = $grand_total;
					$total_amount = $grand_total;
					if($discount_amount > 0)
					{
						$total_amount = $total_amount + $discount_amount;
					}
					
					if($delivery_charge > 0)
					{
						$total_amount = $total_amount - $delivery_charge;
					}	
					
							
								
					$order = $this->Orders->patchEntity($order, $this->request->getData());
					$order->transaction_order_no=$order_no;
					$order->order_no=$exact_order_no;
					$order->customer_id=$customer_id;
					$order->jain_thela_admin_id=$jain_thela_admin_id;
					$order->customer_address_id=$customer_address_id;
					$order->amount_from_jain_cash=$jain_cash_amount;
					$order->amount_from_promo_code=$discount_amount;
					$order->total_amount=$total_amount;
					$order->grand_total=$grand_total;
					$order->pay_amount=$pay_amount;
					$order->online_amount=$online_amount;
					$order->delivery_charge=$delivery_charge;
					//$order->delivery_charge_id=$delivery_charge_id;
					$order->promo_code_id=$promo_code_id;
					$order->order_type=$order_type;
					//$order->discount_percent=$discount_percent;
					$order->status='Placed';
					$order->curent_date=$curent_date;
					$order->get_auto_no=$get_auto_no;
					$order->delivery_date=$deliverydate;
					$order->payment_status=$payment_status;
					$order->order_from=$order_from;
					$order->warehouse_id=$warehouse_id;
					//$order->delivery_time=$delivery_time;
					//$order->delivery_time_id=$delivery_time_id;
					$order->order_date=$order_date;
					$order->order_time=date('h:i:s:a');
					//pr($order);exit;
					$this->Orders->save($order);
					
					if($jain_cash_amount>0)
					{
						$this->loadModel('JainCashPoints');
						$queryj = $this->JainCashPoints->query();
						$queryj->insert(['customer_id','is_refered','used_point','order_id'])
								->values([
								'customer_id' => $order->customer_id,
								'is_refered' =>'No',
								'used_point' => $jain_cash_amount,
								'order_id' =>$order->id
								])
						->execute();
					}			
					
					///////////////////////DELETED CART/////////////////
						$this->loadModel('Carts');
						
						$query = $this->Carts->query();
						$result = $query->delete()
							->where(['customer_id' => $customer_id])
							->execute(); 

							$customer_details=$this->Orders->Customers->find()
							->where(['Customers.id' => $customer_id])->first();
							$mobile=$customer_details->mobile;
							$API_ACCESS_KEY=$customer_details->notification_key;
							$device_token=$customer_details->device_token;
							$device_token1=rtrim($device_token);
							$time1=date('Y-m-d G:i:s');
							
						if(!empty($device_token1))
							{
							
								$msg = array
								(
								'message' 	=> 'Thank You, your order place successfully',
								'image' 	=> '',
								'button_text'	=> 'Track Your Order',
								'link' => 'healthymaster://order?id='.$order->id,	
								'notification_id'	=> 1,
								);

									$url = 'https://fcm.googleapis.com/fcm/send';
									$fields = array
									(
										'registration_ids' 	=> array($device_token1),
										'data'			=> $msg
									);
									$headers = array
									(
										'Authorization: key=' .$API_ACCESS_KEY,
										'Content-Type: application/json'
									);

									  //echo json_encode($fields);
									  $ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $url);
									curl_setopt($ch, CURLOPT_POST, true);
									curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
									$result001 = curl_exec($ch);
									if ($result001 === FALSE) {
										die('FCM Send Error: ' . curl_error($ch));
									}
									curl_close($ch);
							}  
						
						$sms=str_replace(' ', '+', 'Thank You, Your order placed successfully. order no. is: '.$order->order_no);
			
						$working_key='A7a76ea72525fc05bbe9963267b48dd96';
						$sms_sender='JAINTE';
						$sms=str_replace(' ', '+', $sms);
					
						//file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile.'&text='.$sms.'&route=7');
							
						$status=true;
						$error="Thank You, Your order has been placed.";
				
			}else
			{
						$status=false;
						$error="Empty Cart";				
			}				
				$this->set(compact('status', 'error'));
				$this->set('_serialize', ['status', 'error']);
	}
	
	public function pendingOrderList()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$driver_warehouse_id=$this->request->query('driver_warehouse_id');
		$is_login=$this->request->query('is_login');
		
		if($is_login=='warehouse')
		{
		$pending_order_data = $this->Orders->find()
						->where(['Orders.warehouse_id' => $driver_warehouse_id, 'Orders.jain_thela_admin_id' => $jain_thela_admin_id, 'Orders.status' =>'In Process'])
						->order(['Orders.id' => 'DESC'])
						->contain(['Customers','CustomerAddresses','OrderDetails'=>function($q){
							return $q->contain(['Items'])->limit(1);
						}])
						->autoFields(true);
						
					foreach($pending_order_data as $data)
					{
						if(!$data->customer_address){
							$data->customer_address=(object)[];
						}
						
						$data->created_date=date('D M j, Y H:i a', strtotime($data->order_date));
						$data->order_date=date('D M j, Y H:i a', strtotime($data->order_date));
                        $data->delivery_date=date('D M j, Y H:i a', strtotime($data->delivery_date)); 

					}
		
						
		foreach($pending_order_data as $order){
			$order->image_url='http://healthymaster.in'.$this->request->webroot.'img/item_images/'.@$order->order_details[0]->item->image;
			unset($order->order_details);
		}	
		}
		else if($is_login=='driver')
		{
		
		$pending_order_data = $this->Orders->find()
						->select(['created_date' => $this->Orders->find()->func()->concat(['order_date' => 'identifier' ])])
						->where(['Orders.driver_id' => $driver_warehouse_id, 'Orders.jain_thela_admin_id' => $jain_thela_admin_id, 'Orders.status NOT IN' => array('Cancel','Delivered') ])
						->order(['Orders.id' => 'DESC'])
						->contain(['Customers','CustomerAddresses','OrderDetails'=>function($q){
							return $q->contain(['Items'])->limit(1);
						}])
						->autoFields(true);
						
					foreach($pending_order_data as $data)
					{
						$data->created_date=date('D M j, Y H:i a', strtotime($data->order_date));
						$data->order_date=date('D M j, Y H:i a', strtotime($data->order_date));
                        $data->delivery_date=date('D M j, Y H:i a', strtotime($data->delivery_date)); 

					}
						
						
		foreach($pending_order_data as $order){
			$order->image_url='http://healthymaster.in'.$this->request->webroot.'img/item_images/'.@$order->order_details[0]->item->image;
			unset($order->order_details);
		}	
		}
		

		$status=true;
		$error="";
        $this->set(compact('status', 'error','pending_order_data'));
        $this->set('_serialize', ['status', 'error','pending_order_data']);
    }
	
	public function viewMyPendingOrder()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$customer_id=$this->request->query('customer_id');
		$order_id=$this->request->query('order_id');
		
		

              
		
		$view_pending_details_data = $this->Orders->get($order_id, ['contain'=>['OrderDetails'=>['Items'=>function($q){
			 return $q->select(['image_path' => $q->func()->concat(['http://healthymaster.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])])
			   ->contain('Units')
			   ->autoFields(true);
			}]]]);
			
			
		$view_pending_details_data->curent_date=date('D M j, Y H:i a', strtotime($view_pending_details_data->curent_date));
	 	$view_pending_details_data->order_date=date('D M j, Y H:i a', strtotime($view_pending_details_data->order_date));
	    $view_pending_details_data->delivery_date=date('D M j, Y H:i a', strtotime($view_pending_details_data->delivery_date));
			
		$details=$view_pending_details_data->order_details;
		$i=0;
		$minimum_value=1;
		foreach($details as $carts_data_fetch)
			{
			$exact_amount=$minimum_value/$carts_data_fetch->item->minimum_quantity_factor*$carts_data_fetch->rate;
			$carts_data_fetch->exact_amount=$exact_amount;
			}

		 $c_a_id=$view_pending_details_data->customer_address_id;
		 $customer_addresses1=$this->Orders->CustomerAddresses->find()
		->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.id'=>$c_a_id])->first();
		

		$customer_addresses1->address = $customer_addresses1->house_no.' '.$customer_addresses1->landmark.' '.$customer_addresses1->address.', '.$customer_addresses1->locality;
			

	if(empty($customer_addresses1))
		{
			$customer_addresses=(object)[];
		}
		else{
			$customer_addresses=$customer_addresses1;
		}
		
		
		
		//(object)[]
		
		
		 $customer_details=$this->Orders->Customers->find()
		->where(['Customers.id' => $customer_id])->first();
		
		$cancellation_reasons=$this->Orders->CancelReasons->find();
		
		$status=true;
		$error="";
        $this->set(compact('status', 'error','view_pending_details_data','customer_details','customer_addresses','cancellation_reasons'));
        $this->set('_serialize', ['status', 'error', 'view_pending_details_data','customer_details','customer_addresses','cancellation_reasons']);
    }
	
	public function driverBilling()
    {
		//$jain_thela_admin_id=$this->request->data('jain_thela_admin_id');
		//$item_id=$this->request->data('item_id');
		$id=$this->request->data('id');//[]//
		$quantity=$this->request->data('quantity');//[]//
		$amount=$this->request->data('amount');//[]//
		$total_amount=$this->request->data('total_amount');
		$pay_amount=$this->request->data('pay_amount');
		$delivery_charge=$this->request->data('delivery_charge');
		$first_order_discount_amount=$this->request->data('first_order_discount_amount');
		$order_id=$this->request->data('order_id');
		
		$total_ids=sizeof($id);
		
		
		
		$grand_total=$total_amount+$delivery_charge;
		
		$fetchs=$this->Orders->find()->where(['id' =>$order_id])->first();
			$query = $this->Orders->query();
				$result = $query->update()
                    ->set(['total_amount' => $total_amount, 'grand_total' => $grand_total, 'pay_amount' => $pay_amount])
                    ->where(['id' => $order_id])
                    ->execute();
		
		
		for($i=0; $i<$total_ids; $i++)
		{
		       $order_details_id=$id[$i];
               $item_quantity=$quantity[$i];
               $item_amount=$amount[$i];			   
			$querys = $this->Orders->OrderDetails->query();
				$results = $querys->update()
                    ->set(['actual_quantity' => $item_quantity, 'amount' => $item_amount])
                    ->where(['id' => $order_details_id])
                    ->execute();
		}
	
		$Order_details = $this->Orders->get($order_id, ['contain'=>['OrderDetails'=>['Items'=>function($q){
               return $q->select(['image_path' => $q->func()->concat(['http://healthymaster.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])])->contain('Units')->autoFields(true);
			}]]]);	
			
			$order_detail_fetch=$this->Orders->get($order_id);
			$customer_id=$order_detail_fetch->customer_id;
			 $customer_details=$this->Orders->Customers->find()
                    ->where(['Customers.id' => $customer_id])->first();
                    $mobile=$customer_details->mobile;
                    $API_ACCESS_KEY=$customer_details->notification_key;
                    $device_token=$customer_details->device_token;
                    $device_token1=rtrim($device_token);
                    $time1=date('Y-m-d G:i:s');

    if(!empty($device_token1))
    {

    $msg = array
    (
    'message'     => 'Your order has been ready to delivery',
    'image'     => '',
    'button_text'    => 'Track Your Order',
    'link' => 'jainthela://order?id='.$order_id,
    'notification_id'    => 1,
    );

$url = 'https://fcm.googleapis.com/fcm/send';
$fields = array
(
    'registration_ids'     => array($device_token1),
    'data'            => $msg
);
$headers = array
(
    'Authorization: key=' .$API_ACCESS_KEY,
    'Content-Type: application/json'
);

  //echo json_encode($fields);
  $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
$result001 = curl_exec($ch);
if ($result001 === FALSE) {
    die('FCM Send Error: ' . curl_error($ch));
}
curl_close($ch);
        }
			
			
			
		$status=true;
		$error="Thank You";
        $this->set(compact('status', 'error','Order_details'));
        $this->set('_serialize', ['status', 'error','Order_details']);
    }
	
	public function itemCancel()
    {
		//$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$mainid=$this->request->query('order_detail_id');
		$order_id=$this->request->query('order_id');
		$customer_id=$this->request->query('customer_id');    			
        $detail_amount=$this->Orders->OrderDetails->find()->where(['id' => $mainid])->first();
		$amount=$detail_amount->amount;			
		$query = $this->Orders->OrderDetails->query();
		$result = $query->update()
			->set(['status' => 'Cancel'])
			->where(['id' => $mainid])
			->execute();
			
		$order_data=$this->Orders->find()
				->where(['id' => $order_id,'customer_id' =>$customer_id])
				->first();
			
		$total_amount=$order_data->total_amount-$amount;
        $grand_total=$total_amount+$order_data->delivery_charge;
		$pay_amount = ($grand_total) - (($order_data->amount_from_wallet) + ($order_data->amount_from_jain_cash) + ($order_data->amount_from_promo_code) + ($order_data->online_amount));

		$orderItems = $this->Orders->find()->contain(['OrderDetails' => function ($q) {
			return $q->where(['OrderDetails.status !=' => 'Cancel']);
		}])->where(['Orders.id' => $order_id,'Orders.customer_id' => $customer_id])->first();

		$totalItem = sizeof($orderItems->order_details);

		if($totalItem == 0)
		{
			$cancel_id = 1;
			$this->cancelOrder();
		}
		else if($pay_amount>=0)
		{
			$paid_amount=$pay_amount;
			//update order amount in order//
			$querys = $this->Orders->query();
						 $results = $querys->update()
						->set(['total_amount'=>$total_amount, 
						'grand_total'=>$grand_total, 'pay_amount'=>$paid_amount])
						->where(['id' => $order_id])
						->execute();
		}
		
		$status=true;
		$error="Item Cancelled.";
        $this->set(compact('status', 'error'));
        $this->set('_serialize', ['status', 'error']);
    }	
	
}
