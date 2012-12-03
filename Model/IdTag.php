<?php
if(!defined('GETID3_INCLUDEPATH'))
    define('GETID3_HELPERAPPSDIR',APP."vendors".DS."getid3".DS);
if(!defined('GETID3_HELPERAPPSDIR'))
define('GETID3_HELPERAPPSDIR',APP."vendors".DS."getid3".DS);
App::import('Vendor', 'Mining.getid3/getid3');
App::import('Vendor', 'Mining.getid3/getid3_id3v1', array('file'=>'module.tag.id3v1.php'));
App::import('Vendor', 'Mining.getid3/write');
App::uses('File', 'Utility');
App::uses('MiningAppModel', 'Mining.Model');
class IdTag extends MiningAppModel{
	
	public $Tag;
	public $file;
	
	var $featSep = array(
		'(f|F)eat', 
		'(f|F)eat\.' , 
		'&', '&&', 
		'(f|F)t', 
		'(f|F)t\.',
		'(v|V)s\.',
		'(v|V)s ',
		'\/');
    public  $featSepReg = "/";
    	
	public $findMd5	= false;
	
	public $applicationTag = "D:\\InterTrop\\wamp\www\\pyrex_mining\\Vendor\\Tag\\Tag.exe ";
	
	public $options = array(
		'tag_encoding'				=>	'UTF-8',
		'encoding'					=>	'UTF-8',
	);
	public $fileInfo = null;
	
	function __construct($id = false, $table=null, $ds = null){
		parent::__construct($id = false, $table = null, $ds = null);
		$this->Tag = new getID3();
        foreach($this->featSep as $sep){
	        $this->featSepReg .= "\s".$sep."\s";
	        if(end($this->featSep) == $sep) $this->featSepReg .="|,/";
	        else $this->featSepReg .="|";
        }	
        
	}
	
	function analyze($file = null){	
		if(!$file || !is_file($file)) return false;
		//$this->checkTagApp();
		$this->file = $file;
		$this->Tag->setOption($this->options);
		$this->fileInfo = $this->Tag->analyze($file);
		getid3_lib::CopyTagsToComments($this->fileInfo);
		if($this->findMd5) $this->getMd5($file);
		return $this->fileInfo;
	}
	
	function getMd5($file =null){
		if(!empty($this->fileInfo['md5'])) return $this->fileInfo['md5'];
		if(!$file){$this->fileInfo['md5']=''; return;}
		if($this->findMd5 == false) return;
		if(isset($this->fileInfo['md5']) && $this->fileInfo['md5'] !='')
			return $this->fileInfo['md5'];
		$logs =  array();
		$original = new File($file);
		$original->copy($file."_tmp");
		$exec = "";
		exec(sprintf('%s --nocheck --stdout --remove "%s" > nul',$this->applicationTag,$file."_tmp"),$logs,$exec);
		$this->fileInfo["md5"] = md5_file($file."_tmp");
		unlink($file."_tmp");
		
		return $this->fileInfo['md5'];
		
	}
	
	function checkTagApp(){
		if($this->applicationTag !="" && !is_file($this->applicationTag)){
			throw ("Erreur, votre 'Tag.exe' n'est pas accessible.");
		}
		return true;
	}
	
