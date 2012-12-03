<?php

class ColGridComponent extends Component {

	public $components = array('Session');
	public $hostController = null;
	public $controller = null;
	public $limit = 4;
	public $default_col = array();

	
	public function __construct(ComponentCollection $collection, $settings) {
		$this->controller = $collection->getController();
		return parent::__construct($collection,$settings);
	}
	
	public function startup($controller){
		
		if(isset($controller->request->data['ColGrid'])){
			$fieldSet = $controller->getColGrid();
			$fieldsForm = $controller->request->data['ColGrid'];
			//debug($fieldsForm);
			$fieldsForSession = array();
			unset($controller->request->data['ColGrid']);
			foreach($fieldsForm as $k => $modelField){
				$m = substr($modelField, 0, strrpos($modelField, '.'));

				if(in_array($modelField,$fieldSet[$m])) $fieldsForSession = ($modelField);
			}

			$this->Session->write('ColGrid.'.$controller->request->params['controller'],$fieldsForm);
		}
		
		return parent::startup($controller);
	
	}
	
	public function getColGrid(){
		
		if($this->Session->check('ColGrid.'.$this->controller->request->params['controller'])) return $this->Session->read('ColGrid.'.$this->controller->request->params['controller']);
		elseif(count($this->default_col)> 0){
			$fieldsInSession = array_slice($this->default_col,0,$this->limit);
			$this->Session->write('ColGrid.'.$this->controller->request->params['controller'],$fieldsInSession);
			return $fieldsInSession;
		}
		else{
			$model = $this->controller->modelClass;
			$fieldsInSession = (array_slice(array_keys($this->controller->{$model}->schema()),0,$this->limit));
			for($i=0; $i < count($fieldsInSession); $i++){
				$fieldsInSession[$i] = $this->controller->{$model}->alias . "." . $fieldsInSession[$i];
			}
			return $fieldsInSession;
		}
	}
	
	function getColFilterGrid(){
		if(isset($this->controller->request->data['ColGrid'])){
			return array_combine((array)$this->getColGrid(), (array)$this->controller->request->data['ColGrid']);
		}
		return array();
	}
	
}
