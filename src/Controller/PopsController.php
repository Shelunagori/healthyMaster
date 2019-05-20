<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pops Controller
 *
 * @property \App\Model\Table\PopsTable $Pops
 *
 * @method \App\Model\Entity\Pop[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PopsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
        $pops = $this->paginate($this->Pops);
        if(!$id == null)
            $pop = $this->Pops->get($id, [
                'contain' => []
            ]);
        else
            $pop = $this->Pops->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $pop = $this->Pops->patchEntity($pop, $this->request->getData());
            if ($this->Pops->save($pop)) {
                $this->Flash->success(__('The pop has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pop could not be saved. Please, try again.'));
        }

        $this->set(compact('pops','pop','id'));
    }

    /**
     * View method
     *
     * @param string|null $id Pop id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pop = $this->Pops->get($id, [
            'contain' => []
        ]);

        $this->set('pop', $pop);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

    /**
     * Edit method
     *
     * @param string|null $id Pop id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pop = $this->Pops->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pop = $this->Pops->patchEntity($pop, $this->request->getData());
            if ($this->Pops->save($pop)) {
                $this->Flash->success(__('The pop has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pop could not be saved. Please, try again.'));
        }
        $this->set(compact('pop'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pop id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pop = $this->Pops->get($id);
        if ($this->Pops->delete($pop)) {
            $this->Flash->success(__('The pop has been deleted.'));
        } else {
            $this->Flash->error(__('The pop could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
