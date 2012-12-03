<?php
/* Song Test cases generated on: 2012-01-03 00:13:38 : 1325549618*/
App::uses('Song', 'Model');

/**
 * Song Test Case
 *
 */
class SongTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.song', 'app.artist', 'app.artists_song', 'app.occurrence', 'app.occurrences_song');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Song = ClassRegistry::init('Song');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Song);

		parent::tearDown();
	}

}
