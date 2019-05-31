<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Wishlists Controller
 *
 * @property \App\Model\Table\WishlistsTable $Wishlists
 *
 * @method \App\Model\Entity\Wishlist[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WishlistsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function ajaxAutocompleted(){
        $name=$this->request->getData('input'); 
        $searchType=$this->request->getData('searchType');
        if($searchType == 'item_name'){
            $items=$this->Wishlists->Customers->find()->where(['Customers.name Like'=>''.$name.'%']);
            ?>
                <ul id="item-list" style="width: 16% !important;">
                    <?php foreach($items as $show){ ?>
                        <li onClick="selectAutoCompleted('<?php echo $show->id;?>','<?php echo $show->name;?>')">
                            <?php echo $show->name?>    
                        </li>
                    <?php } ?>
                </ul>
            <?php
        }
        
        exit;  
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Items', 'Customers']
        ];
        $wishlists = $this->paginate($this->Wishlists);

        $this->set(compact('wishlists'));
    }

    /**
     * View method
     *
     * @param string|null $id Wishlist id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wishlist = $this->Wishlists->get($id, [
            'contain' => ['Items', 'Customers']
        ]);

        $this->set('wishlist', $wishlist);
    }

     public function wishlistReport()
    {
        $this->viewBuilder()->layout('index_layout');
        $jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
        $Wishlist= $this->Wishlists->newEntity();
        $Wishlists = $this->Wishlists->find()
        ->contain(['Customers','Items','ItemVariations'=>['Units']]);
        //pr($Wishlists->toArray());exit;
        if ($this->request->is('post')) {
            $datas = $this->request->getData();
            if(!empty($datas['customer_id']))
            {
                $Wishlists->where(['Wishlists.customer_id'=>$datas['customer_id']]);
            }
             if(!empty($datas['item_id']))
            {
                $Wishlists->where(['Wishlists.item_id'=>$datas['item_id']]);
                //pr($Wishlists->toArray());exit;
            }
            if(!empty($datas['From'])){
                $from_date=date("Y-m-d",strtotime($datas['From']));
                $Wishlists->where(['Wishlists.created_on >='=> $from_date]);
            }
            if(!empty($datas['To'])){ 
                $to_date=date("Y-m-d",strtotime($datas['To']));
                $Wishlists->where(['Wishlists.created_on <=' => $to_date ]);
            }
        }
        
        //pr($promoCodes->toArray());exit
         $Customers = $this->Wishlists->Customers->find('list', ['limit' => 200]);
        $items = $this->Wishlists->Items->find('list', ['limit' => 200]);
        $item_variation = $this->Wishlists->ItemVariations->find('list', ['limit' => 200]);
        $this->set(compact('Wishlist', 'Wishlists','items','Customers','item_variation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wishlist = $this->Wishlists->newEntity();
        if ($this->request->is('post')) {
            $wishlist = $this->Wishlists->patchEntity($wishlist, $this->request->getData());
            if ($this->Wishlists->save($wishlist)) {
                $this->Flash->success(__('The wishlist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wishlist could not be saved. Please, try again.'));
        }
        $items = $this->Wishlists->Items->find('list', ['limit' => 200]);
        $customers = $this->Wishlists->Customers->find('list', ['limit' => 200]);
        $this->set(compact('wishlist', 'items', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Wishlist id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wishlist = $this->Wishlists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wishlist = $this->Wishlists->patchEntity($wishlist, $this->request->getData());
            if ($this->Wishlists->save($wishlist)) {
                $this->Flash->success(__('The wishlist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wishlist could not be saved. Please, try again.'));
        }
        $items = $this->Wishlists->Items->find('list', ['limit' => 200]);
        $customers = $this->Wishlists->Customers->find('list', ['limit' => 200]);
        $this->set(compact('wishlist', 'items', 'customers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wishlist id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wishlist = $this->Wishlists->get($id);
        if ($this->Wishlists->delete($wishlist)) {
            $this->Flash->success(__('The wishlist has been deleted.'));
        } else {
            $this->Flash->error(__('The wishlist could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
