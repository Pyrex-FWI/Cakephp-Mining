<?php

App::uses('AppHelper', 'Mining.View');
App::uses('ClassRegistry', 'Utility');
App::uses('Sanitize', 'Utility');

class SongDetailsHelper extends AppHelper {
	
	var $helpers = array('Text','Form','Js'=>array('Jquery'));
	
	public function extendRowLinks($songData){
		$html = sprintf("<a id=\"show_%s\" class=\"extendLink\" onclick=\"addTab(this.href,'%s','%s'); return false;\" href=\"".Router::url(array('action'=>'rowDetails',$songData['Song']['id']))."\"><i class=\"icon-plus\"></i></a>",
							$songData['Song']['id'],
							Sanitize::escape($this->Text->truncate($songData['Interprete']['name']." - ".$songData['Song']['title'],15)),
							Sanitize::escape($songData['Interprete']['name']." - ".$songData['Song']['title'])
				);
		$html .= "<a id=\"hide_".$songData['Song']['id']."\" class=\"retractLink hide\" onclick=\"RetractRow(this); return false;\" href=\"#\" ><i class=\"icon-minus\"></i></a>";
		return $html;
	}
	

	
}