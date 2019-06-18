<?php

namespace App\Controller\Api;
use App\Controller\Api\AppController;

class AppNotificationsController extends AppController
{
    public function NotificationList()
    {
		$list = $this->AppNotifications->find()->order(['created_on'=>'DESC']);
		
		if(!empty($list->toArray()))
		{
			$success = true;
			$message = 'List found successfully';			
		}else{
			$success = false;
			$message = 'No Data Found';			
		}
		
		$this->set(compact('success','message','list'));
		$this->set('_serialize',['success','message','list']);			 
    }
}