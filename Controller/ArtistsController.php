<?php
App::uses('MiningAppController', 'Mining.Controller');
/**
 * Artists Controller
 *
 * @property Artist $Artist
 */
class ArtistsController extends MiningAppController {

	public $uses = array('Mining.Artist');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		/*$this->Artist->recursive = 0;
		$this->set('artists', $this->paginate());*/
		$this->redirect(array('action'=>'indexLetter','a'));
	}
	
	public function indexLetter($letter= null){
		if(!$letter){
			$this->redirect(array('action'=>'indexLetter','a'));
		}
		
		$this->set('total_artists',$this->Artist->find('count'));
		$this->set('artists', $this->Artist->find('all',array('conditions'=>array("Artist.name like '$letter%'"))));
		$AlphaScope = array("#",'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$this->set('alpha',$AlphaScope);
		$this->set('curLetter',$letter);
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
		$this->set('artist', $this->Artist->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Artist->create();
			if ($this->Artist->save($this->request->data)) {
				$this->Session->setFlash(__('The artist has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artist could not be saved. Please, try again.'));
			}
		}
		$songs = $this->Artist->Song->find('list');
		$this->set(compact('songs'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Artist->save($this->request->data)) {
				$this->Session->setFlash(__('The artist has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artist could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Artist->read(null, $id);
		}
		$songs = $this->Artist->Song->find('list');
		$this->set(compact('songs'));
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
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
		if ($this->Artist->delete()) {
			$this->Session->setFlash(__('Artist deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Artist was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
