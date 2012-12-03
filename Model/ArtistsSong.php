<?php
App::uses('MiningAppModel', 'Mining.Model');
/**
 * ArtistsSong Model
 *
 * @property Arstit $Arstit
 * @property Song $Song
 */
class ArtistsSong extends MiningAppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Arstit' => array(
			'className' => 'Mining.Arstit',
			'foreignKey' => 'arstit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Song' => array(
			'className' => 'Mining.Song',
			'foreignKey' => 'song_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
