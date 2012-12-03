<?php
/* Genre Test cases generated on: 2012-01-22 15:46:26 : 1327247186*/
App::uses('Genre', 'Model');

/**
 * Genre Test Case
 *
 */
class GenreTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.genre', 'app.song', 'app.artist', 'app.artists_song');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Genre = ClassRegistry::init('Genre');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Genre);

		parent::tearDown();
	}

}
