<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
use Cake\Event\Event;
class ItemCategoriesController extends AppController
{
	public function home()
    {
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$customer_id=$this->request->query('customer_id');
	    $itemCategories = $this->ItemCategories->find('All')->where(['is_deleted'=>0]);
		$itemCategories->select(['image_url' => $itemCategories->func()->concat(['http://app.jainthela.in'.$this->request->webroot.'itemcategories/','image' => 'identifier' ])])
                                ->autoFields(true);
		
	    $banners = $this->ItemCategories->Banners->find('All')->where(['link_name'=>'offer', 'Banners.status'=>'Active']);
		$banners->select(['image_url' => $banners->func()->concat(['http://app.jainthela.in'.$this->request->webroot.'banners/','image' => 'identifier' ])])->autoFields(true);
		
		$query=$this->ItemCategories->Items->ItemLedgers->find();
		$popular_items=$query
						->select(['total_rows' => $query->func()->count('ItemLedgers.id'),'item_id'])
						->where(['inventory_transfer'=>'no','status'=>'out'])
						->group(['ItemLedgers.item_id'])
						->order(['total_rows'=>'DESC'])
						->limit(10)
						->contain(['Items'=>function($q) use($customer_id){
							return $q->select(['name', 'image','ready_to_sale'])
							
							->contain(['ItemVariations'=>
								function($q) use($customer_id) {
									return $q->where(['ready_to_sale' =>'Yes'])
									->contain(['Units','Carts'=>
										function($q) use($customer_id){
											return $q->where(['customer_id'=>$customer_id]);
									}]);
								}
							]);
						}]);
						$popular_items->select(['image_url' => $popular_items->func()->concat(['http://app.jainthela.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])]);
					
				//	$popular_items=array();
					
					//$recently_bought=$popular_items;	
					
							
				 $querys=$this->ItemCategories->Items->ItemLedgers->find();
				$recently_bought=$querys
						->select(['total_rows' => $querys->func()->count('ItemLedgers.id'),'item_id'])
						->where(['inventory_transfer'=>'no','status'=>'out'])
						->group(['ItemLedgers.item_id'])
						->order(['total_rows'=>'DESC'])
						->limit(10)
						->contain(['Items'=>function($q) use($customer_id) {
							return $q->select(['name', 'image','ready_to_sale'])
							->contain(['ItemVariations'=>
								function($q) use($customer_id) {
									return $q->where(['ready_to_sale' =>'Yes'])
									->contain(['Units','Carts'=>
										function($q) use($customer_id){
											return $q->where(['customer_id'=>$customer_id]);
									}]);
								}
							]);
						}]);
						$recently_bought->select(['image_url' => $recently_bought->func()->concat(['http://app.jainthela.in'.$this->request->webroot.'img/item_images/','image' => 'identifier' ])]); 
		
						$cart_count = $this->ItemCategories->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();						

		$status=true;
		$error="";
        $this->set(compact('status', 'error', 'itemCategories', 'banners','popular_items','recently_bought', 'cart_count'));
        $this->set('_serialize', ['status', 'error', 'itemCategories', 'banners', 'popular_items','recently_bought','cart_count']);
    }
	
	public function categoryList()
	{
		$customer_id=$this->request->query('customer_id');
	    $categoryList = $this->ItemCategories->find('All')->where(['is_deleted'=>0]);
		$categoryList->select(['image_url' => $categoryList->func()->concat(['http://http://healthymaster.in'.$this->request->webroot.'itemcategories/','image' => 'identifier' ])])->autoFields(true);		
		
		$cart_count = $this->ItemCategories->Carts->find('All')->where(['Carts.customer_id'=>$customer_id])->count();	
		$status=true;
		$error="";
        $this->set(compact('status', 'error', 'categoryList','cart_count'));
        $this->set('_serialize', ['status', 'error', 'categoryList','cart_count']);		
	}
	
	
	
	
	
	
}