	public function get($tag = null){
		if(!$tag || !isset($this->fileInfo['tags']['id3v2'])) return false;
		$tag = strtolower($tag);
		
		if(in_array($tag,array_keys($this->fileInfo['tags']['id3v2']))){
			return str_replace('"',"",trim($this->fileInfo['tags']['id3v2'][$tag][0]));
		}
		if($tag == 'artists'){
			$r = array_map('ucwords', array_map('trim', preg_split($this->featSepReg,$this->get('artist'))) );
			return str_replace('"',"",trim($r));			
		}
		/*if($tag == 'TBPM' && isset($this->fileInfo['tags']['id3v2'][$tag][0]['data'])){
			return $this->fileInfo['tags']['id3v2'][$tag][0]['data'];
		}*/


		return false;
	}
}
/*
class Idtag extends AppModel {

	var $name = 'Idtag';
    var $useTable = false;
    var $Id3NameOfTag = array('title','artists','artist','album','year','track','genre','bpm','genre','length');
    var $TagObj = null;
    var $Alltags;
    var $FieldSongs = array();
    var $TagSong = array();
    var $TaggingFormat = 'UTF-8';
    var $Data= array();
    var $file = null;
    var $featSep = array('feat', '&', '&&', 'ft', 'ft\.', 'feat\.','Vs\.',',');
    var $featSepReg = "/";
    //var $TaggingFormat = 'ISO-8859-1';
        
    function clean(){
        $this->TagObj= null;
        $this->Alltags =null;
        $this->TagSong = null;
    }
    function __construct($file = null){
        parent::__construct($id = false, $table = null, $ds = null);
        $this->file=$file;
        
        foreach($this->featSep as $sep){
        	$this->featSepReg .= "\s$sep\s";
        	if(end($this->featSep) == $sep) $this->featSepReg .="/";
        	else $this->featSepReg .="|";
        }
    }
    function loadFromFile($file = null){
        $this->file=$file;
        $this->TagObj = &new getID3();
        $this->TagObj->analyze($file);
        return $this->TagObj;
    }
    
    function getData(){
        
        if(is_array($this->Data) && count($this->Data)>2)
            return $this->Data;
                    
        $dataPart = array( 
       
            @$this->TagObj->info['tags']['id3v1'],
            @$this->TagObj->info['tags']['id3v2'],
            //@$this->TagObj->info['id3v2']['comments'],
            //@$this->TagObj->info['id3v1']['comments']
            );
            $tmp = array();
            
            foreach($dataPart as $d){
                //echo "<br/>----#DATA<br/>";
                if(!is_array($d)) continue;
                $Keys = array_keys($d);
                foreach($Keys as $k){
                    if(!key_exists($k,$tmp)){
                        $tmp[$k] = $d[$k][0];
                    }else{
                        if($tmp[$k] =='' && $d[$k][0] !=''){
                            $tmp[$k] = $d[$k][0];    
                        }
                    }
                }    
            }
            $tmp['playtimestring'] = @$this->TagObj->info['playtime_seconds'];
            $tmp['bitrate_mode'] = @$this->TagObj->info['audio']['bitrate_mode'];
            $tmp['sample_rate'] = @$this->TagObj->info['audio']['sample_rate'];
            
            $this->Data = &$tmp;
            unset($Keys);
            return $tmp;
    }
    
    function get($field = null){
        if($field == null) return;
        $d = $this->getData();
        
        if(array_key_exists($field,$d) || ($field == "artists" && array_key_exists('artist',$d)) ){
        	switch ($field){
        		case 'artists' :
        			
        			return array_map('ucwords', preg_split($this->featSepReg,strtolower($d['artist'])) );

        			break;
        		default:
        			return $d[$field];
        			break;
        		
        	}
            
        }
    }
    

    function _prepareWrite()
    {
  		$this->tagwriter                    = new getid3_writetags;
		$this->tagwriter->filename          = $this->Alltags['filenamepath'];
        $this->tagwriter->tag_encoding      = $this->TaggingFormat;
        $this->tagwriter->option_md5_data   = true;
        $this->tagwriter->overwrite_tags    = true;
        $this->tagwriter->remove_other_tags = false;
        $this->tagwriter->tagformats        = array('id3v1','id3v2.3','id3v2.4');  
        $this->tag_data                     = array(array());      
        $this->ReadyToWrite                 = true;
        //$this->TagData['artist'][]="Patrice";
        //$this->TagData['title'][]="Hulman";
        
        //debug($this->Alltags);


    }
    
    function set($tag,$val)
    {
        if(!$this->ReadyToWrite)
            $this->_prepareWrite();
            
            $this->TagData[$tag][] = $val;
    }
    
    function save()
    {

        if(!$this->ReadyToWrite)
            $this->_prepareWrite();
        $this->tagwriter->tag_data = $this->TagData;
        
		if ($this->tagwriter->WriteTags()) {
			echo 'Successfully wrote tags<BR>';
            return true;
			if (!empty($this->tagwriter->warnings)) {
				echo 'There were some warnings:<BLOCKQUOTE STYLE="background-color:#FFCC33; padding: 10px;">'.implode('<BR><BR>', $this->tagwriter->warnings).'</BLOCKQUOTE>';
			}
		} else {
			echo 'Failed to write tags!<BLOCKQUOTE STYLE="background-color:#FF9999; padding: 10px;">'.implode('<BR><BR>', $this->tagwriter->errors).'</BLOCKQUOTE>';
		}
    }
 
    
}

*/?>