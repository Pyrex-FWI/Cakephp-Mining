<?php
App::uses('MiningAppController', 'Mining.Controller');
/**
 * Songs Controller
 *
 * @property Song $Song
 */
class SongsController extends MiningAppController {

	public $helpers = array('Text');
	public $uses = array('Mining.Song');
	
	public $components = array(
			'Mining.ColGrid'=>array(
							'limit'=>5,
							'default_col'=>array('Interprete.name','Song.title','Genre.name','Song.bpm','Song.year')));
	public $scaffold;


	

	public function beforeFilter(){
		
		if(in_array($this->request->params['action'],array('rowDetails','index'))){
	
			$this->Song->bindModel(
					array('belongsTo'=>array(
							'Interprete'	=>
							 array(	
							 		'className'=>'Mining.artist',
									'foreignKey'=>'artist_id'	
									)
							)
						),
					false
			);
		}

		
		return parent::beforeFilter();
	}
	
	public function paginate($object = null, $scope = array(), $whitelist = array()){
	
		$this->setFilterArgsAndPresetVars();
		//debug($this->{$this->modelClass});die();
		$this->Prg->commonProcess();
		//debug($this->{$this->modelClass}->actAs);
		if(in_array("Search.Searchable",$this->{$this->modelClass}->actAs))
			$this->paginate['conditions'] = $this->{$this->modelClass}->parseCriteria($this->passedArgs);
	
		return parent::paginate($object = null, $scope = array(), $whitelist = array());
	}
	
	public function indexByGenre($genre =null){
		//$genres = $this->find
		//select s.id, g.name, g.id, count(g.id) from songs s left join genres g on (g.id=s.genre_id) where s.genre_id is not null group by g.id order by count(g.id) desc
		$NbSongsByGenre = $this->Song->find('all',array(
			'conditions'=>array("Song.genre_id is not null","Song.genre_id <> 0"),
			'fields'=>array("Genre.id","Genre.name","count(Genre.id) as nb"),
			'group'=>array("Genre.id"),
			'order'=>array("Genre.name ASC")
		));
		if(!$genre){
			if(!empty($NbSongsByGenre)){
				$genre = $NbSongsByGenre[0]['Genre']['id'];	
			}
			$genre =1;
		}
		$this->set(compact('NbSongsByGenre'));
		
		$this->indexByGenreTabPane($genre);
		
	}
	
	public function indexByGenreTabPane($genre){
		$this->paginate = array(
			'conditions'	=>	array('Song.Genre_id'=>$genre)
		);
		$this->set('songs',$this->paginate());
		$this->set('genre_id',$genre);
		
	}
	
	public function rowDetails($id){
		
		$this->Song->id = $id;
		if (!$this->Song->exists()) {
			throw new NotFoundException(__('Invalid song'));
		}
		$this->Song->read(null,$id);
		//debug($this->Song->getNeighbourKeys($this->Song->data['Song']['key']));	
		$this->set('same',$this->Song->findCorrelation());	
		$this->Song->recursive = 0;
		$this->set('song', $this->Song->read(null, $id));
	}

}
