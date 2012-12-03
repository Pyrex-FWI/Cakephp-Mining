<?php

App::uses('AppHelper', 'Mining.View/Helper');
App::uses('ClassRegistry', 'Utility');

class ColGridHelper extends AppHelper {
	
	var $helpers = array('Session','Form','Js'=>array('Jquery'));
	
	var $limit = 5;
	
	public function getColGrid(){
		if($this->Session->check('ColGrid.'.$this->request->params['controller'])){
			$fieldsInSession  = array_slice((array)$this->Session->read('ColGrid.'.$this->request->params['controller']),0,$this->limit);

		}else{
			//if(ClassRegistry::isKeySet('Mining.song')){
			if(ClassRegistry::isKeySet('Mining.'.array_shift(array_keys($this->request->models)))){
				//$modelInstance = ClassRegistry::getObject("Mining.song");
				$modelInstance = ClassRegistry::getObject("Mining.".array_shift(array_keys($this->request->models)));
			}else{
				//$modelInstance = ClassRegistry::init("Mining.song");
				$modelInstance = ClassRegistry::init("Mining.".array_shift(array_keys($this->request->models)));
			}
			$fieldsInSession = (array_slice(array_keys($modelInstance->schema()),0,$this->limit));
			for($i=0; $i < count($fieldsInSession); $i++){
				$fieldsInSession[$i] = $modelInstance->alias . "." . $fieldsInSession[$i];
			}
			
		}
		
		return $fieldsInSession;
	}
	
	public function printColGridChoose($FieldsCol){
		$this->Js->buffer('$("#ColGrid'.Inflector::humanize('fields').'").krisSelect();');
		return  $this->Form->create('ColGrid') . $this->Form->select('fields',$FieldsCol,array('multiple'=>'multiple','value' => $this->getColGrid())) . $this->Form->end();
		
	}
	
	
	public function printColGridChooseTable($FieldsCol){
		$currentModel = current(array_keys($this->request->params['models']));
		$jsonItems = '{';
		
		foreach($FieldsCol as $model => $modelFieldsList){
			foreach($modelFieldsList as $modelField => $field){
				$_field = substr($modelField, strrpos($modelField, '.')+1);
				$_model = substr($modelField, 0, strrpos($modelField, '.'));			
				if(strlen($jsonItems) > 1) $jsonItems .=', ';
				$jsonItems .= '"'.$modelField.'":"'.$_field.'"';
			}
			
		}		
		$jsonItems .='}';
		//debug($this);
		$html = $this->Form->create('ColGrid',array('url'=>array("controller"=>$this->request["controller"],'action'=>'index')));
		$index = 0;
		//debug($this->request->data[$currentModel]);
		foreach($this->getColGrid() as $i => $col){ 
				$_field = substr($col, strrpos($col, '.')+1);
				$_model = substr($col, 0, strrpos($col, '.'));			
				$id_use[$_model.'_'.$_field] = isset($id_use[$_model.'_'.$_field]) ?  $id_use[$_model.'_'.$_field]+1 : 1;
				$idName = $_model."_".$_field.$id_use[$_model.'_'.$_field];
				$Search_val = isset($this->request->data[$currentModel]["Search_".$index])? $this->request->data[$currentModel]["Search_".$index] : "";
				$html .= $this->Form->hidden('ColGrid[]',array('value'=>$col, 'id'=>"F_".$idName,'name'=>'data[ColGrid][Col_'.$index.']'));
				$html .= $this->Form->hidden('ColGrid[]',array('value'=>$Search_val, 'id'=>"Filter_".$idName,'name'=> 'data['.$currentModel.'][Search_'.$index.']'));
				$this->Js->buffer('$("#'.$idName.'").ColGridChoose({"FormId":"ColGridIndexForm", "head":"'._($_field).'", "items": '.$jsonItems.', "value":"'.$Search_val.'"});');
				$index++;
		}
		$html .= $this->Form->end();
		
		return $html;
	}
}
