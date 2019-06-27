<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pincodes Controller
 *
 * @property \App\Model\Table\PincodesTable $Pincodes
 *
 * @method \App\Model\Entity\Pincode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PincodesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->viewBuilder()->layout('index_layout');
        $this->paginate = [
            'contain' => ['States','Cities','DeliveryCharges']
        ];
        $pincodes = $this->paginate($this->Pincodes);

        $this->set(compact('pincodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Pincode id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pincode = $this->Pincodes->get($id, [
            'contain' => ['States', 'Cities']
        ]);

        $this->set('pincode', $pincode);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout('index_layout');
        $pincode = $this->Pincodes->newEntity();
        $DeliveryCharges = $this->Pincodes->DeliveryCharges->newEntity();
        if ($this->request->is('post')) {
            $data=$this->request->getData();
            pr($data);
            $pincode = $this->Pincodes->patchEntity($pincode,$data);
            if ($this->Pincodes->save($pincode)) {
                if($data['we_deliver']=="Yes")
                {
                    $DeliveryCharges->amount=$this->request->getData('amount');
                    $DeliveryCharges->charge=$this->request->getData('charge');
                    $DeliveryCharges->type=$this->request->getData('type');
                    $DeliveryCharges->pincode_id=$pincode->id;
                    //pr($DeliveryCharges);
                    if($this->Pincodes->DeliveryCharges->save($DeliveryCharges))
                    {
                        $this->Flash->success(__('The pincode has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    }
                }
                $this->Flash->success(__('The pincode has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pincode could not be saved. Please, try again.'));
        }
        $states = $this->Pincodes->States->find('list', ['limit' => 200]);
        $cities = $this->Pincodes->Cities->find('list', ['limit' => 200]);
        $this->set(compact('pincode', 'states', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pincode id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout('index_layout');
        $pincode = $this->Pincodes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pincode = $this->Pincodes->patchEntity($pincode, $this->request->getData());
            if ($this->Pincodes->save($pincode)) {
                $this->Flash->success(__('The pincode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pincode could not be saved. Please, try again.'));
        }
        $states = $this->Pincodes->States->find('list', ['limit' => 200]);
        $cities = $this->Pincodes->Cities->find('list', ['limit' => 200]);
        $this->set(compact('pincode', 'states', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pincode id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pincode = $this->Pincodes->get($id);
        if ($this->Pincodes->delete($pincode)) {
            $this->Flash->success(__('The pincode has been deleted.'));
        } else {
            $this->Flash->error(__('The pincode could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
