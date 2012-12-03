<?php
App::uses('MiningAppModel', 'Mining.Model');
/**
 * Artist Model
 *
 * @property Song $Song
 */
class Artist extends MiningAppModel {
/**
 * Display field
 *
 * @var string
 * 
 */
	//public $useTable = 'arstits';
	public $displayField = 'name';
	public $order = 'name ASC';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Song' => array(
			'className' => 'Mining.Song',
			'joinTable' => 'artists_songs',
			'foreignKey' => 'artist_id',
			'associationForeignKey' => 'song_id',
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

	
		public function createArtistSongIfNotExist(Idtag $id3, Song $Song){
			$artists = $id3->get('artists');
			//print_r($artists);
			
			if(!empty($artists)){
				foreach ($artists as $artist){
					//echo "recherche de l'artist:".$artist."\n";
					if(!$this->findArtist($artist))
						$this->createArtist($artist,$Song->id);
					//check link between artist and song
					if(!$this->artistIsLinkedWithSong($this->id,$Song->id)){
						$this->linkSong($Song->id,$this->id);
					}
				}
			}
			//die();
		}
		
		public function linkSong($id_song,$id){
			if(!$id) $id = $this->id;
			//echo sprintf("creation du lien entre le son '%d' et l'artiste '%d'\n",$id_song,$id);
			return $this->save(array(
				$this->alias 	=> 	array("id"=>$id),
				"Song"			=>	array("id"=>$id_song)
			));		}
		
		public function artistIsLinkedWithSong($id,$id_song){
			$this->bindModel(array(
			'hasOne' => array(        
										'ArtistsSong'/* => array(
										'conditions'=>array('Artist.id'=>"ArtistsSong.artist_id")
											)*/)
									));			
			$count = $this->find('all', array('conditions'=> array($this->alias.".id"	=>$id,"ArtistsSong.song_id"=>$id_song)
				));
				//echo sprintf("Recherche de lien\n");
				//print_r($count);
				return (count($count) >= 1)?true:false;
		}
		
		public function findArtist($artist){
			$c = $this->find('count',array('conditions'=>array('name'=>$artist),'recursive' => -1));
			if($c == 1){
				$this->data = $this->find('first', array(
					'conditions' => array($this->alias . '.name' => $artist)
				));	
				$this->id = $this->data[$this->alias][$this->primaryKey];
				//echo sprintf("artist '%s' trouve id:%d \n",$artist, $this->id);				
				return true;
			}else{
				//echo sprintf("artist '%s' NON trouve\n",$artist, $this->id);
				$this->id = null;
				return false;
			} 	
		}	
			
		public function createArtist($name,$id_song_link =null){
			$this->create();
			$data[$this->alias] = array('name'=>substr($name,0,50));
			if($id_song_link)
				$data["Song"] = array('id'=>$id_song_link);
				
			return $this->save($data);
		}
		
}
