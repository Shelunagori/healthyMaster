<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[] paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($status = Null)
    {
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
        $items = $this->Items->find()->contain(['ItemCategories']);

        //pr($items->toArray());exit;
		if($status==''){ $status='unfreeze'; }
        if($status=='freeze')
		{
        $items = $this->Items->find()->where(['Items.freeze'=>1])->contain(['ItemCategories','ItemVariations']);
		}
		elseif($status=='unfreeze')
		{
			$where = $status;
			$items = $this->Items->find()->where(['Items.freeze'=>0])->contain(['ItemCategories','ItemVariations']);
		}
		
		
		
        $this->set(compact('items', 'status'));
        $this->set('_serialize', ['items', 'status']);
    }

	public function defineSaleRate()
    {
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$items = $this->Items->newEntity();
		
		if ($this->request->is(['post', 'put'])) {
			$items=$this->request->getData('items');
			
			foreach($items as $item){
				$item=(object)$item;
				$query = $this->Items->query();
                    //$query->update(['promote_date', 'due_amount', amount', 'discount', 'end_date'])
                    $query->update()
                            ->set([
                            'print_rate' => $item->print_rate,
                            'ready_to_sale' => $item->ready_to_sale,
                            'discount_per' => $item->discount_per,
                            'sales_rate' => $item->sales_rate,
                            'offline_sales_rate' => $item->offline_sales_rate
                            ])
                            ->where(['id'=>$item->item_id])
                    ->execute();
			}
			$this->Flash->success(__('Item rates have updated successfully.'));
		 }
		$items = $this->Items->find()->where(['Items.freeze'=>0])
        //->group(['ItemVariations.quantity_variation'])
        ->contain(['ItemCategories','ItemVariations']);
		//pr($items->toArray());exit;
		$this->set(compact('items', 'itemCategories', 'units'));
        $this->set('_serialize', ['items']);
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Items->get($id, [
            'contain' => ['ItemCategories', 'Units']
        ]);

        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
        $item = $this->Items->newEntity();
        if ($this->request->is('post')) {
			
        	$data=$this->request->getData();
            //pr($data);
			$item = $this->Items->patchEntity($item,$data,['associated'=>['ItemVariations']]);
            //pr($item->toArray());exit;

			$file = $this->request->data['image'];
            //pr($file);
			$file_name=$file['name'];		
            //pr($file_name);exit;	
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = uniqid();
            $img_name= $setNewFileName.'.'.$ext;
			if(!empty($file_name)){
				$item->image=$img_name;
			}if(empty($file_name)){
				
			}
			//pr($item);exit;
			if ($this->Items->save($item)) {
				//pr($item);exit;
                $this->Flash->success(__('The item has been saved.'));
				  if (in_array($ext, $arr_ext)) {
                         $destination_url = WWW_ROOT . 'img/temp/'.$img_name;
                        if($ext=='png'){
                        $image = imagecreatefrompng($file['tmp_name']);
                        }else{
                        $image = imagecreatefromjpeg($file['tmp_name']);
                        }
                        imagejpeg($image, $destination_url, 10);
                        $keyname1 = 'item_images/'.$img_name;
                        $this->AwsFile->putObjectFile($keyname1,$destination_url,$file['type']);
            
                    //move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/item_images/'.$img_name);
                  }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
		
        $itemCategories = $this->Items->ItemCategories->find('list')->where(['is_deleted'=>0,'jain_thela_admin_id'=>$jain_thela_admin_id]);
        $units = $this->Items->ItemVariations->Units->find()->where(['is_deleted'=>0]);
        $item_fetchs = $this->Items->find('list')->where(['freeze'=>0]);
		foreach($units as $unit_data){
			$unit_name=$unit_data->unit_name;
			$unit_option[]= ['value'=>$unit_data->id,'text'=>$unit_data->shortname,'unit_name'=>$unit_name];
		}
        $this->set(compact('item', 'itemCategories', 'units', 'unit_option', 'item_fetchs'));
        $this->set('_serialize', ['item']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
<<<<<<< HEAD
        $item = $this->Items->get($id,  [
            'contain' => ['ItemVariations']]
        );
=======
        $item = $this->Items->get($id);
>>>>>>> b8f8edbeb3246e856a6bf1ab0d2440e9eecc57ff
		$old_image_name=$item->image;
        if ($this->request->is(['patch', 'post', 'put'])) {
			
			$file = $this->request->data['image'];	
			$file_name=$file['name'];
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = uniqid();	
			$img_name= $setNewFileName.'.'.$ext;
			if(!empty($file_name)){
			$this->request->data['image']=$img_name;
			}if(empty($file_name)){
				$this->request->data['image']=$old_image_name;
			}
			// $unit_id=$this->request->data['unit_id'];
			// $units_fetch_datas = $this->Items->ItemVariations->Units->find()->where(['id'=>$unit_id]);
			// foreach($units_fetch_datas as $units_fetch_data){
			// 	$unit_shortname=$units_fetch_data->shortname;
			// 	$unit_name=$units_fetch_data->unit_name;	
			// }
<<<<<<< HEAD

            ///pr($this->request->getData());
            $items = $this->Items->get($id,  [
            'contain' => ['ItemVariations']]
        );
            $item = $this->Items->patchEntity($items, $this->request->getData());
            //pr($item->toArray());exit;
=======
            $item = $this->Items->patchEntity($item, $this->request->getData());
>>>>>>> b8f8edbeb3246e856a6bf1ab0d2440e9eecc57ff
            $item->jain_thela_admin_id=$jain_thela_admin_id;
			// if($unit_name=='kg'){
			// 	$minimum_quantity_factor=$this->request->data['minimum_quantity_factor'];
			// 	if($minimum_quantity_factor==0.10){	
			// 		$item->print_quantity='100 gm';
			// 		$item->minimum_quantity_factor=$minimum_quantity_factor;	
			// 	}
			// 	if($minimum_quantity_factor==0.25){	
			// 		$item->print_quantity='250 gm';
			// 		$item->minimum_quantity_factor=$minimum_quantity_factor;	
			// 	}
			// 	if($minimum_quantity_factor==0.50){	
			// 		$item->print_quantity='500 gm';
			// 		$item->minimum_quantity_factor=$minimum_quantity_factor;	
			// 	}
			// 	if($minimum_quantity_factor==1){
			// 		$item->print_quantity='1 '.$unit_shortname;
			// 		$item->minimum_quantity_factor=$minimum_quantity_factor;
			// 	}
			// }else{		
			// 		$item->print_quantity='1 '.$unit_shortname;
			// 		$item->minimum_quantity_factor=1;
			// }
			if ($this->Items->save($item)) {
				if(!empty($file_name)){
					if (in_array($ext, $arr_ext)) {
                         $destination_url = WWW_ROOT . 'img/temp/'.$img_name;
                        if($ext=='png'){
                        $image = imagecreatefrompng($file['tmp_name']);
                        }else{
                        $image = imagecreatefromjpeg($file['tmp_name']);
                        }
                        imagejpeg($image, $destination_url, 10);
                        $keyname1 = 'item_images/'.$img_name;
                        $this->AwsFile->putObjectFile($keyname1,$destination_url,$file['type']);
            
                    //move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/item_images/'.$img_name);
                  }   
				}
                $this->Flash->success(__('The item has been saved.'));	
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
		$itemCategories = $this->Items->ItemCategories->find('list', ['limit' => 200]);
<<<<<<< HEAD
		$units = $this->Items->ItemVariations->Units->find('list')->where(['is_deleted'=>0]);
		$item_fetchs = $this->Items->find('list')->where(['is_virtual'=> 'no','freeze'=>0]);
		// foreach($units as $unit_data){
		// 	$unit_name=$unit_data->unit_name;
		// 	$unit_option[]= ['value'=>$unit_data->id,'text'=>$unit_data->shortname,'unit_name'=>$unit_name];
		// }
        $variations = $this->Items->ItemVariations->find()->where(['item_id'=>$id])->contain(['Units','Items']);
        $this->set(compact('item', 'itemCategories', 'units','item_fetchs','variations'));
=======
		$units = $this->Items->ItemVariations->Units->find()->where(['is_deleted'=>0]);
		$item_fetchs = $this->Items->find('list')->where(['is_virtual'=> 'no','freeze'=>0]);
		foreach($units as $unit_data){
			$unit_name=$unit_data->unit_name;
			$unit_option[]= ['value'=>$unit_data->id,'text'=>$unit_data->shortname,'unit_name'=>$unit_name];
		}
        $variations = $this->Items->ItemVariations->find()->where(['item_id'=>$id])->contain(['Units','Items']);
        $this->set(compact('item', 'itemCategories', 'units', 'unit_option', 'item_fetchs','variations'));
>>>>>>> b8f8edbeb3246e856a6bf1ab0d2440e9eecc57ff
        $this->set('_serialize', ['item']);
    }

    /**
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     *fsf
     *  ete method
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
		$item->freeze=1;
        if ($this->Items->save($item)) {
            $this->Flash->success(__('The item has been freezed.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
