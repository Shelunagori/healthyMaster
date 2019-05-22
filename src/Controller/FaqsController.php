<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Faqs Controller
 *
 * @property \App\Model\Table\FaqsTable $Faqs
 *
 * @method \App\Model\Entity\Faq[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FaqsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
        $user_id=$this->Auth->User('id');
		$city_id=$this->Auth->User('city_id'); 
		$this->viewBuilder()->layout('admin_portal');
		$this->paginate = [
			'limit' => 20,
         ];
		 
		if($id)
		{
		   $id = $this->EncryptingDecrypting->decryptData($id);
		}
		
        $faqs1 =  $this->Faqs->find()->where(['Faqs.status'=>0,'Faqs.city_id'=>$city_id])->contain(['Cities']);
		if($id)
		{
		   $faq = $this->Faqs->get($id);
		}
		else
		{
			  $faq = $this->Faqs->newEntity();
		}
		
        if ($this->request->is(['post','put'])) {
            $faq = $this->Faqs->patchEntity($faq, $this->request->getData());
			$faq->city_id=$city_id;
            if ($this->Faqs->save($faq)) {
                $this->Flash->success(__('The Faq has been saved.'));
				return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Faq could not be saved. Please, try again.'));
        }
		else if ($this->request->is(['get'])){
			$search=$this->request->getQuery('search');
			$faqs1->where([
							'OR' => [
									'Faqs.question LIKE' => $search.'%',
									'Faqs.answer LIKE' => $search.'%'
							]
			]);
		}
		 
		
		$faqs=$this->paginate($faqs1);
		$cities=$this->Faqs->Cities->find('list');
		$paginate_limit=$this->paginate['limit'];
        $this->set(compact('cities', 'faqs','faq','paginate_limit'));
    }

    /**
     * View method
     *
     * @param string|null $id Faq id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $faq = $this->Faqs->get($id, [
            'contain' => ['Cities']
        ]);

        $this->set('faq', $faq);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $faq = $this->Faqs->newEntity();
        if ($this->request->is('post')) {
            $faq = $this->Faqs->patchEntity($faq, $this->request->getData());
            if ($this->Faqs->save($faq)) {
                $this->Flash->success(__('The faq has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faq could not be saved. Please, try again.'));
        }
        $cities = $this->Faqs->Cities->find('list', ['limit' => 200]);
        $this->set(compact('faq', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Faq id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $faq = $this->Faqs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $faq = $this->Faqs->patchEntity($faq, $this->request->getData());
            if ($this->Faqs->save($faq)) {
                $this->Flash->success(__('The faq has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faq could not be saved. Please, try again.'));
        }
        $cities = $this->Faqs->Cities->find('list', ['limit' => 200]);
        $this->set(compact('faq', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Faq id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($dir)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
		$id = $this->EncryptingDecrypting->decryptData($dir);
        $faq = $this->Faqs->get($id);
		$faq->status=1;
        if ($this->Faqs->save($faq)) {
            $this->Flash->success(__('The faq has been deleted.'));
        } else {
            $this->Flash->error(__('The faq could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
