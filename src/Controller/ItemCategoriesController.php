<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemCategories Controller
 *
 * @property \App\Model\Table\ItemCategoriesTable $ItemCategories
 *
 * @method \App\Model\Entity\ItemCategory[] paginate($object = null, array $settings = [])
 */
class ItemCategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function topSelling()
    {
        $this->viewBuilder()->layout('index_layout');
       $querys=$this->ItemCategories->Items->ItemLedgers->find();
                $recently_bought=$querys
                        ->select(['total_rows' => $querys->func()->count('ItemLedgers.id'),'item_id'])
                        ->where(['inventory_transfer'=>'no','status'=>'out'])
                        ->group(['ItemLedgers.item_id'])
                        ->order(['total_rows'=>'DESC'])
                        ->limit(10)
                        ->contain(['Items'=>function($q)  {
                            return $q->select(['name', 'image','ready_to_sale','is_new'])
                            ->contain(['ItemVariations'=>
                                function($q)  {
                                    return $q->where(['ready_to_sale' =>'Yes'])
                                    ->contain(['Units','Carts']);
                                }
                            ]);
                        }]);
                        //pr($recently_bought->toArray());exit;
        $this->set(compact('recently_bought'));
    }

   	public function index($id=null)
    {
		$this->viewBuilder()->layout('index_layout');
		$city_id=$this->Auth->User('city_id');
		if(!$id){
			$itemCategory = $this->ItemCategories->newEntity();
		}else{
			$itemCategory = $this->ItemCategories->get($id, [
				'contain' => []
			]);
		}
		
		if ($this->request->is(['patch', 'post', 'put'])) {
            $data=$this->request->getData();
            $data['jain_thela_admin_id']=$this->Auth->user('id');
            //pr($data);exit;

            $itemCategory = $this->ItemCategories->patchEntity($itemCategory, $data);
            $itemCategory->city_id=$city_id;

            $file = $this->request->data['image'];
            //pr($file);exit;
            $file_name=$file['name'];           
            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = uniqid();
            $img_name= $setNewFileName.'.'.$ext;
            if(!empty($file_name)){
                $itemCategory->image=$img_name;
            }if(empty($file_name)){
                
            }
            //pr($item);exit;
            if ($this->ItemCategories->save($itemCategory)) {
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
                        $keyname1 = 'itemcategories/'.$img_name;
                        $this->AwsFile->putObjectFile($keyname1,$destination_url,$file['type']);
            
                    //move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/item_images/'.$img_name);
                  }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Item Category could not be saved. Please, try again.'));
        }
        
        $itemCategories = $this->ItemCategories->find()->where(['is_deleted'=>0])->where(['ItemCategories.city_id'=>$city_id]);

        $this->set(compact('itemCategory', 'itemCategories'));
		$this->set('_serialize', ['itemCategory']);
        $this->set('_serialize', ['itemCategories']);
        
	}

    /**
     * View method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemCategory = $this->ItemCategories->get($id, [
            'contain' => ['Items']
        ]);

        $this->set('itemCategory', $itemCategory);
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemCategory = $this->ItemCategories->newEntity();
        $jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
        if ($this->request->is('post')) {
            $itemCategory = $this->ItemCategories->patchEntity($itemCategory, $this->request->getData());
            $itemCategory->jain_thela_admin_id=$jain_thela_admin_id;
            if ($this->ItemCategories->save($itemCategory)) {
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item category could not be saved. Please, try again.'));
        }
        $this->set(compact('itemCategory'));
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemCategory = $this->ItemCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemCategory = $this->ItemCategories->patchEntity($itemCategory, $this->request->getData());
            if ($this->ItemCategories->save($itemCategory)) {
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item category could not be saved. Please, try again.'));
        }
        $this->set(compact('itemCategory'));
        $this->set('_serialize', ['itemCategory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemCategory = $this->ItemCategories->get($id);
        $itemCategory->is_deleted = 1;
        if ($this->ItemCategories->save($itemCategory)) {
            $this->Flash->success(__('The item category has been deleted.'));
        } else {
            $this->Flash->error(__('The item category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
