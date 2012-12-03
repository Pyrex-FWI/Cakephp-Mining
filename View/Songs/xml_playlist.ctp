<?php
/**********************************************************
 * BUILD XML ARRAY
 **********************************************************/
$xmlArraytrack= array();
foreach($songs as $song){
	$artists = Set::classicExtract($song,"Artist.{n}.name");
	$artists = (implode(', ', $artists));	
	$xmlArraytrack[] = array(
		'location'	=> 	Router::url("/player/players/play/".$song['Song']['id']),
		//'album'		=>	ucwords((utf8_encode(strtolower($artists)))),
		'title'		=>ucwords((utf8_encode(strtolower($artists)))).' - '.ucfirst(utf8_encode(strtolower(($song['Song']['title'])))),	
		'creator'	=>'',
		'annotation'=>'',
		'duration'	=>'',
		'image'		=>'',
		'info'		=>'',
		'link'		=>''
	
	);
}

$xmlArray = array(
				"playlist"=>	array(
									'@version'	=>1,
									'@xmlns'	=>"http://xspf.org/ns/0/",
									'trackList'=>	array('track'=>$xmlArraytrack)
												
								)

				);
$xmlObject = Xml::fromArray($xmlArray);
$xmlString = $xmlObject->asXML();
echo $xmlString;
?>
<?php //debug($songs)?>
