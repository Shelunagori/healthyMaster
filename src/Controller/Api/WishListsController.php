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
        $this->loadModel('Wishlists');
		$item_id=$this->request->query('item_id');
		$item_variation_id=$this->request->query('item_variation_id');
		$customer_id=$this->request->query('customer_id');
		$WishExists = $this->WishLists->find()->where(['item_id' => $item_id,'item_variation_id' => $item_variation_id,'customer_id' => $customer_id])->first();
		
		if(!empty($WishExists))
		{
			$id = $WishExists->id;
			$WishListItems = $this->WishLists->get($id);
			$this->WishLists->delete($WishListItems);
			$isAdded = false;
			$success = true;
			$message = 'Removed from wish list';			
		}else
		{

			$query = $this->WishLists->query();
			$query->insert(['customer_id', 'item_id','item_variation_id'])
					->values([
					'customer_id' => $customer_id,
					'item_id' => $item_id,
					'item_variation_id' => $item_variation_id
					])
			->execute();		
			$isAdded = true;			
			$success = true;
			$message = 'Added to wish list';			
		}		
        
		$this->set(['isAdded' =>$isAdded,'success' => $success,'message'=>$message,'_serialize' => ['success','message','isAdded']]);
    }
}
