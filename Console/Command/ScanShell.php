<?php
App::uses('Folder', 'Utility');
App::uses('Xml', 'Utility');
App::uses('File', 'Utility');
App::uses('IdTag', 'Mining.Model');
App::uses('Sanitize', 'Utility');

class ScanShell extends AppShell {
	

	public $WorkPath = "/home/ubuntu/DBS/";
	
	public $uses = array('Mining.Occurrence','Mining.Song','Mining.Idtag','Mining.Artist','Mining.Album','Mining.Genre');
	
	public $tasks = array("Mining.ProgressBar","Mining.GenreTask","Mining.ArtistTask", "Mining.AlbumTask", "Mining.CleanTask");
	
	public $audioFiles = null;
	
	public $firstPassFile = null;

	
	
    public function main() {
    	
    	
    	$this->firstPassFile = 	TMP ."MiningDB.xml";
    	
    	//$this->clear();

    	//Checking Path
    	if($this->checkWorkPath() == FALSE){ $this->out(sprintf("\"<error>%s</error>\" est inacessible.",$this->WorkPath)); return; }
    	
    	##Get audioFiles
		$this->audioFiles = $this->searchAudioFile($this->WorkPath);
    
    	//Get Audio data For DataBase Inser/update.
    	$this->FirstPass();
    		
    	//Set Artists and Genre data in Db, Update  xml local file
    	$this->SecondPass();
    	
    	$this->ThirdPass();
    	
    	Cache::clear();
    	return;
    	
		
    }
    /*
    public function getOptionParser() {
    	$parser = parent::getOptionParser();
    	return $parser->description(__d('cake_console',
    			'The Bake script generates controllers, views and models for your application.' .
    			' If run with no command line arguments, Bake guides the user through the class creation process.' .
    			' You can customize the generation process by telling Bake where different parts of your application are using command line arguments.'
    	))->addSubcommand('all', array(
    			'help' => __d('cake_console', 'Bake a complete MVC. optional <name> of a Model'),
    	))->addSubcommand('project', array(
    			'help' => __d('cake_console', 'Bake a new app folder in the path supplied or in current directory if no path is specified'),
    			'parser' => $this->Project->getOptionParser()
    	))->addSubcommand('plugin', array(
    			'help' => __d('cake_console', 'Bake a new plugin folder in the path supplied or in current directory if no path is specified.'),
    			'parser' => $this->Plugin->getOptionParser()
    	))->addSubcommand('db_config', array(
    			'help' => __d('cake_console', 'Bake a database.php file in config directory.'),
    			'parser' => $this->DbConfig->getOptionParser()
    	))->addSubcommand('model', array(
    			'help' => __d('cake_console', 'Bake a model.'),
    			'parser' => $this->Model->getOptionParser()
    	))->addSubcommand('view', array(
    			'help' => __d('cake_console', 'Bake views for controllers.'),
    			'parser' => $this->View->getOptionParser()
    	))->addSubcommand('controller', array(
    			'help' => __d('cake_console', 'Bake a controller.'),
    			'parser' => $this->Controller->getOptionParser()
    	))->addSubcommand('fixture', array(
    			'help' => __d('cake_console', 'Bake a fixture.'),
    			'parser' => $this->Fixture->getOptionParser()
    	))->addSubcommand('test', array(
    			'help' => __d('cake_console', 'Bake a unit test.'),
    			'parser' => $this->Test->getOptionParser()
    	))->addOption('connection', array(
    			'help' => __d('cake_console', 'Database connection to use in conjunction with `bake all`.'),
    			'short' => 'c',
    			'default' => 'default'
    	));
    }
    
    }
    */
        
