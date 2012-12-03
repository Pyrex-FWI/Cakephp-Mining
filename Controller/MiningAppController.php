<?php
App::uses('AppController', 'Controller');
//Pour utiliser un scaffold perso.
App::uses('Scaffold', 'Mining.Controller');
/**
 * Artists Controller
 *
 * @property Artist $Artist
 */
class MiningAppController extends AppController {
	public $paginate;
	public $helpers = array(
			'Js',
			'Html',
			'Form',
			'Session',
			'Mining.ColGrid'=>array('limit'=>5),
			'Mining.SongDetails'
	);
	
	public $components = array(
			'RequestHandler',
			'Mining.ColGrid' => array('limit' => 5),
			'Search.Prg'
	);
	
	//public $uses = array('Ming.Song');
	
	public $tablePrefix = 'mining_';
	
	public $presetVars  = true;

	

	public function setFilterArgsAndPresetVars(){

		//debug($this->ColGrid->getColGrid());
		foreach($this->ColGrid->getColGrid() as $col => $modelField){

			$_field = substr($modelField, strrpos($modelField, '.')+1);
			$_model = substr($modelField, 0, strrpos($modelField, '.'));
			
			$schema = array();
			if($_model == $this->modelClass){
				$schema = ($this->{$this->modelClass}->schema());
			}elseif(key_exists($_model,array_merge($this->{$this->modelClass}->belongsTo,$this->{$this->modelClass}->hasOne))){
				$schema = ($this->{$this->modelClass}->$_model->schema());
			}
			
			if(empty($schema)) return;
			$typeFilter =  'like';
			switch ($schema[$_field]['type']) {
				case 'integer':
					$typeFilter = 'int'
				;
				break;
				case 'string':
					$typeFilter = 'string'
				;
				break;
				
				default:
					;
				break;
			}
			
			
			$this->{$this->modelClass}->filterArgs[$modelField] = array(
					'name'=>str_replace("Col", "Search", $col),
					'field'=>$modelField,
					'type'=> $typeFilter
					);
			$this->presetVars[$modelField] = array(
					'field'=>str_replace("Col", "Search", $col),
					'type'=> 'value'
					);
		}
	}
	

	
	
	public function xmlPlaylist(){
		//$this->layout = 'xml';
		$this->layoutPath = 'xml'; 
		$songs = array();
		if(!empty($this->passedArgs)){
			$songs = $this->Song->find('all',array('conditions'=>array('Song.id'=>$this->passedArgs)));
		}
		$this->set('songs',$songs);
	}
	

		
	public function beforeRender(){
		parent::beforeRender();
		if($this->request->is('ajax')){
			$this->layout = 'ajax';
		}
	}
	

	public function afterFilter(){
		//debug($this);
	}
}
