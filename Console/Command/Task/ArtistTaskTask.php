<?php

App::uses('Xml', 'Utility');

class ArtistTaskTask extends Shell {
	
	var $uses = array('Mining.Song','Mining.Artist');
	
	var $tasks = array('Mining.ProgressBar');
	public function execute() {
	}

	public function parseXlm2($fileName = null){
		
		if(!file_exists($fileName)) return;
		
		copy($fileName,$fileName . ".TEMPORARY.xml");
				
		$xmlTmp = Xml::build($fileName . ".TEMPORARY.xml");
		
		$xmlOriginal = Xml::build($fileName);
				
		//=============Artist==================
		$this->out('Clean Artists');
		
		$artistsKnow = array();
		$this->ProgressBar->start($xmlTmp->count());
		foreach($xmlTmp->children() as $file){
			
			if(isset($file->Artist)){$this->ProgressBar->next(); continue;}
			
			$this->ProgressBar->next();

			$artist = (string)$file->Song->attributes()->artist;
			
			$artist = substr($artist,0,50);
			
			if(in_array($artist, $artistsKnow) || in_array($artist,array('','0')) ) continue;
			$this->Artist->recursive = -1;
			$this->Artist->id = null;
			//debug($artist);
			$artistDb = $this->Artist->findByName($artist);
			if(!$artistDb){
				$this->Artist->create();
				$this->Artist->set('name',$artist);
				$this->Artist->save();
		
			}else{ 
				$this->Artist->id = $artistDb['Artist']['id'];
			}
		//debug($this->Artist->id);
			
			$scope = $xmlOriginal->xpath("///Song[@artist=\"".$artist."\"]/..");

			for($i =0; $i < count($scope); $i++){
				//$scope[$i]->addChild('Artist');
				$scope[$i]->Song->addChild('artist_id',$this->Artist->id);
				unset($scope[$i]->Song['artist']);
		
			}
		
			$xmlOriginal->asXML($fileName);
		
			$artistsKnow[$this->Artist->id] = $artist;
			
			
		}
		
		unlink($fileName . ".TEMPORARY.xml");
		
		$this->ProgressBar->finish();
		//=============Artist==================
		
		
				
	} 
	public function parseXlm($fileName = null){
		
		if(!file_exists($fileName)) return;
		
		copy($fileName,$fileName . ".TEMPORARY.xml");
				
		$xmlTmp = Xml::build($fileName . ".TEMPORARY.xml");
		
		$xmlOriginal = Xml::build($fileName);
				
		//=============Artist==================
		$this->out('Clean Artists');
		
		$artistsKnow = array();
		$this->ProgressBar->start($xmlTmp->count());
		foreach($xmlTmp->children() as $song){
			
			if(isset($song->Artist)){$this->ProgressBar->next(); continue;}
			
			$this->ProgressBar->next();

			$artist = (string)$song->attributes()->artist;
			
			$artist = substr($artist,0,50);
			
			//if(in_array($artist, $artistsKnow) || in_array($artist,array('','0')) ) continue;
			$this->Artist->recursive = -1;
			$this->Artist->id = null;
			//debug($artist);
			$artistDb = $this->Artist->findByName($artist);
			if(!$artistDb){
				$this->Artist->create();
				$this->Artist->set('name',$artist);
				$this->Artist->save();
		
			}else{ 
				$this->Artist->id = $artistDb['Artist']['id'];
			}
		//debug($this->Artist->id);
			
			$scope = $xmlOriginal->xpath("//Song[@artist=\"".$artist."\"]");

			for($i =0; $i < count($scope); $i++){
				$scope[$i]->addChild('Artist');
				$scope[$i]->Song->addChild('artist_id',$this->Artist->id);
				unset($scope[$i]->Song['artist']);
		
			}
		
			$xmlOriginal->asXML($fileName);
		
			$artistsKnow[$this->Artist->id] = $artist;
			
			
		}
		
		unlink($fileName . ".TEMPORARY.xml");
		
		$this->ProgressBar->finish();
		//=============Artist==================
		
		
				
	} 

}
?>