    public function FirstPass(){

    	if(empty($this->audioFiles)) return;
    	$this->printTitle("Creation des metadonnees xml");
    	$this->ProgressBar->start(count($this->audioFiles));
    	$dataXml = array();
    	$dataXml2 = array();
   	
    	foreach ($this->audioFiles as $mp3file){
    		$id3 = new IdTag();
    		$id3->analyze($mp3file);   
    		
			
    		/*$dataXml['AudioFiles']['Song'][] = array(
    										'filepath' => $mp3file,
    										'title' => $id3->get('title'),
    										'bpm' => $id3->get('bpm'),
    										'year' => $id3->get('year'),
    										'comment' => $id3->get("comment"),,
    										'exist' => 'Y',
    										'@artist' => $id3->get("artist"),
    										'@genre' => ucwords($id3->get("genre")),
    										//'Artist'	=> array('nom' => $id3->get('artist'))
    										);
			*/
    		$dataXml['AudioFiles']['File'][] = array('Song' => array(
    										'filepath' => $mp3file,
    										'title' => $id3->get('title'),
    										'bpm' => $id3->get('bpm') == 0 ? null : $id3->get('bpm'),
    										'year' => $id3->get('year') == 0 ? null : $id3->get('year'),
    										'comments' => $id3->get("comment"),
    										'exist' => 'Y',
    										'key'	=> $id3->get('initial_key') == 0 ? null : $id3->get('initial_key'),
    										'@artist' => $id3->get("artist"),
    										'@genre' => ucwords($id3->get("genre")),
    										'@album' => ucwords($id3->get("album")),
    										//'Artist'	=> array('nom' => $id3->get('artist'))
    											)
    										);
    		$this->ProgressBar->next();

    	}
    	
    	$xmlObject = Xml::build($dataXml); // You can use Xml::build() too
    	$xmlObject->asXML($this->firstPassFile);
    	//$xmlObject = Xml::build($dataXml2); // You can use Xml::build() too
    	//$xmlObject->asXML($this->firstPassFile."2.xml");
    	$this->out("   \n");    	
    }
	
	function scanDir($dir = null){
    	$Folder = new Folder($dir);
    	$mp3Files = $Folder->findRecursive('.*\.mp3');
    	return $mp3Files;
	}
	

	function checkWorkPath($path = null){
    	if(!$path && !$this->WorkPath) return false;
    	if($path){
    		if(is_dir($path)){
    			$this->WorkPath = $path;
    			return true;
    		}
    	}elseif($this->WorkPath){
    		if(is_dir($this->WorkPath)) return true;
    	}
    	return false;
	}	

	public function SecondPass(){
				

		$this->printTitle("Detection/Creation des genres et des artistes");
		  

		//$this->ArtistTask->parseXlm($this->firstPassFile);
		$this->ArtistTask->parseXlm2($this->firstPassFile);
		
		//$this->GenreTask->parseXlm($this->firstPassFile);
		$this->GenreTask->parseXlm2($this->firstPassFile);
		
		$this->AlbumTask->parseXlm2($this->firstPassFile);
	
	}
	
	public function ThirdPass(){
		//$this->out('Clean Genres');
		$this->printTitle("Ajout dans la DB");
		$xml = Xml::build($this->firstPassFile);
		$xmlArray = Xml::toArray($xml);
		$this->ProgressBar->start($xml->count());

		$i = 0;
		foreach($xmlArray['AudioFiles']['File'] as $data){
			$this->Song->recurssive = -1;
			$idFind = $this->Song->findByFilepath($data['Song']['filepath']);
			if($idFind == false){
				$this->Song->create();
			}
			$this->Song->id = $idFind['Song']['id'];
			$this->Song->save($data);
			$this->ProgressBar->next();
		}
		
		$this->ProgressBar->finish();
		
		
				
	}
	public function searchAudioFile($dir){
		$this->printTitle("Recherche des fichiers audio");
		$allMp3FindFiles = $this->scanDir($dir);
		if(count($allMp3FindFiles) > 0){
				
			$this->out(sprintf("Il y a \"<info>%s</info>\" fichier(s) audio a traiter.",count($allMp3FindFiles)));
			$this->hr();
			sleep(2);
			//$this->clear();
		}
		return $allMp3FindFiles;
	}
		
	public function printTitle($title = ''){
		$width = 63;
		
		if(strlen($title) == 0) return;
		
		$left = str_repeat(">", ($width-strlen($title))/2);
		
		$right = str_repeat("<", ($width-strlen($title))/2);
		
		$title = str_pad($left.$title.$right, $width, "<",STR_PAD_RIGHT);
		$this->out("");
		$this->hr();
		$this->out($title);
		$this->hr();
		
	}
	

	
	
} 