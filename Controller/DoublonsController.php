<?php
App::uses('MiningAppController', 'Mining.Controller');
/**
 * Doublons Controller
 *
 * @property Doublon $Doublon
 */
class DoublonsController extends MiningAppController {


	public $helpers = array('Player.Player','Text');
/**
 * index method
 *
 * @return void
 */
	public $paginate = array('limit'=>10);
	public function index() {
		$this->Doublon->recursive = 2;
		$this->set('doublons', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Doublon->id = $id;
		if (!$this->Doublon->exists()) {
			throw new NotFoundException(__('Invalid doublon'));
		}
		$this->set('doublon', $this->Doublon->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Doublon->create();
			if ($this->Doublon->save($this->request->data)) {
				$this->Session->setFlash(__('The doublon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doublon could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Doublon->id = $id;
		if (!$this->Doublon->exists()) {
			throw new NotFoundException(__('Invalid doublon'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Doublon->save($this->request->data)) {
				$this->Session->setFlash(__('The doublon has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doublon could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Doublon->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Doublon->id = $id;
		if (!$this->Doublon->exists()) {
			throw new NotFoundException(__('Invalid doublon'));
		}
		if ($this->Doublon->delete()) {
			$this->Session->setFlash(__('Doublon deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Doublon was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
