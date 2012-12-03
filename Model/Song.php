<?php
App::uses('MiningAppModel', 'Mining.Model');
/**
 * Song Model
 *
 * @property Artist $Artist
 * @property Occurrence $Occurrence
 */
class Song extends MiningAppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	public $order = array('Song.created'=>'desc');
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/*public $filterArgs = array(
			'title'=>array('type'=>'like'),

			);*/
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Artist' => array(
			'className' => 'Mining.Artist',
			'joinTable' => 'artists_songs',
			'foreignKey' => 'song_id',
			'associationForeignKey' => 'artist_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	public $belongsTo = array(
		'Genre' => array(
			'className' => 'Mining.Genre',
			'foreignKey' => 'genre_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Album' => array(
			'className' => 'Mining.Album',
			'foreignKey' => 'album_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);	
	
	/*public $hasOne = array(
		'Doublon'=>array(
			'className'	=>	'Doublon',
			'foreignKey'	=>'md5'
	)
	);*/
	
	public $actsAs = array('Search.Searchable');	
	
	
	public function findSong(Idtag $id3,$type="filePath"){
		$count = 0;
		$find = false;
		
		switch ($type) {
			case "filePath":
				$count = $this->find('count',array('conditions'=>array("filepath"=>$id3->file)));
				if($count == 1){
					$this->data = $this->find('first', array(
						'conditions' => array($this->alias . '.filepath' => $id3->file)
					));	
					$this->id = $this->data[$this->alias][$this->primaryKey];
					$find = true;			
				}
			;
			break;
			case "md5_filepath":
				$count = $this->find('count',array('conditions'=>array("md5_filepath"=>md5($id3->file))));
				if($count == 1){
					$this->data = $this->find('first', array(
						'conditions' => array("md5_filepath"=>md5($id3->file))
					));	
					$this->id = $this->data[$this->alias][$this->primaryKey];
					$find = true;			
				}
			;
			break;
			case "md5":
				$oldfindMd5 = $id3->findMd5; $id3->findMd5 = true;
				if($this->find('first',array('conditions'=>array($this->alias.".md5"=>$id3->getMd5($id3->file))))){
					$this->data = $this->find('first', array(
						'conditions' => array($this->alias . '.md5' => $id3->getMd5($id3->file))
					));	
					$this->id = $this->data[$this->alias][$this->primaryKey];
					$find = true;						
				}
				$id3->findMd5 = $oldfindMd5;
			default:
				;
			break;
		}
		
		return $find;
		
	}
	
	public function createSong(Idtag $id3){
		$path = substr($id3->file, 0,strrpos($id3->file,DS));
		$fileName = substr($id3->file,(strrpos($id3->file,DS)+1));		
		$this->create();
		$this->set("filename",$fileName);
		$this->set("md5",$id3->getMd5($id3->file));
		$this->set("md5_filepath",md5($id3->file));
		return $this->updateSongInfo($id3);					
	}

	public function updateFileName(){

		if($this->find('count',array('conditions'=>array('Song.filepath like'=>'%//%'))) > 0){
			
			$this->updateAll(
					array("Song.filename" => "REPLACE(Song.filepath,'//','/')")
					,array('Song.filepath like'=>'%//%')
			);
				
		}
		
		return $this->updateAll(
			array("Song.filename" => "substring(Song.filepath, (length(Song.filepath) - locate('/',reverse(Song.filepath)) + 2))")
			,array('NOT'=> array("Song.id"=>null))
				);	
	}	
	
	function findCorrelation($id =null){
		if(!$id){
			if($this->id == false){
				return array();
			}
		}else{
			$this->id = $id;
		}
		
		$this->recursive = 1;
		$master = ($this->read());
		$max = ($master['Song']['bpm']+(($master['Song']['bpm']*8)/100));
		$min = ($master['Song']['bpm']-(($master['Song']['bpm']*8)/100));

		//debug($this->getNeighbourKeys("01B","prev"));
		//$this->getNeighbourKeys("02A",'next');
		$fields = array('Interprete.name','Song.title','Song.id','Song.key','Song.bpm','Song.year','Genre.name', '((Song.bpm*100)/'.$master['Song']['bpm'].')-100 as percent_scale');
		$conditions = array(
							'Song.id <> '.$this->id,
							'Song.key' => array($master['Song']['key']), 
							"Song.bpm BETWEEN ? and ?" => array($min,$max) ,
							'Song.genre_id' => $master['Song']['genre_id'], 
							'Song.year BETWEEN ? and ?' => array($master['Song']['year']-2,$master['Song']['year']+2) ,
							'Song.comments like' => '%radio%'
								);

		if($master['Song']['year'] == 0) unset($conditions['Song.year BETWEEN ? and ?']);

		if($this->getNeighbourKeys($master['Song']['key'],'prev') !== false){
			$conditions['Song.key'][] = $this->getNeighbourKeys($master['Song']['key'],'prev');
		}		
		
		if($this->getNeighbourKeys($master['Song']['key'],'next') !== false){
			$conditions['Song.key'][] = $this->getNeighbourKeys($master['Song']['key'],'next');
		}		
		
		$others['Radio'] =$this->find('all',array(
				'fields'=>$fields,
				'conditions' => $conditions,
				'recursive'=>0,
				'order'=>array('Song.key ASC')
				));
		

		/* ===================================================== */
		$conditions = array(
							'Song.id <> '.$this->id,
							'Song.key' => array($master['Song']['key']), 
							"Song.bpm BETWEEN ? and ?" => array($min,$max) ,
							'Song.genre_id' => $master['Song']['genre_id'], 
							'Song.year BETWEEN ? and ?' => array($master['Song']['year']-2,$master['Song']['year']+2) ,
							array("AND" =>array('Song.comments like' => '%hot%','Song.comments not like' => '%radio%'))
								);

		if($this->getNeighbourKeys($master['Song']['key'],'prev') !== false){
			$conditions['Song.key'][] = $this->getNeighbourKeys($master['Song']['key'],'prev');
		}
		
		if($this->getNeighbourKeys($master['Song']['key'],'next') !== false){
			$conditions['Song.key'][] = $this->getNeighbourKeys($master['Song']['key'],'next');
		}
				
		$others['HotOnly'] =$this->find('all',array(
				'fields'=>$fields,
				'conditions' => $conditions,
				'recursive'=>0
				));
		
		return ($others);
	}
	
	public function chromatiqueKeys(){
		$letters = array('A','B');
		$numbers = array('01','02','03','04','05','06','07','08','09','10','11','12');
		$keysCombinaison = array();
		foreach($letters as $letter){
			foreach($numbers as $number){
				$keysCombinaison[] = $number.$letter;
			}
		}
		return $keysCombinaison;
	}
	
	public function getNeighbourKeys($key = null, $dir='prev'){
		if(is_null($key) || in_array($key,array('0'))){
			return false;
		}
		$chromatiqueKeys = $this->chromatiqueKeys();
		
		
		if(strpos($key, "A")){
			$chromatiqueKeys = array_slice($chromatiqueKeys, 0, count($chromatiqueKeys)/2);
		}else{
			$chromatiqueKeys = array_slice($chromatiqueKeys, count($chromatiqueKeys)/2 );
		}
		$end = end($chromatiqueKeys);
		reset($chromatiqueKeys);

		
		do{
			$r  = null;
			if(current($chromatiqueKeys) == $key){			
				if($dir == "next"){
					$r = next($chromatiqueKeys);
					prev($chromatiqueKeys);
					if($r == false){
						reset($chromatiqueKeys);
						$r = current($chromatiqueKeys);
					}
				}
				else{
					$r= prev($chromatiqueKeys);
					next($chromatiqueKeys);
					if($r == false){
						$r = end($chromatiqueKeys);
					}
				}	
				return $r;
					

			}
		}while(next($chromatiqueKeys));		
	}
	
	public function deleteObseleteFiles(){
		$this->deleteAll(array('OR'=>array('Song.filename'=>'0000_separator_0000.mp3', 'Song.filepath like'=>'%0000_separator_0000.mp3')));
		$this->deleteAll(array('Song.filename like'=>'.%'));
	}
}
