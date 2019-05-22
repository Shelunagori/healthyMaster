<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Carts Controller
 *
 * @property \App\Model\Table\CartsTable $Carts
 *
 * @method \App\Model\Entity\Cart[] paginate($object = null, array $settings = [])
 */
class CartsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Customers', 'Items']
        ];
        $carts = $this->paginate($this->Carts);

        $this->set(compact('carts'));
        $this->set('_serialize', ['carts']);
    }

	//////USE///FOR////CRONJOB///START///////
	public function freezeCartRemove()
    {
        $freeze_details = $this->Carts->Items->find()->where(['ready_to_sale'=>'No'])->orWhere(['freeze'=>1]);	
		foreach($freeze_details as $freeze_detail){
				$item_id=$freeze_detail->id;
				$query = $this->Carts->query();
				$result = $query->delete()
				->where(['item_id' => $item_id])
				->execute();
		}
		exit;
    }
	//////USE///FOR////CRONJOB///END////////

    /**
     * View method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => ['Customers', 'Items']
        ]);

        $this->set('cart', $cart);
        $this->set('_serialize', ['cart']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cart = $this->Carts->newEntity();
        if ($this->request->is('post')) {
            $cart = $this->Carts->patchEntity($cart, $this->request->getData());
            if ($this->Carts->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $customers = $this->Carts->Customers->find('list', ['limit' => 200]);
        $items = $this->Carts->Items->find('list', ['limit' => 200]);
        $this->set(compact('cart', 'customers', 'items'));
        $this->set('_serialize', ['cart']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cart = $this->Carts->patchEntity($cart, $this->request->getData());
            if ($this->Carts->save($cart)) {
                $this->Flash->success(__('The cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart could not be saved. Please, try again.'));
        }
        $customers = $this->Carts->Customers->find('list', ['limit' => 200]);
        $items = $this->Carts->Items->find('list', ['limit' => 200]);
        $this->set(compact('cart', 'customers', 'items'));
        $this->set('_serialize', ['cart']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cart id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cart = $this->Carts->get($id);
        if ($this->Carts->delete($cart)) {
            $this->Flash->success(__('The cart has been deleted.'));
        } else {
            $this->Flash->error(__('The cart could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function cartReport()
    {
         $this->viewBuilder()->layout('index_layout');
         $Cart= $this->Carts->newEntity();
        $Carts = $this->Carts->find()
        ->group(['customer_id'])
        ->contain(['Items','Customers','ItemVariations']);
        if ($this->request->is('post')) {
            $datas = $this->request->getData();
            if(!empty($datas['customer_id']))
            {
                $Carts->where(['customer_id'=>$datas['customer_id']]);
            }
             if(!empty($datas['item_id']))
            {
                $Carts->where(['item_id'=>$datas['item_id']]);
            }
            if(!empty($datas['From'])){
                $from_date=date("Y-m-d",strtotime($datas['From']));
                $Carts->where(['Carts.created_on >='=> $from_date]);
            }
            if(!empty($datas['To'])){ 
                $to_date=date("Y-m-d",strtotime($datas['To']));
                $Carts->where(['Carts.created_on <=' => $to_date ]);
            }
        }
        
        //pr($promoCodes->toArray());exit
         $Customers = $this->Carts->Customers->find('list', ['limit' => 200]);
        $items = $this->Carts->Items->find('list', ['limit' => 200]);
        $item_variation = $this->Carts->ItemVariations->find('list', ['limit' => 200]);
        $this->set(compact('Cart', 'Carts','items','Customers','item_variation'));
    }
}
