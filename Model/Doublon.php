<?php
App::uses('MiningAppModel', 'Mining.Model');
/**
 * Doublon Model
 *
 * @property Song $Song
 */
class Doublon extends MiningAppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'md5';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'md5';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
/*
 * select `songs`.`md5` AS `md5`,count(`songs`.`md5`) AS `nb_songs` from `songs` group by `songs`.`md5` having (count(`songs`.`md5`) > 1)
 * 
 */
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Song' => array(
			'className' => 'Mining.Song',
			'foreignKey' => 'md5',
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

}
