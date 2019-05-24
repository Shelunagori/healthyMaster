<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;

class WishListsController extends AppController
{
    public function initialize()
     {
         parent::initialize();
     }

    public function addWishList()
    {
		$item_id=$this->request->data('item_id');
		$item_variation_id=$this->request->data('item_variation_id');
		$customer_id=$this->request->data('customer_id');
		
		$WishExists = $this->WishLists->find()->where(['item_id' => $item_id,'item_variation_id' => $item_variation_id,'customer_id' => $customer_id]);
		
		if($WishExists->toArray())
		{
			
		}
		
		pr($WishExists->toArray());
		
		exit;
		
		
          $this->set(['success' => $success,'message'=>$message,'_serialize' => ['success','message']]);
    }

    public function CustomerWishList($customer_id=null)
    {
        $customer_id = @$this->request->query['customer_id'];
        if(!empty($customer_id))
        {
            $wishlist = $this->WishLists->find()
                      ->contain(['WishListItems'=>['ItemVariations'=>['ItemVariationMasters','UnitVariations'=>['Units'],'Items']]])
                      ->where(['customer_id'=>$customer_id]);
            $wishlistCombo = $this->WishLists->find()
                        ->contain(['WishListItems'=>['ComboOffers'=>['ComboOfferDetails']]])
                        ->where(['customer_id'=>$customer_id]);
            if(!empty($wishlist->toArray()) || !empty($wishlistCombo->toArray()))
            {
				
				if(!empty($wishlistCombo))
				{	$total_item = 0;
					foreach($wishlistCombo as $wishListData) { 
						foreach($wishListData->wish_list_items as $wish_list_item){
								$total_item = sizeof($wish_list_item->combo_offer->combo_offer_details);
								$wish_list_item->combo_offer->quantity = $total_item;
								
								// start maximum_quantity_purchase update
								
								$cs = $wish_list_item->item_variation->current_stock;
								$vs = $wish_list_item->item_variation->virtual_stock;
								$ds = $wish_list_item->item_variation->demand_stock;
								$mqp = $wish_list_item->item_variation->maximum_quantity_purchase;
								
								$stock = 0.00;
								
								$stock = $cs + $vs - $ds;
								
								if($stock > $mqp)
								{
								$wish_list_item->item_variation->maximum_quantity_purchase = $mqp;
								}
								else if($mqp > $stock)
								{
									$wish_list_item->item_variation->maximum_quantity_purchase = $stock;
								}
								else {
									$wish_list_item->item_variation->maximum_quantity_purchase = $mqp;
								}
								
								// end maximum_quantity_purchase update								
						}
					}
				}		
				
				
				
              $success = true;
              $message = 'wish list found';
            } else
            {
              $wishlist = [];
              $success = false;
              $message = 'empty wish list';
            }
        }else {
          $wishlist =[];
          $success = false;
          $message = 'customer id empty';
        }
        $this->set(['success' => $success,'message'=>$message,'wishlist'=>$wishlist,'wishlistcombo'=>$wishlistCombo,'_serialize' => ['success','message','wishlist','wishlistcombo']]);
    }
}
