<?php
/* Doublon Fixture generated on: 2012-01-07 01:05:23 : 1325898323 */

/**
 * DoublonFixture
 *
 */
class DoublonFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'md5' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => '', 'charset' => 'utf8'),
		'nb_songs' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 21, 'collate' => NULL, 'comment' => ''),
		'indexes' => array(),
		'tableParameters' => array()
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'md5' => 'Lorem ipsum dolor sit amet',
			'nb_songs' => 1
		),
	);
}
