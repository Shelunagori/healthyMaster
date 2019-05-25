<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
use Cake\I18n\Time;
use Cake\ORM\Behavior\TimestampBehavior;
class CartsController extends AppController
{
    public function plusAddToCart()
    {
		$jain_thela_admin_id=$this->request->data('jain_thela_admin_id');
		$item_id=$this->request->data('item_id');
		$item_variation_id=$this->request->data('item_variation_id');
		$customer_id=$this->request->data('customer_id');
		$items = $this->Carts->Items->get($item_id);
		$item_add_quantity=$items->minimum_quantity_factor;
		$is_combo=$items->is_combo;
		$fetchs=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id]);
		if(empty($fetchs->toArray()))
		{
			$query = $this->Carts->query();
					$query->insert(['customer_id', 'item_id','item_variation_id','quantity', 'cart_count', 'is_combo'])
							->values([
							'customer_id' => $customer_id,
							'item_id' => $item_id,
							'item_variation_id' => $item_variation_id,
							'quantity' => $item_add_quantity,
							'cart_count' => 1,
							'is_combo' => $is_combo
							])
					->execute();
		}else{
			foreach($fetchs as $fetch){
			$update_id=$fetch->id;
			$exist_quantity=$fetch->quantity;
			$exist_count=$fetch->cart_count;
		}
		$update_quantity=$item_add_quantity+$exist_quantity;
		$update_count=$exist_count+1;
		
			$cart=$this->Carts->get($update_id);	
			$query = $this->Carts->query();
				$result = $query->update()
                    ->set(['quantity' => $update_quantity, 'cart_count' => $update_count, 'is_combo' => $is_combo])
                    ->where(['id' => $update_id])
                    ->execute();
		}
		$carts=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id,'item_variation_id' =>$item_variation_id])
		->contain(['Items' => ['ItemVariations' => ['Units']]])
		->first();
        
		$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();

		$status=true;
		$error="";
        $this->set(compact('status', 'error','carts','cart_count'));
        $this->set('_serialize', ['status', 'error', 'carts','cart_count']);
    }
	public function minusAddToCart()
    {
		$jain_thela_admin_id=$this->request->data('jain_thela_admin_id');
		$item_id=$this->request->data('item_id');
		$item_variation_id=$this->request->data('item_variation_id');
		$customer_id=$this->request->data('customer_id');
		$items = $this->Carts->Items->get($item_id);
		$item_add_quantity=$items->minimum_quantity_factor;
		$is_combo=$items->is_combo;
		$fetchs=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id,'item_variation_id' => $item_variation_id]);
		
		if(empty($fetchs->toArray()))
		{
		$carts=$this->Carts->find()->where(['customer_id' => $customer_id,'item_id' =>$item_id,'item_variation_id' => $item_variation_id])
		->contain(['Items'])->first();
		
		if($carts==null)
		{
			$carts=(object)[];
		}
		else{
			$carts=$carts;
		}
		$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
		}
		else
		{
		foreach($fetchs as $fetch){
			$update_id=$fetch->id;
			$exist_quantity=$fetch->quantity;
			$exist_count=$fetch->cart_count;
		}
		$update_quantity=$exist_quantity-$item_add_quantity;
		$update_count=$exist_count-1;
		
			if($exist_count==1)
			{
				$cart=$this->Carts->get($update_id);	
				$query = $this->Carts->query();
				$result = $query->delete()
				->where(['id' => $update_id])
				->execute();
				$carts=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id,'item_variation_id' => $item_variation_id])->contain(['Items' => ['ItemVariations' => ['Units']]])->first();
				if($carts==null)
				{
				$carts=(object)[];
				}
				else{
				$carts=$carts;
				}
				$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			}
			else if($exist_count>1){
				$cart=$this->Carts->get($update_id);	
				$query = $this->Carts->query();
				$result = $query->update()
				->set(['quantity' => $update_quantity, 'cart_count' => $update_count, 'is_combo' => $is_combo])
				->where(['id' => $update_id])
				->execute();
				$carts=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id, 'item_variation_id' => $item_variation_id])->contain(['Items' => 
				['ItemVariations' => ['Units']]])->first();				
				$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			}
		}
		
		$status=true;
		$error="";
        $this->set(compact('status', 'error','carts','cart_count'));
        $this->set('_serialize', ['status', 'error', 'carts','cart_count']);
    }
	public function fetchAddToCart()
    {
		$jain_thela_admin_id=$this->request->data('jain_thela_admin_id');
		$item_id=$this->request->data('item_id');
		$item_variation_id=$this->request->data('item_variation_id');
		$customer_id=$this->request->data('customer_id');
		$promocode=$this->request->data('promocode');
		$tag=$this->request->data('tag');
		
		if($tag=='add'){
			$items = $this->Carts->Items->get($item_id);
			$item_add_quantity=$items->minimum_quantity_factor;
     		$is_combo=$items->is_combo;
    
        	$fetchs=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id, 'item_variation_id' =>$item_variation_id]);
			foreach($fetchs as $fetch){
				$update_id=$fetch->id;
				$exist_quantity=$fetch->quantity;
				$exist_count=$fetch->cart_count;
			}
			$update_quantity=$item_add_quantity+$exist_quantity;
			$update_count=$exist_count+1;
			
				if(empty($fetchs->toArray()))
				{
					$query = $this->Carts->query();
							$query->insert(['customer_id', 'item_id', 'quantity', 'cart_count', 'is_combo'])
									->values([
									'customer_id' => $customer_id,
									'item_id' => $item_id,
									'item_variation_id' => $item_variation_id,
									'quantity' => $item_add_quantity,
									'cart_count' => 1,
									'is_combo' => $is_combo
									])
							->execute();
				}else{
					$cart=$this->Carts->get($update_id);
					$query = $this->Carts->query();
						$result = $query->update()
							->set(['quantity' => $update_quantity, 'cart_count' => $update_count, 'is_combo' => $is_combo])
							->where(['id' => $update_id])
							->execute();
				}
		}
		else if($tag=='minus')
		{
			$items = $this->Carts->Items->get($item_id);
			$item_add_quantity=$items->minimum_quantity_factor;
     		$is_combo=$items->is_combo;
    
			$fetchs=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id,'item_variation_id' =>$item_variation_id]);
			if(empty($fetchs->toArray()))
			{
				$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			}
			else
			{
				foreach($fetchs as $fetch){
					$update_id=$fetch->id;
					$exist_quantity=$fetch->quantity;
					$exist_count=$fetch->cart_count;
				}
				$update_quantity=$exist_quantity-$item_add_quantity;
				$update_count=$exist_count-1;
			
				if($exist_count==1)
				{
					$cart=$this->Carts->get($update_id);	
					$query = $this->Carts->query();
					$result = $query->delete()
					->where(['id' => $update_id])
					->execute();
					$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
				
				}
				else if($exist_count>1){
					$cart=$this->Carts->get($update_id);	
					$query = $this->Carts->query();
					$result = $query->update()
					->set(['quantity' => $update_quantity, 'cart_count' => $update_count, 'is_combo' => $is_combo])
					->where(['id' => $update_id])
					->execute();
					$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
				}
			}
		}
		else if($tag=='remove'){
			$query = $this->Carts->query();
			$result = $query->delete()
				->where(['item_id' => $item_id, 'item_variation_id' => $item_variation_id, 'customer_id' => $customer_id])
				->execute();
			$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
		}
		else if($tag=='cart'){
			$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
		}
		$address_availablity = $this->Carts->CustomerAddresses->find()
			->where(['CustomerAddresses.customer_id'=>$customer_id]);
			if(empty($address_availablity->toArray()))
			{
				$address_available=false;
			}
			else
			{
				$address_available=true;
			}
			
		$carts=$this->Carts->find()
			->where(['customer_id' => $customer_id])
			->contain(['Items' => ['ItemVariations' =>['Units']]])
			->autoFields(true);
			
			if($carts==null)
			{
				$carts=[];
			}
			else{
				$carts=$carts;
			}		

		//pr($carts->toArray());exit;
				
		$grand_total1=0;
		foreach($carts as $cart_data)
		{
			foreach($cart_data->item->item_variations as $item_variation)
			{
				$saleRate = $item_variation->sales_rate;
				$count  = $cart_data->cart_count;
				$item_variation->total_varitaion_amount = $saleRate * $count;
				$cart_data->total += $item_variation->total_varitaion_amount;
			}
			
			$grand_total1+=$cart_data->total;
		}
		$grand_total=round($grand_total1);
		
		$subtotal = 0.00;
		
		$subtotal = $grand_total;
		
		
		$delivery_charges = '0';
		$this->loadModel('DeliveryCharges');
		$delivery_charges=$this->DeliveryCharges->find()->order(['id' =>'DESC'])->first();
		
		if($grand_total < $delivery_charges->amount)
		{
			$delivery_charges = $delivery_charges->charge;
			$grand_total = $grand_total + $delivery_charges->charge;
		}
		else
		{
			$delivery_charges = 'Free';
		}
		$discount_amount = 0.00;
		if(!empty($promocode))
		{
			$ts = Time::now('Asia/Kolkata');
			$current_timestamp = date('Y-m-d H:i:s',strtotime($ts));
			$this->loadModel('PromoCodes');
			$promoCodeLists = $this->PromoCodes->find()->where(['PromoCodes.valid_from <' =>$current_timestamp, 'PromoCodes.valid_to >' =>$current_timestamp,'PromoCodes.code'=>$promocode])->first();	
			$cat_item_total = 0.00;
		
			foreach($carts as $cart_data)
			{
				echo $cart_data->item->id;
				 if($promoCodeLists->promo_code_type = 'Item Wise')
				{
					if($cart_data->item->id == $promoCodeLists->item_id)
					{
						if($promoCodeLists->amount_type == 'percent')
						{
							$discount_amount =  $cart_data->total * $promoCodeLists->discount_per / 100;
						}
						else if($promoCodeLists->amount_type == 'amount' && $cart_data->total > $promoCodeLists->discount_per)
						{
							$discount_amount =  $cart_data->total - $promoCodeLists->discount_per;
						}						
					}
				}

				else if($promoCodeLists->promo_code_type = 'Category Wise')
				{
					if($cart_data->item->item_category_id == $promoCodeLists->item_category_id)
					{
						$cat_item_total = $cat_item_total + $cart_data->total;
					}

					if($promoCodeLists->amount_type == 'percent')
					{
						$discount_amount =  $cat_item_total * $promoCodeLists->discount_per / 100;
					}
					else if($promoCodeLists->amount_type == 'amount' && $cat_item_total > $promoCodeLists->discount_per)
					{
						$discount_amount =  $cat_item_total - $promoCodeLists->discount_per;
					}						
				} 			
			} 


				if($promoCodeLists->promo_code_type = 'Free Shipping')
				{
					
				}

				if($promoCodeLists->promo_code_type = 'On Cart Value')
				{
					
				}	
		
		}

		if(empty($carts->toArray()))
		{			
			$status=false;
			$error='Cart is Empty';
			$this->set(compact('status', 'error'));
			$this->set('_serialize', ['status', 'error']);
		}
		else{
			$status=true;
			$error='';
			$this->set(compact('status', 'error','address_available','grand_total','carts','delivery_charges','subtotal','discount_amount'));
			$this->set('_serialize', ['status', 'error','subtotal','delivery_charges','discount_amount','grand_total','address_available','carts']);
		}
	}
	
	public function reviewOrder()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$customer_id=$this->request->query('customer_id');
		$cart_details=$this->Carts->find()->where(['customer_id' => $customer_id])
		->contain(['Items'=> ['ItemVariations' => ['Units']]]);
		$cart_details->select(['image_url' => $cart_details->func()->concat(['http://healthymaster.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])])
                                ->autoFields(true);
								
		        $out_of_stock_data=$this->Carts->find()->where(['customer_id' => $customer_id]);
        		$counts=0;
				foreach($out_of_stock_data as $fetch_data)
				{
					$item_id=$fetch_data->item_id;
					$out_data=$this->Carts->Items->get($item_id);
					$d=$out_data->out_of_stock;
					$counts+=$d;
				}
				
		if($counts>0)
		{
		    $isNextDayOrder=true;
        }
		else{
			
			$isNextDayOrder=false;
		}
		
		$current_time =  strtotime(date('h:i a'));
		 $first_time=strtotime('10:00 am');
		 $last_time=strtotime('01:00 pm');
		 $first_time1=strtotime('04:00 pm');
		 $last_time1=strtotime('07:00 pm');
		if(($current_time>=$first_time) && ($current_time<$last_time) )
		{
		$delivery_time=$this->Carts->DeliveryTimes->find()
		->select(['delivery_time' => $this->Carts->DeliveryTimes->find()->func()->concat(['time_from' => 'identifier','-','time_to' => 'identifier' ])])
		->where(['DeliveryTimes.id !=' =>1])
		->autoFields(true);	
		}
		else if(($current_time>=$last_time) && ($current_time<$first_time1) )
		{
		$delivery_time=$this->Carts->DeliveryTimes->find()
		->select(['delivery_time' => $this->Carts->DeliveryTimes->find()->func()->concat(['time_from' => 'identifier','-','time_to' => 'identifier' ])])
		->where(['DeliveryTimes.id' =>3])
		->autoFields(true);	
		}
		else if(($current_time>=$first_time1) && ($current_time<=$last_time1) )
		{
		$delivery_time=$this->Carts->DeliveryTimes->find()
		->select(['delivery_time' => $this->Carts->DeliveryTimes->find()->func()->concat(['time_from' => 'identifier','-','time_to' => 'identifier' ])])
		->where(['DeliveryTimes.id !=' =>3])
		->autoFields(true);
		}
		else{
			$delivery_time=$this->Carts->DeliveryTimes->find()
		->select(['delivery_time' => $this->Carts->DeliveryTimes->find()->func()->concat(['time_from' => 'identifier','-','time_to' => 'identifier' ])])
		->where(['DeliveryTimes.id !=' =>3])
		->autoFields(true);
		}
		
		$delivery_time=$this->Carts->DeliveryTimes->find()
		->select(['delivery_time' => $this->Carts->DeliveryTimes->find()->func()->concat(['time_from' => 'identifier','-','time_to' => 'identifier' ])])
		->where(['DeliveryTimes.id' =>1])
		->autoFields(true);
		
		/* $delivery_time_schedule=$this->Carts->DeliveryTimes->find()
		->select(['delivery_time' => $this->Carts->DeliveryTimes->find()->func()->concat(['time_from' => 'identifier','-','time_to' => 'identifier' ])])
		->where(['DeliveryTimes.time_from <' =>$current_time, 'DeliveryTimes.time_to >' =>$current_time])
		->orWhere(['DeliveryTimes.time_from =' =>$current_time])
		->orWhere(['DeliveryTimes.time_to =' =>$current_time])
		->autoFields(true)->first();
		
		if(!empty($delivery_time_schedule))
		{
			$delivery_time=$this->Carts->DeliveryTimes->find()
		->select(['delivery_time' => $this->Carts->DeliveryTimes->find()->func()->concat(['time_from' => 'identifier','-','time_to' => 'identifier' ])])
		->where(['DeliveryTimes.id !=' =>$delivery_time_schedule->id])
		->autoFields(true);
		}
		else if(empty($delivery_time_schedule)){
			$delivery_time=$this->Carts->DeliveryTimes->find()
		->select(['delivery_time' => $this->Carts->DeliveryTimes->find()->func()->concat(['time_from' => 'identifier','-','time_to' => 'identifier' ])])
		->autoFields(true);
		} */
		
				
		$carts=$this->Carts->find()
				->where(['customer_id' => $customer_id])
				->contain(['Items'=> ['ItemVariations' =>['Units']]])
				->select(['total'=>'sum(Carts.cart_count * Items.sales_rate)'])
				->group('Carts.item_id')
				->autoFields(true);
		$grand_total=0;
		foreach($carts as $cart_data)
		{
			$grand_total+=round($cart_data->total);
		}
		
		$customer_addresses=$this->Carts->CustomerAddresses->find()
		->where(['CustomerAddresses.customer_id' => $customer_id, 'CustomerAddresses.default_address'=>'1'])->first();

		
		$generate_order_no=uniqid();
		

$Customers = $this->Carts->Customers->get($customer_id, [
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
		if(empty($Customers->wallets))
		{
			$remaining_wallet_amount=0;
		}
		else{
		foreach($Customers->wallets as $Customer_data_wallet){
		  $wallet_total_advance=$Customer_data_wallet->total_advance;
		  $wallet_total_consumed=$Customer_data_wallet->total_consumed;
		  $remaining_wallet_amount=round($wallet_total_advance-$wallet_total_consumed);
		}
		}
		 
		 if(empty($Customers->jain_cash_points))
		{
			$remaining_jain_cash_point=0;
		}
		else{
		foreach($Customers->jain_cash_points as $Customer_data_jain_cash){
		  $jain_cash_total_point=$Customer_data_jain_cash->total_point;
		  $jain_cash_total_used_point=$Customer_data_jain_cash->total_consumed;
		  $remaining_jain_cash_point=round($jain_cash_total_point-$jain_cash_total_used_point);
		}
		}
		
		 $cash_limit=$this->Carts->Users->get($jain_thela_admin_id);
		 $jain_cash_limit=$cash_limit->jain_cash_limit;

		
		$status=true;
		$error="";
        $this->set(compact('status', 'error','isNextDayOrder','remaining_wallet_amount','remaining_jain_cash_point','jain_cash_limit','generate_order_no','grand_total','customer_addresses','delivery_time','cart_details'));
        $this->set('_serialize', ['status', 'error','isNextDayOrder','remaining_wallet_amount','remaining_jain_cash_point','jain_cash_limit','generate_order_no','grand_total','customer_addresses','delivery_time','cart_details']);
    }

}
