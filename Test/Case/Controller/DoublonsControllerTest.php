<?php
/* Doublons Test cases generated on: 2012-01-11 18:49:36 : 1326307776*/
App::uses('DoublonsController', 'Controller');

/**
 * TestDoublonsController *
 */
class TestDoublonsController extends DoublonsController {
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
 * DoublonsController Test Case
 *
 */
class DoublonsControllerTestCase extends CakeTestCase {
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

		$this->Doublons = new TestDoublonsController();
		$this->Doublons->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Doublons);

		parent::tearDown();
	}

}
