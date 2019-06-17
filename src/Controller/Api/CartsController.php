<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
use Cake\I18n\Time;
use Cake\ORM\Behavior\TimestampBehavior;
class CartsController extends AppController
{
	public function moveToCart()
	{
		$id = $this->request->data('wish_list_id');
		$customer_id=$this->request->data('customer_id');
		$jain_thela_admin_id=1;
		$item_id=$this->request->data('item_id');
		$item_variation_id=$this->request->data('item_variation_id');
			
		$this->loadModel('Wishlists');
		$exists = $this->Wishlists->exists(['id'=>$id]);
		if($exists==1){
			$WishListItems = $this->Wishlists->get($id);
			$this->Wishlists->delete($WishListItems);
			$success = true;
			$message = 'removed from wish list';
			$this->plusAddToCart();
		 }else{
			 $success = false;
			 $message = 'No record found in wish list';
			$this->set(compact('success','message','carts','cart_count'));
			$this->set('_serialize',['success','message','cart_count','carts']);			 
		 }
		 
	}	
		
    public function plusAddToCart()
    {
		$jain_thela_admin_id=$this->request->data('jain_thela_admin_id');
		$item_id=$this->request->data('item_id');
		$item_variation_id=$this->request->data('item_variation_id');
		$customer_id=$this->request->data('customer_id');
		$items = $this->Carts->Items->get($item_id);
		//$item_add_quantity=$items->minimum_quantity_factor;
		$item_add_quantity=1;
		$is_combo=$items->is_combo;
		$fetchs=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id,'item_variation_id'=>$item_variation_id]);
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
		}else
		{
			foreach($fetchs as $fetch){
				$update_id=$fetch->id;
				$exist_quantity=$fetch->quantity;
				$exist_count=$fetch->cart_count;
			}
			//$update_quantity=$item_add_quantity+$exist_quantity;
			$update_quantity=$item_add_quantity;
			$update_count=$exist_count+1;
		
			$cart=$this->Carts->get($update_id);	
			$query = $this->Carts->query();
				$result = $query->update()
                    ->set(['quantity' => $item_add_quantity, 'cart_count' => $update_count, 'is_combo' => $is_combo])
                    ->where(['id' => $update_id])
                    ->execute();
		}
		$carts=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id,'item_variation_id' =>$item_variation_id])
		->contain(['Items' => ['ItemVariations' => ['Units']]])
		->first();
        
		$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();

		$status=true;
		$error="Item successfully added";
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
		//$item_add_quantity=$items->minimum_quantity_factor;
		$item_add_quantity=1;
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
		//$update_quantity=$exist_quantity-$item_add_quantity;
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
				->set(['quantity' => $item_add_quantity, 'cart_count' => $update_count, 'is_combo' => $is_combo])
				->where(['id' => $update_id])
				->execute();
				$carts=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id, 'item_variation_id' => $item_variation_id])->contain(['Items' => 
				['ItemVariations' => ['Units']]])->first();				
				$cart_count = $this->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			}
		}
		
		$status=true;
		$error="Item successfully removed";
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
		$redeem_points=$this->request->data('redeem_points');
		$tag=$this->request->data('tag');
		$pincode=$this->request->data('pincode');
		$isPointsRedeem = false;
		if($tag=='add'){
			$items = $this->Carts->Items->get($item_id);
			//$item_add_quantity=$items->minimum_quantity_factor;
			$item_add_quantity=1;
     		$is_combo=$items->is_combo;
    
        	$fetchs=$this->Carts->find()->where(['customer_id' => $customer_id, 'item_id' =>$item_id,'item_variation_id'=>$item_variation_id]);
			
			
				if(empty($fetchs->toArray()))
				{
					$query = $this->Carts->query();
							$query->insert(['customer_id','item_variation_id', 'item_id', 'quantity', 'cart_count', 'is_combo'])
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
						//$update_quantity=$item_add_quantity+$exist_quantity;
						$update_quantity=$item_add_quantity;
						$update_count=$exist_count+1;					
					
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
			//$item_add_quantity=$items->minimum_quantity_factor;
			$item_add_quantity=1;
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
				//$update_quantity=$exist_quantity-$item_add_quantity;
				$update_quantity=$item_add_quantity;
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
		->contain(['ItemVariations' =>['Units','Items']])
		->autoFields(true);
				
		if(!empty($carts->toArray()))
		{
			foreach($carts as $cart_data)
			{
				$cart_data->item = $cart_data->item_variation->item;
				unset($cart_data->item_variation->item);
				$cart_data->item->item_variations  = [$cart_data->item_variation];
				unset($cart_data->item_variation);
			}
			
			$grand_total1=0;
			
			
			//pr($carts->toArray());exit;
			
			foreach($carts as $cart_data)
			{
				$cart_data->item->image = 'http://healthymaster.in'.$this->request->webroot.'img/item_images/'.$cart_data->item->image;			
				
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
			//echo $grand_total;exit;
			$subtotal = 0.00;
			
			$subtotal = $grand_total;
			
			$discount_amount = 0.00;
			$isPromoApplied = false;
			$isFreeShipping = 'No';	
			if(!empty($promocode))
			{
				$ts = Time::now('Asia/Kolkata');
				$current_timestamp = date('Y-m-d H:i:s',strtotime($ts));
				$this->loadModel('PromoCodes');
				$promoCodeLists = $this->PromoCodes->find()->where(['PromoCodes.valid_from <' =>$current_timestamp, 'PromoCodes.valid_to >' =>$current_timestamp,'PromoCodes.code'=>$promocode])->first();	
				$cat_item_total = 0.00;
				
				
				if(!empty($promoCodeLists))
				{
					foreach($carts as $cart_data)
					{
						if($promoCodeLists->promo_code_type == 'Item Wise')
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

						else if($promoCodeLists->promo_code_type == 'Category Wise')
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
					
					
					
					if($promoCodeLists->promo_code_type == 'Free Shipping')
					{
						if($promoCodeLists->is_freeship == 1)
						{
							if($grand_total >= $promoCodeLists->cart_value)
							{
								$isFreeShipping = 'Yes';
							}
						}
					}

					if($promoCodeLists->promo_code_type == 'On Cart Value')
					{
						if($grand_total >= $promoCodeLists->cart_value)
						{
							if($promoCodeLists->amount_type == 'percent')
							{
								$discount_amount =  $grand_total * $promoCodeLists->discount_per / 100;
							}
							else if($promoCodeLists->amount_type == 'amount' && $grand_total > $promoCodeLists->discount_per)
							{
								$discount_amount =  $grand_total - $promoCodeLists->discount_per;
							}					
						}				
					}	
					
					if($discount_amount > 0)
					{
						$discount_amount = round($discount_amount);
						$grand_total = $grand_total - $discount_amount;
						$isPromoApplied = true;
					}		
				}
			}

			
			$delivery_charges = '0';
			$this->loadModel('DeliveryCharges');
			$delivery_charges=$this->DeliveryCharges->find()->where(['pincode' => $pincode])->order(['id' =>'DESC'])->first();
			
			if($isFreeShipping == 'Yes')
			{
				$delivery_charges = 'Free';
				$isPromoApplied = true;
			}
			
			else if(!empty($delivery_charges) && $grand_total < $delivery_charges->amount)
			{
				$grand_total = $grand_total + $delivery_charges->charge;
				$delivery_charges = $delivery_charges->charge;
				$delivery_charges = round($delivery_charges);
			}
			else
			{
				$delivery_charges = 'Free';
			}
			
			$subtotal = round($subtotal);
			$grand_total = round($grand_total);			
		}


		$this->loadModel('JainCashPoints');

		$queryPoints = $this->JainCashPoints->find();
		$totalInCase = $queryPoints->newExpr()
			->addCase(
				$queryPoints->newExpr()->add(['is_refered' => 'Yes']),
				$queryPoints->newExpr()->add(['point']),
				'integer'
			);
		$totalOutCase = $queryPoints->newExpr()
			->addCase(
				$queryPoints->newExpr()->add(['order_id !=' => '0']),
				$queryPoints->newExpr()->add(['used_point']),
				'integer'
			);
			$queryPoints->select([
			'total_in' => $queryPoints->func()->sum($totalInCase),
			'total_out' => $queryPoints->func()->sum($totalOutCase),'id','customer_id'
		])
		->where(['JainCashPoints.customer_id' => $customer_id])
		->group('customer_id')
		->autoFields(true);

		$totalPoints = 0;

		if(!empty($queryPoints->toArray()))
		{
			foreach($queryPoints as $fetch_query)
			{
				$points=$fetch_query->total_in;
				$used_points=$fetch_query->total_out;
				$totalPoints=$points-$used_points;
			}			
		}
		$remaningPoints = $totalPoints;
		if($totalPoints > 0 && !empty($redeem_points) && $totalPoints >= $redeem_points && $grand_total >= $redeem_points)
		{
			$remaningPoints = $totalPoints - $redeem_points;
			$grand_total = $grand_total - $redeem_points;
			$isPointsRedeem = true;
		}else
		{
			$isPointsRedeem = false;
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
			$error='Cart data found successfully';
			$this->set(compact('status', 'error','address_available','grand_total','carts','delivery_charges','subtotal','discount_amount','isPromoApplied','totalPoints','remaningPoints','redeem_points','isPointsRedeem'));
			$this->set('_serialize', ['status', 'error','isPointsRedeem','totalPoints','redeem_points','remaningPoints','subtotal','delivery_charges','discount_amount','isPromoApplied','grand_total','address_available','carts']);
		}
	}
	
	public function reviewOrder()
    {
		$customer_id=$this->request->query('customer_id');
		$promocode=$this->request->query('promocode');
		$redeem_points=$this->request->query('redeem_points');
		$pincode=$this->request->query('pincode');
		$isPointsRedeem = false;
/* 		$carts=$this->Carts->find()
			->where(['customer_id' => $customer_id])
			->contain(['Items' => ['ItemVariations' =>['Units']]])
			->autoFields(true);
			
			if($carts==null)
			{
				$carts=[];
			}
			else{
				$carts=$carts;
			}	 */	
		$carts=$this->Carts->find()
		->where(['customer_id' => $customer_id])
		->contain(['ItemVariations' =>['Units','Items']])
		->autoFields(true);
		
	if(!empty($carts->toArray()))	
	{
		foreach($carts as $cart_data)
		{
			$cart_data->item = $cart_data->item_variation->item;
			unset($cart_data->item_variation->item);
			$cart_data->item->item_variations  = [$cart_data->item_variation];
			unset($cart_data->item_variation);
		}
		
		$totalItems = 0;
		
		$grand_total1=0;
		foreach($carts as $cart_data)
		{ $totalItems = $totalItems + 1;
		
			$cart_data->item->image = 'http://healthymaster.in'.$this->request->webroot.'img/item_images/'.$cart_data->item->image;	
		
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
		
		$discount_amount = 0.00;
		$isPromoApplied = false;
		$isFreeShipping = 'No';	
		if(!empty($promocode))
		{
			$ts = Time::now('Asia/Kolkata');
			$current_timestamp = date('Y-m-d H:i:s',strtotime($ts));
			$this->loadModel('PromoCodes');
			$promoCodeLists = $this->PromoCodes->find()->where(['PromoCodes.valid_from <' =>$current_timestamp, 'PromoCodes.valid_to >' =>$current_timestamp,'PromoCodes.code'=>$promocode])->first();	
			$cat_item_total = 0.00;
				
			
			if(!empty($promoCodeLists))
			{
				foreach($carts as $cart_data)
				{
					//echo $cart_data->item->id;
					if($promoCodeLists->promo_code_type == 'Item Wise')
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

					else if($promoCodeLists->promo_code_type == 'Category Wise')
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
				
				
				
				if($promoCodeLists->promo_code_type == 'Free Shipping')
				{
					if($promoCodeLists->is_freeship == 1)
					{
						if($grand_total >= $promoCodeLists->cart_value)
						{
							$isFreeShipping = 'Yes';
						}
					}
				}

				if($promoCodeLists->promo_code_type == 'On Cart Value')
				{
					if($grand_total >= $promoCodeLists->cart_value)
					{
						if($promoCodeLists->amount_type == 'percent')
						{
							$discount_amount =  $grand_total * $promoCodeLists->discount_per / 100;
						}
						else if($promoCodeLists->amount_type == 'amount' && $grand_total > $promoCodeLists->discount_per)
						{
							$discount_amount =  $grand_total - $promoCodeLists->discount_per;
						}					
					}				
				}	
				
				if($discount_amount > 0)
				{
					$discount_amount = round($discount_amount);
					$grand_total = $grand_total - $discount_amount;
					$isPromoApplied = true;
				}		
			}
		}


		$delivery_charges = '0';
		$this->loadModel('DeliveryCharges');
		$delivery_charges=$this->DeliveryCharges->find()->where(['pincode' => $pincode])->order(['id' =>'DESC'])->first();
		
		if($isFreeShipping == 'Yes')
		{
			$delivery_charges = 'Free';
			$isPromoApplied = true;
		}
		else if(!empty($delivery_charges) && $grand_total < $delivery_charges->amount)
		{
			
			$grand_total = $grand_total + $delivery_charges->charge;
			$delivery_charges = $delivery_charges->charge;
			$delivery_charges = round($delivery_charges);
		}
		else
		{
			$delivery_charges = 'Free';
		}

		$subtotal = round($subtotal);
		$grand_total = round($grand_total);
	}
		$this->loadModel('CustomerAddresses');
		$customer_addresses=$this->CustomerAddresses->find()
		->where(['customer_id' => $customer_id,'default_address' => 1])
		->contain(['States','Cities'])
		->order(['default_address' => 'DESC']);

		if(empty($customer_addresses->toArray())) { $customer_addresses = []; }	
		$temp_order_no=uniqid();
		
		$this->loadModel('JainCashPoints');

		$queryPoints = $this->JainCashPoints->find();
		$totalInCase = $queryPoints->newExpr()
			->addCase(
				$queryPoints->newExpr()->add(['is_refered' => 'Yes']),
				$queryPoints->newExpr()->add(['point']),
				'integer'
			);
		$totalOutCase = $queryPoints->newExpr()
			->addCase(
				$queryPoints->newExpr()->add(['order_id !=' => '0']),
				$queryPoints->newExpr()->add(['used_point']),
				'integer'
			);
			$queryPoints->select([
			'total_in' => $queryPoints->func()->sum($totalInCase),
			'total_out' => $queryPoints->func()->sum($totalOutCase),'id','customer_id'
		])
		->where(['JainCashPoints.customer_id' => $customer_id])
		->group('customer_id')
		->autoFields(true);

		$totalPoints = 0;

		if(!empty($queryPoints->toArray()))
		{
			foreach($queryPoints as $fetch_query)
			{
				$points=$fetch_query->total_in;
				$used_points=$fetch_query->total_out;
				$totalPoints=$points-$used_points;
			}			
		}		

		$remaningPoints = $totalPoints;
		if($totalPoints > 0 && !empty($redeem_points) && $totalPoints >= $redeem_points && $grand_total >= $redeem_points)
		{
			$remaningPoints = $totalPoints - $redeem_points;
			$grand_total = $grand_total - $redeem_points;
			$isPointsRedeem = true;
		}		
		else{
			$isPointsRedeem = false;
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
			$error='Cart reviewed successfully';
			$this->set(compact('status', 'error','totalPoints','temp_order_no','grand_total','totalItems','carts','delivery_charges','subtotal','discount_amount','isPromoApplied','customer_addresses','remaningPoints','redeem_points','isPointsRedeem'));
			$this->set('_serialize', ['status', 'error','temp_order_no','isPointsRedeem','totalPoints','redeem_points','remaningPoints','subtotal','delivery_charges','discount_amount','isPromoApplied','grand_total','totalItems','carts','customer_addresses']);
		}
    }

}
