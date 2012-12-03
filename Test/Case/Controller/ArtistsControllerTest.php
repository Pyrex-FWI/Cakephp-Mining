<?php
/* Artists Test cases generated on: 2012-01-21 15:13:11 : 1327158791*/
App::uses('ArtistsController', 'Controller');

/**
 * TestArtistsController *
 */
class TestArtistsController extends ArtistsController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * ArtistsController Test Case
 *
 */
class ArtistsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.artist', 'app.song', 'app.artists_song');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Artists = new TestArtistsController();
		$this->Artists->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Artists);

		parent::tearDown();
	}

}
