<?php
/* Doublon Test cases generated on: 2012-01-07 01:05:23 : 1325898323*/
App::uses('Doublon', 'Model');

/**
 * Doublon Test Case
 *
 */
class DoublonTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.doublon', 'app.song', 'app.artist', 'app.artists_song');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Doublon = ClassRegistry::init('Doublon');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Doublon);

		parent::tearDown();
	}

}
