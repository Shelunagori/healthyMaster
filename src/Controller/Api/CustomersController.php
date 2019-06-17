<?php

namespace App\Controller\Api;
use App\Controller\Api\AppController;
class CustomersController extends AppController
{
	public function getCustomer()
	{
		$customer = $this->Customers->find();
		//pr($customer->toArray());exit;
		$status = true;
		$message = 'Success';
		$this->set(compact('status', 'message', 'customer'));
		$this->set('_serialize', ['status', 'message', 'customer']);		
	}
	
	
	
    public function registration()
    {
		$error="";
	    $mobile_no=$this->request->query('mobile_no');
	    $otp=$this->request->query('otp');
		$signup=$this->request->query('status');
		$img_name = 'user_profile_pics/'.'user.png';
		
		if(!empty($mobile_no) && empty($otp) && empty($signup))
		{
			
		        $customerDetails = $this->Customers->find()->where(['mobile'=>$mobile_no,'status'=>'completed'])->first();
				if($customerDetails){
				    $id=$customerDetails->id;
					$new_signup='no';
					$random=(string)mt_rand(1000,9999);
					$sms=str_replace(' ', '+', 'Your one time OTP for Jainthela App is: '.$random.'');
					$working_key='A7a76ea72525fc05bbe9963267b48dd96';
					$sms_sender='JAINTE';
					$sms=str_replace(' ', '+', $sms);
					/* file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_no.'&message='.$sms.''); */
					
					file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile_no.'&text='.$sms.'&route=7');
					
					$customerDetails = $this->Customers->get($customerDetails->id);
					$customerDetails->otp=$random;
					$customerDetails->user_img = $img_name;
					$this->Customers->save($customerDetails);
					$status=true;
					$error="Customer registration successfully.";
				}else{
					
					$customerDetails = $this->Customers->find()->where(['mobile'=>$mobile_no,'status'=>'incompleted'])->first();
					if($customerDetails)
					{
						$id=$customerDetails->id;
						$new_signup='no';
						$random=(string)mt_rand(1000,9999);
						$sms=str_replace(' ', '+', 'Your one time OTP for Jainthela App is: '.$random.'');
						$working_key='A7a76ea72525fc05bbe9963267b48dd96';
						$sms_sender='JAINTE';
						$sms=str_replace(' ', '+', $sms);
						/* file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_no.'&message='.$sms.''); */
						
						file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile_no.'&text='.$sms.'&route=7');
						
						$customerDetails = $this->Customers->get($customerDetails->id);
						$customerDetails->otp=$random;
						$customerDetails->user_img = $img_name;
						$this->Customers->save($customerDetails);
						$status=true;	
						$error="Customer registration successfully.";
					}
					else{
							$customer = $this->Customers->newEntity();
							$customer->mobile=$mobile_no;
							$customer->status='incompleted';
							
							$random=(string)mt_rand(1000,9999);
							$customer->otp=$random;
							$sms=str_replace(' ', '+', 'Your one time OTP for Jainthela App is: '.$random.'');
							$working_key='A7a76ea72525fc05bbe9963267b48dd96';
							$sms_sender='JAINTE';
							$sms=str_replace(' ', '+', $sms);
							/* file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_no.'&message='.$sms.''); */
							
							file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile_no.'&text='.$sms.'&route=7');
							$customer->user_img = $img_name;
							if($this->Customers->save($customer)){
								$new_signup='yes';
								$status=true;
								$customerDetails=$this->Customers->get($customer->id);
							}else{
								$status=false;
								$error="Customer registration failed.";
							}
					  }
					
				}
				
				$this->set(compact('status', 'error', 'new_signup', 'customerDetails'));
		        $this->set('_serialize', ['status', 'error', 'new_signup', 'customerDetails']);
		}
		else if(!empty($mobile_no) && !empty($otp) && !empty($signup))
		{
			
			if($signup=='completed')
			{
			$customerDetails = $this->Customers->find()->where(['mobile'=>$mobile_no, 'otp'=>$otp, 'status'=>'completed'])->first();
				if($customerDetails)
				{
					$customerDetails->already_login=true;
					$status=true;
					$new_signup='';
					$error='Successfully Login';
					
					$this->set(compact('status', 'error', 'new_signup', 'customerDetails'));
					$this->set('_serialize', ['status', 'error', 'new_signup', 'customerDetails']);
				}
				else
				{
					$status=false;
					$error="Sorry, you entered Wrong OTP, try again";
					$this->set(compact('status', 'error'));
					$this->set('_serialize', ['status', 'error']);
				}
			}
			else if($signup=='incompleted'){
				
			$customerDetails = $this->Customers->find()->where(['mobile'=>$mobile_no, 'otp'=>$otp, 'status'=>'incompleted'])->first();
				if($customerDetails)
				{
					$today=date('Y-m-d');
					$customerDetails = $this->Customers->get($customerDetails->id);
				    $customerDetails->status='completed';
				    $customerDetails->first_time_win_status='No';
				    $customerDetails->new_scheme='Yes';
				    $customerDetails->created_on=$today;
					$customerDetails->notification_key='AAAA_7MR4qc:APA91bEB4PE2YzC9zlsb3qnMhTn7WzPqJhnHxqjr_--YdowERJkq2hVCCQXAMEQoHvIo22ymzuYGCJLpe1jJUDlgcPo9eCvoF4jGV92i1ldpTrYHSF7jc7QU-W1B5dhTDA1PpD9DENy7';
					$customerDetails->referral_code=$customerDetails->id;
					$customerDetails->user_img = $img_name;
					$this->Customers->save($customerDetails);
					$customerDetails->already_login=false;
					$status=true;
					$new_signup='';
					$error='Successfully Login';
					$this->set(compact('status', 'error', 'new_signup', 'customerDetails'));
					$this->set('_serialize', ['status', 'error', 'new_signup', 'customerDetails']);
				}
				else
				{
					$status=false;
					$error="Sorry, you entered Wrong OTP, try again";
					$this->set(compact('status', 'error'));
					$this->set('_serialize', ['status', 'error']);
				}
			}
			
			
		}
		else
		{
			$status=false;
			$error="Enter Mobile No.";
			$this->set(compact('status', 'error'));
		    $this->set('_serialize', ['status', 'error']);
			
		}
    }
	
	public function profileEdit()
    {
		$customer_id=$this->request->data('customer_id');
		$name=$this->request->data('name');
		$mobile=$this->request->data('mobile');
		$email=$this->request->data('email');
		@$old_image=$this->request->data('old_image');
		$isImageChanged=$this->request->data('isImageChanged');
		
		$user_img=$this->request->data('user_img');
		
		$fetchs=$this->Customers->find()->where(['Customers.id !=' => $customer_id, 'Customers.mobile' =>$mobile])->count();
		if(empty($fetchs)){
			if($isImageChanged == "true")
			{
				$file = $user_img;
				$file_name=$file['name'];
				$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
				$arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
				$setNewFileName = uniqid();
				$image_name= $setNewFileName.'.'.$ext;
				if(!empty($file_name)){
					$img_name = 'user_profile_pics/'.$image_name;
				}else if(empty($file_name)){
					$img_name = 'user_profile_pics/'.'user.png';
				}
				 if (in_array($ext, $arr_ext)) {
						move_uploaded_file($file['tmp_name'], WWW_ROOT .$img_name);
					  }				
			}else 
			{
				
				$img_name = @$old_image;	
			}	
			$query = $this->Customers->query();
				$result = $query->update()
                    ->set([ 'name' => $name,
							'mobile' => $mobile,
							'email' => $email,
							'user_img' => $img_name
							])
					->where(['id' => $customer_id])
					->execute();
		$profiles=$this->Customers->find()->where(['id' => $customer_id])->first();
		
		
		$query = $this->Customers->JainCashPoints->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['order_id' => '0']),
				$query->newExpr()->add(['point']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['order_id' => '0']),
				$query->newExpr()->add(['used_point']),
				'integer'
			);
			$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','customer_id'
		])
		->where(['JainCashPoints.customer_id' => $customer_id])
		->group('customer_id')
		->autoFields(true);
		if(empty($query->toArray()))
		{
			$jain_cash_points=0;
		}
		else
		{
		foreach($query as $fetch_query)
		{
			$points=$fetch_query->total_in;
			$used_points=$fetch_query->total_out;
			$jain_cash_points=$points-$used_points;
		}
		}
		
		
		$queryw = $this->Customers->Wallets->find();
		$totalInCasew = $queryw->newExpr()
			->addCase(
				$queryw->newExpr()->add(['order_id' => '0']),
				$queryw->newExpr()->add(['advance']),
				'integer'
			);
		$totalOutCasew = $queryw->newExpr()
			->addCase(
				$queryw->newExpr()->add(['plan_id' => '0']),
				$queryw->newExpr()->add(['consumed']),
				'integer'
			);
			$queryw->select([
			'total_in' => $queryw->func()->sum($totalInCasew),
			'total_out' => $queryw->func()->sum($totalOutCasew),'id','customer_id'
		])
		->where(['Wallets.customer_id' => $customer_id])
		->group('customer_id')
		->autoFields(true);
		if(empty($queryw->toArray()))
		{
			$wallet_balance=0;
		}
		else
		{
		foreach($queryw as $fetch_query)
		{
			$advance=$fetch_query->total_in;
			$consumed=$fetch_query->total_out;
			$wallet_balance=$advance-$consumed;
		}
		}
		
		$status=true;
		$error="Profile Updated Successfully";
        $this->set(compact('status', 'error','jain_cash_points','wallet_balance','profiles'));
        $this->set('_serialize', ['status', 'error','jain_cash_points','wallet_balance','profiles']);
		}
		else if(!empty($fetchs)){
			$status=false;
			$error="Please Try Another Number";
			$this->set(compact('status', 'error'));
			$this->set('_serialize', ['status', 'error']);
		}
    }
	
	public function MyAccount()
    {
		$customer_id=$this->request->query('customer_id');
		$profiles=$this->Customers->find()->where(['id' => $customer_id])->first();
	    
		$query = $this->Customers->JainCashPoints->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['order_id' => '0']),
				$query->newExpr()->add(['point']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['order_id' => '0']),
				$query->newExpr()->add(['used_point']),
				'integer'
			);
			$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','customer_id'
		])
		->where(['JainCashPoints.customer_id' => $customer_id])
		->group('customer_id')
		->autoFields(true);
		if(empty($query->toArray()))
		{
			$jain_cash_points=0;
		}
		else
		{
		foreach($query as $fetch_query)
		{
			$points=$fetch_query->total_in;
			$used_points=$fetch_query->total_out;
			$jain_cash_points=$points-$used_points;
		}
		}
		
		
		$queryw = $this->Customers->Wallets->find();
		$totalInCasew = $queryw->newExpr()
			->addCase(
				$queryw->newExpr()->add(['order_id' => '0']),
				$queryw->newExpr()->add(['advance']),
				'integer'
			);
		$totalOutCasew = $queryw->newExpr()
			->addCase(
				$queryw->newExpr()->add(['plan_id' => '0']),
				$queryw->newExpr()->add(['consumed']),
				'integer'
			);
			$queryw->select([
			'total_in' => $queryw->func()->sum($totalInCasew),
			'total_out' => $queryw->func()->sum($totalOutCasew),'id','customer_id'
		])
		->where(['Wallets.customer_id' => $customer_id])
		->group('customer_id')
		->autoFields(true);
		if(empty($queryw->toArray()))
		{
			$jain_cash_points=0;
		}
		else
		{
		foreach($queryw as $fetch_query)
		{
			$advance=$fetch_query->total_in;
			$consumed=$fetch_query->total_out;
			$wallet_balance=$advance-$consumed;
		}
		}
		$status=true;
		$error="Data found successfully";
        $this->set(compact('status', 'error','jain_cash_points','wallet_balance','profiles'));
        $this->set('_serialize', ['status', 'error','jain_cash_points','wallet_balance','profiles']);
    }
	public function PushTokenUpdate()
    {
		$customer_id=$this->request->data('customer_id');
		$device_token=$this->request->data('device_token');
		
			$query = $this->Customers->query();
					$result = $query->update()
						->set([ 'device_token' => $device_token
								])
						->where(['id' => $customer_id])
						->execute();
		
		$status=true;
		$error="Token Updated Successfully";
        $this->set(compact('status', 'error'));
        $this->set('_serialize', ['status', 'error']);
    }
	public function customerLocationUpdate()
    {
		$customer_id=$this->request->query('customer_id');
		$lattitude=$this->request->query('lattitude');
		$longitude=$this->request->query('longitude');
		
		$query = $this->Customers->query();
				$result = $query->update()
                    ->set([ 'lattitude' => $lattitude,
					'longitude' => $longitude
							])
					->where(['id' => $customer_id])
					->execute();
		
		$status=true;
		$error="Locations Updated Successfully";
        $this->set(compact('status', 'error'));
        $this->set('_serialize', ['status', 'error']);
    }
	public function customerTracker()
    {
		$customer_id=$this->request->query('customer_id');
		$order_id=$this->request->query('order_id');
		
		$customer_order_data=$this->Customers->Orders->find()
		->where(['id' => $order_id, 'customer_id'=>$customer_id])->first();
         $address_id=$customer_order_data->customer_address_id;
		 $driver_id=$customer_order_data->driver_id;
		 $warehouse_id=$customer_order_data->warehouse_id;
		
		if($warehouse_id>0)
		{
		 $warehouse_data=$this->Customers->Warehouses->find()
		->where(['id'=>$warehouse_id])->first();
         $driver_name=$warehouse_data->name;
		 $driver_mobile=$warehouse_data->mobile;
		 $driver_lattitude=$warehouse_data->lattitude;
		 $driver_longitude=$warehouse_data->longitude;
		}
		else if($driver_id>0){
		 $driver_data=$this->Customers->Drivers->find()
		->where(['id'=>$driver_id])->first();
         $driver_name=$driver_data->name;
		 $driver_mobile=$driver_data->mobile;
		 $driver_lattitude=$driver_data->lattitude;
		 $driver_longitude=$driver_data->longitude;
		 	
		}
		
		 $customer_address_data=$this->Customers->CustomerAddresses->find()
		->where(['id'=>$address_id])->first();
         $fetch_address=$customer_address_data->address;
		 $locality=$customer_address_data->locality;
		 $mobile=$customer_address_data->mobile;
		 $house_no=$customer_address_data->house_no;
		 
				$address=$locality;
				$formattedAddr = str_replace(' ','+',$address);
				$geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
				$output = json_decode($geocodeFromAddr);
				
				@$customer_lattitude=$data['latitude']  = $output->results[0]->geometry->location->lat;
				@$customer_longitude=$data['longitude'] = $output->results[0]->geometry->location->lng;
						
		$status=true;
		$error="Tracking Data";
        $this->set(compact('status', 'error','customer_lattitude','customer_longitude','driver_name','driver_mobile','driver_lattitude','driver_longitude'));
        $this->set('_serialize', ['status', 'error','customer_lattitude','customer_longitude','driver_name','driver_mobile','driver_lattitude','driver_longitude']);
    }
	
}
