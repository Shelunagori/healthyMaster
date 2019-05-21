<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemVariations Controller
 *
 * @property \App\Model\Table\ItemVariationsTable $ItemVariations
 *
 * @method \App\Model\Entity\ItemVariation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemVariationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items', 'Units']
        ];
        $itemVariations = $this->paginate($this->ItemVariations);

        $this->set(compact('itemVariations'));
    }

    /**
     * View method
     *
     * @param string|null $id Item Variation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemVariation = $this->ItemVariations->get($id, [
            'contain' => ['Items', 'Units']
        ]);

        $this->set('itemVariation', $itemVariation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemVariation = $this->ItemVariations->newEntity();
        if ($this->request->is('post')) {
            $itemVariation = $this->ItemVariations->patchEntity($itemVariation, $this->request->getData());
            if ($this->ItemVariations->save($itemVariation)) {
                $this->Flash->success(__('The item variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item variation could not be saved. Please, try again.'));
        }
        $items = $this->ItemVariations->Items->find('list', ['limit' => 200]);
        $units = $this->ItemVariations->Units->find('list', ['limit' => 200]);
        $this->set(compact('itemVariation', 'items', 'units'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Variation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemVariation = $this->ItemVariations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemVariation = $this->ItemVariations->patchEntity($itemVariation, $this->request->getData());
            if ($this->ItemVariations->save($itemVariation)) {
                $this->Flash->success(__('The item variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item variation could not be saved. Please, try again.'));
        }
        $items = $this->ItemVariations->Items->find('list', ['limit' => 200]);
        $units = $this->ItemVariations->Units->find('list', ['limit' => 200]);
        $this->set(compact('itemVariation', 'items', 'units'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Variation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemVariation = $this->ItemVariations->get($id);
        if ($this->ItemVariations->delete($itemVariation)) {
            $this->Flash->success(__('The item variation has been deleted.'));
        } else {
            $this->Flash->error(__('The item variation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
