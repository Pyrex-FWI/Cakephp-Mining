<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class UpdateShell extends AppShell {
	
	public $file = "D:\DBS\db.files.txt";
	public $data= array();
	public $uses = array('Song','Idtag','Artist');
	//public $WorkPath = "D:\DBS\Soul";
	public $WorkPath = "D:\DBS";
    public function main() {
        $this->parseLocalDbFile();
        foreach($this->data as $l =>&$data){
        	$this->storeInfoOccurrence(&$data);
        	$this->out(sprintf("line '%d' ok.",$l));	
        }
        //$this->out(print_r($this->data));
    }
    
    public function parseLocalDbFile(){
    	foreach(file("D:\DBS\db.files.txt",FILE_IGNORE_NEW_LINES) as $line => $data){
			$data = explode(";", $data);
			if(is_file($data[0]) ===false) continue;
			$this->data[] = array(
				"pathFile"=>$data[0],
				"md5Path"=> $data[1],
				"md5FileWithoutId3"=>$data[2],
				//"fileExist"	=> is_file($data[0])
			);
		}    	
    }
	public function storeInfoOccurrence($data){

			$id3 = new Idtag();
			$id3->findMd5 = false;
			$id3->analyze($data['pathFile']);
			$id3->fileInfo['md5'] = $data['md5FileWithoutId3'];
			$this->out(print_r($id3->fileInfo));

			//Create Occurence Entry
			if($this->Song->findSong($id3,'md5_filepath')){
				$this->Song->updateSongInfo($id3);
				$this->out(sprintf("Update '%s' ok.",$data['pathFile']));	
		
			}else{
				$this->Song->createSong($id3);
				$this->Artist->createArtistSongIfNotExist($id3,$this->Song);
			}
			
	
	}


}
	