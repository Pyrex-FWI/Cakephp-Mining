<?php

App::uses('Xml', 'Utility');
App::uses('Sanitize', 'Utility');

class CleanTaskTask extends Shell {
	
	var $uses = array('Mining.Song');
	

	public function execute() {
		$this->updateFileName();
		$this->deleteObseleteFiles();
		$this->checkExistence();
	}

	public function updateFileName(){
		$this->out('Update Filename');
		return $this->Song->updateFileName();
	} 
	
	public function checkExistence(){
		$this->out("Check existance of songs");
		$c = $this->Song->find('count');
		$page = 1;
		$size = 100;
		$maxPage = ceil($c/$size);
		for($page; $page <= $maxPage; $page++){
			$dataSet = $this->Song->find('all',array('fields'=>array('Song.id','Song.filepath'),'limit'=>$size,'page'=>$page,'recusive'=>-1));
			foreach($dataSet as $song){
				$this->Song->id = $song['Song']['id'];
				if(!file_exists($song['Song']['filepath'])){
					$this->Song->set('exist','N');
					$this->Song->save();
				}elseif($song['Song']['filepath'] == 'N'){
					$this->Song->set('exist','Y');
					$this->Song->save();					
				}
			}
		}
		
		
		
	}
	
	public function deleteObseleteFiles(){
		$this->out('Delete Obselete Files');
		return $this->Song->deleteObseleteFiles();
	}

}
?>
