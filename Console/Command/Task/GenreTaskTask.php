<?php

App::uses('Xml', 'Utility');

class GenreTaskTask extends Shell {
	
	var $uses = array('Mining.Song','Mining.Genre');
	
	var $tasks = array('Mining.ProgressBar');

	public function execute() {
	}

	public function parseXlm2($fileName = null){
		if(!file_exists($fileName)) return;
		
		//=============Genre===================
		
		$this->out('Clean Genres');
		copy($fileName,$fileName . ".TEMPORARY.xml");
				
		$xmlTmp = Xml::build($fileName . ".TEMPORARY.xml");
		
		$xmlOriginal = Xml::build($fileName);
				
		$genresKnow = array();
		
		$this->ProgressBar->start($xmlTmp->count());
		
		foreach($xmlTmp->children() as $file){
				
			$this->ProgressBar->next();
			if(isset($file->Song->attributes()->genre_id)) continue;
			$genre = (string)$file->Song->attributes()->genre;
			if(in_array($genre, $genresKnow) || $genre == '0') continue;
		
		
			$this->Genre->recursive = -1;
			$this->Genre->id = null;
			$genreDb = $this->Genre->findByName($genre);
			if(!$genreDb){
				$this->Genre->create();
				$this->Genre->set('name',$genre);
				$this->Genre->save();
		
			}else{ $this->Genre->id = $genreDb['Genre']['id'];
			}
		
			$scope = $xmlOriginal->xpath("///Song[@genre='$genre']/..");

			for($i =0; $i < count($scope); $i++){
				//$scope[$i]->Song->addAttribute('genre_id',$this->Genre->id);
				//$scope[$i]->addChild('Genre');
				$scope[$i]->Song->addChild('genre_id',$this->Genre->id);
				unset($scope[$i]->Song['genre']);
		
			}
		
			$xmlOriginal->asXML($fileName);
		
			$genresKnow[$this->Genre->id] = $genre;
				
		}
		
		$this->ProgressBar->finish();
		
		unlink($fileName . ".TEMPORARY.xml");		
	} 

	public function parseXlm($fileName = null){
		if(!file_exists($fileName)) return;
		
		//=============Genre===================
		
		$this->out('Clean Genres');
		copy($fileName,$fileName . ".TEMPORARY.xml");
				
		$xmlTmp = Xml::build($fileName . ".TEMPORARY.xml");
		
		$xmlOriginal = Xml::build($fileName);
				
		$genresKnow = array();
		
		$this->ProgressBar->start($xmlTmp->count());
		
		foreach($xmlTmp->children() as $song){
				
			$this->ProgressBar->next();
			if(isset($song->Genre)) continue;
			$genre = (string)$song->attributes()->genre;
			if(in_array($genre, $genresKnow) || $genre == '0') continue;
		
		
			$this->Genre->recursive = -1;
			$this->Genre->id = null;
			$genreDb = $this->Genre->findByName($genre);
			if(!$genreDb){
				$this->Genre->create();
				$this->Genre->set('name',$genre);
				$this->Genre->save();
		
			}else{ $this->Genre->id = $genreDb['Genre']['id'];
			}
		
			$scope = $xmlOriginal->xpath("//Song[@genre='$genre']");
			for($i =0; $i < count($scope); $i++){
				$scope[$i]->addAttribute('genre_id',$this->Genre->id);
				//$scope[$i]->addChild('Genre');
				//$scope[$i]->Genre->addChild('id',$this->Genre->id);
				unset($scope[$i]['genre']);
		
			}
		
			$xmlOriginal->asXML($fileName);
		
			$genresKnow[$this->Genre->id] = $genre;
				
		}
		
		$this->ProgressBar->finish();
		
		unlink($fileName . ".TEMPORARY.xml");		
	} 

}
?>
