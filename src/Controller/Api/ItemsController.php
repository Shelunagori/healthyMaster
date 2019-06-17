<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
class ItemsController extends AppController
{
	public function getItem()
	{
		$item=$this->Items->find('all',['limit'=>10]);
		$status=true;
		$message="oK";
		$this->set(compact('status', 'message', 'item'));
		$this->set('_serialize', ['status', 'message', 'item']);
	}
    public function item()
    {
		$isViewAll=$this->request->query('isViewAll');
		
		if($isViewAll == 'true')
		{
			$this->viewAll();
		}else
		{
			$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
			$item_category_id=$this->request->query('item_category_id');
			$item_sub_category_id=$this->request->query('item_sub_category_id');
			$customer_id=$this->request->query('customer_id');
			$page=@$this->request->query('page');
			$limit = 10;
			
			$categoryImage_nw = $this->Items->ItemCategories->find()->where(['is_deleted'=>0,'id' => $item_category_id])->first();			
			
			$categoryImage = 'http://healthymaster.in'.$this->request->webroot.'itemcategories/'.$categoryImage_nw->image;
			
			if($item_sub_category_id=='0')
			{
				$where=['Items.item_category_id'=>$item_category_id, 'Items.is_combo'=>'no', 'Items.freeze'=>0, 'Items.ready_to_sale'=>'Yes'];
			}
			else
			{
				$where=['Items.item_category_id'=>$item_category_id, 'Items.item_sub_category_id'=>$item_sub_category_id, 'Items.is_combo'=>'no', 'Items.freeze'=>0, 'Items.ready_to_sale'=>'Yes'];
			}
			$items = $this->Items->find()
						->where($where)
						->order(['name'=>'ASC'])
						->contain(['ItemVariations'=>
							function($q) use($customer_id) {
								return $q->where(['ready_to_sale' =>'Yes'])
								->contain(['Units','Carts'=>
									function($q) use($customer_id){
										return $q->where(['customer_id'=>$customer_id]);
								}]);
							}
						])->limit($limit)->page($page);
						$items->select(['image_url' => $items->func()->concat(['http://healthymaster.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])])
						->autoFields(true);
						
					//pr($items->toArray());	exit;
						
				
			/*  foreach($items as $item){
				if(!$item->cart){
					$item->cart=(object)[];
				}
			}  */
					
			$cart_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			
			if(!empty($items->toArray()))
			{
				$status=true;
				$error="Item list found successfully";				
			}else
			{
				$status=false;
				$error="No data found";				
			}
			

			$this->set(compact('status', 'error', 'items','categoryImage','cart_count'));
			$this->set('_serialize', ['status', 'error','cart_count','categoryImage','items']);			
		}
    }

	 public function itemdescription()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$item_id=$this->request->query('item_id');
		$customer_id=$this->request->query('customer_id');
		$item_description = $this->Items->find()
							->select(['image_url' => $this->Items->find()->func()->concat(['http://healthymaster.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])])
							->where(['Items.id'=>$item_id,'Items.freeze'=>0, 'Items.ready_to_sale'=>'Yes'])
							->contain(['ItemVariations'=>
								function($q) use($customer_id) {
									return $q->where(['ready_to_sale' =>'Yes'])
									->contain(['Units','Wishlists' =>
										function($q) use($customer_id)
										{	
											return $q->where(['Wishlists.customer_id'=>$customer_id]);
										},'Carts' => 
										function($q) use($customer_id)
										{
											return $q->where(['Carts.customer_id'=>$customer_id]);
										}
									]);
								}])
							->autoFields(true)->first();
				
				if(!empty($item_description->toArray()))
				{
					foreach($item_description->item_variations as $item_variation)
					{
						if(!empty($item_variation->wishlist))
						{
							$item_variation->isInWishlist = true;
						}else
						{
							$item_variation->isInWishlist = false;							
						}
					}
				}
				
				
				$querys=$this->Items->ItemLedgers->find();
				$customer_also_bought=$querys
						->select(['total_rows' => $querys->func()->count('ItemLedgers.id'),'item_id',])
						->where(['inventory_transfer'=>'no','status'=>'out'])
						->group(['ItemLedgers.item_id'])
						->order(['total_rows'=>'DESC'])
						->limit(5)
						->contain(['Items'=>function($q)use($customer_id){
								return $q->select(['name', 'image','alias_name','ready_to_sale'])
						->contain(['ItemVariations' => 
								function($q) use($customer_id){
									return $q->where(['ready_to_sale' =>'Yes'])
									->contain(['Units'=>
									function($q){
										return $q->select(['id','longname','shortname','is_deleted','jain_thela_admin_id']); 
									},'Carts' => 
										function($q) use($customer_id)
										{
											return $q->where(['customer_id'=>$customer_id]);
										}]);
								}
							])->autoFields(true);
						}]);
						$customer_also_bought->select(['image_url' => $customer_also_bought->func()->concat(['http://healthymaster.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])]);
		
						$cart_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
			 
		$status=true;
		$error="Item Description found successfully";
        $this->set(compact('status', 'error', 'item_description', 'customer_also_bought','cart_count'));
        $this->set('_serialize', ['status', 'error', 'item_description', 'customer_also_bought','cart_count']);
    }
	
	public function viewAll()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$type=$this->request->query('type');
		$customer_id=$this->request->query('customer_id');

		if($type=='Popular Items')
		{
			$categoryImage = 'http://healthymaster.in'.$this->request->webroot.'item_list_category_image/popularitem.png';
			
			$query=$this->Items->ItemLedgers->find();
		    $view_items=$query
						->where(['inventory_transfer'=>'no','status'=>'out'])
						->group(['ItemLedgers.item_id'])
						->contain(['Items'=>function($q) use($customer_id){
							return $q->select(['name', 'image','ready_to_sale'])
								->contain(['ItemVariations' => 
									function($q) use($customer_id) {
										return $q->where(['ready_to_sale' => 'Yes'])
										->contain(['Units'=>
											function($q)
											{
												return $q->select(['id','longname','shortname','is_deleted','jain_thela_admin_id']);
											},'Carts'=>function($q) use($customer_id)
											{
												return $q->select(['cart_count'])
												->where(['customer_id'=>$customer_id]);
											}
										]);
									},
									
								])->autoFields(true);
							}]);
						
		}
		else if($type=='recently')
		{
			$categoryImage = 'http://healthymaster.in'.$this->request->webroot.'item_list_category_image/recently.png';
				$querys=$this->Items->ItemLedgers->find();
				$view_items=$querys
						->where(['inventory_transfer'=>'no','status'=>'out'])
						->group(['ItemLedgers.item_id'])
						->contain(['Items'=>function($q) use($customer_id){
							return $q->select(['name', 'image','ready_to_sale'])
							->contain(['ItemVariations' => 
									function($q) use($customer_id){
										return $q->where(['ready_to_sale' => 'Yes'])
										->contain(['Units'=>
											function($q)
											{
												return $q->select(['id','longname','shortname','is_deleted','jain_thela_admin_id']);
											},'Carts'=>function($q) use($customer_id)
											{
												return $q->select(['cart_count'])
												->where(['customer_id'=>$customer_id]);
											}
										]);
									},
									
								])->autoFields(true);
						}]);
						
		

		}
		else if($type='Top Selling Product')
		{
			$categoryImage = 'http://healthymaster.in'.$this->request->webroot.'item_list_category_image/topselling.png';
        $querys=$this->Items->ItemLedgers->find();
				$view_items=$querys
						->where(['inventory_transfer'=>'no','status'=>'out'])
						->group(['ItemLedgers.item_id'])
						->contain(['Items'=>function($q) use($customer_id){
						return $q->select(['name', 'image','ready_to_sale'])
						->contain(['ItemVariations' => 
									function($q) use($customer_id) {
										return $q->where(['ready_to_sale' => 'Yes'])
										->contain(['Units'=>
											function($q)
											{
												return $q->select(['id','longname','shortname','is_deleted','jain_thela_admin_id']);
											},'Carts'=>function($q) use($customer_id)
											{
												return $q->select(['cart_count'])
												->where(['customer_id'=>$customer_id]);
											}
										]);
									},
									
								])->autoFields(true);
						}]);
						
		}
        
		$cart_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();
		
		$items = array();
		if(!empty($view_items->toArray()))
		{
			foreach($view_items as $view_item)
			{
				$view_item->item->image_url = 'http://healthymaster.in'.$this->request->webroot.'img/item_images/'.$view_item->item->image;
				$items [] =	$view_item->item;
			}
			$status=true;
			$error="List found successfully";			
		}else
		{
			$status=false;
			$error="No data found";				
		}			
		
		
		$this->set(compact('status', 'error','cart_count','categoryImage','items'));
        $this->set('_serialize', ['status', 'error','cart_count','categoryImage','items']);
    }
	
	public function searchItem()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$item_query=$this->request->query('item_query');
		$customer_id=$this->request->query('customer_id');
		$search_items = [];
        $search_items_data = $this->Items->find()
		->where(['Items.is_combo'=>'no','Items.name LIKE' => '%'.$item_query.'%', 'Items.freeze'=>0, 'Items.ready_to_sale'=>'Yes'])->contain(['ItemCategories']);
		
		if(!empty($search_items_data->toArray()))
		{
			foreach($search_items_data as $search_item){
				$search_items[] = ['item_id' =>$search_item->id,'name' => $search_item->name,'category_id' =>$search_item->item_category_id,'category_name' => $search_item->item_category->name,'image' => 'http://healthymaster.in'.$this->request->webroot.'img/item_images/'.$search_item->image];	
			}
			$status=true;
			$error="Data found successfully";			
		}else
		{
			$status=false;
			$error="No data found";			
		}
		
		
		$cart_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();

        $this->set(compact('status', 'error', 'cart_count', 'search_items'));
        $this->set('_serialize', ['status', 'error', 'cart_count', 'search_items']);
     }
	 
	public function searchResult()
	{
		$item_name=$this->request->query('item_name');
		$customer_id=$this->request->query('customer_id');	
		$category_id=$this->request->query('category_id');
        $where = '';
        if(!empty($category_id))
        { $where = ['item_category_id' => $category_id]; }
	
		if(!empty($item_name))
		{

			$searchResult = $this->Items->find()
			->where(['Items.is_combo'=>'no', 'Items.name LIKE' =>$item_name, 'Items.freeze'=>0, 'Items.ready_to_sale'=>'Yes'])
			->order(['name'=>'ASC'])
					->contain(['ItemVariations'=>
						function($q) use($customer_id) {
							return $q->where(['ready_to_sale' =>'Yes'])
							->contain(['Units','Carts'=>
								function($q) use($customer_id){
									return $q->where(['customer_id'=>$customer_id]);
							}]);
						}
					])
			->where($where);
			if(empty($searchResult->toArray()))
			{
				$searchResult = $this->Items->find()
				->where(['Items.is_combo'=>'no', 'Items.name LIKE' => '%'.$item_name.'%', 'Items.freeze'=>0, 'Items.ready_to_sale'=>'Yes'])
				->order(['name'=>'ASC'])
					->contain(['ItemVariations'=>
						function($q) use($customer_id) {
							return $q->where(['ready_to_sale' =>'Yes'])
							->contain(['Units','Carts'=>
								function($q) use($customer_id){
									return $q->where(['customer_id'=>$customer_id]);
							}]);
						}
					])
				->where($where);				
			}
			
			if(!empty($searchResult->toArray()))
			{
				foreach($searchResult as $search)
				{
					$search->image_url='http://healthymaster.in'.$this->request->webroot.'img/item_images/'.$search->image;
				}				
			}
			
			$totalItems = sizeof($searchResult);
			$status=true;
			$error="Data found successfully";			
		}else
		{
			$totalItems = 0;
			$status=false;
			$error="Item Name Empty";				
		}


		$cart_count = $this->Items->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();

        $this->set(compact('status', 'error', 'cart_count', 'totalItems','searchResult'));
        $this->set('_serialize', ['status', 'error', 'cart_count','totalItems' ,'searchResult']);
		
	}	
	
	 
	 
	public function fetchItem()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
			$where=['Items.jain_thela_admin_id'=>$jain_thela_admin_id, 'Items.is_combo'=>'no', 'Items.freeze'=>0,'Items.is_virtual'=>'no'];
		$fetch_items = $this->Items->find()
					->where($where)
					->order(['name'=>'ASC'])
					->contain(['Units']);
					$fetch_items->select(['image_url' => $fetch_items->func()->concat(['http://healthymaster.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])])
                    ->autoFields(true);
		
		
		$status=true;
		$error="";
        $this->set(compact('status', 'error', 'fetch_items'));
        $this->set('_serialize', ['status', 'error', 'fetch_items']);
    }


	public function wishListItem()
	{
		$customer_id=$this->request->query('customer_id');	
		$this->loadModel('Wishlists');		
		$wishlist = $this->Wishlists->find()
		->contain(['Items' =>['ItemVariations' =>['Units']]])
		->where(['customer_id' => $customer_id]);
		
		if(!empty($wishlist->toArray()))
		{
			foreach($wishlist as $wishListItem)
			{
				$wishListItem->item->image = 'http://healthymaster.in'.$this->request->webroot.'img/item_images/'.$wishListItem->item->image;
			}
			
			$totalItem = sizeof($wishlist->toArray());
			$status=true;
			$error="Wish list found successfully";			
		}else
		{
			$totalItem = 0;
			$status=false;
			$error="No data found";				
		}
        $this->set(compact('status', 'error','totalItem', 'wishlist'));
        $this->set('_serialize', ['status', 'error','totalItem', 'wishlist']);
	}
}