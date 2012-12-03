<?php
/* Occurrence Test cases generated on: 2012-01-01 20:07:59 : 1325448479*/
App::uses('Occurrence', 'Model');

/**
 * Occurrence Test Case
 *
 */
class OccurrenceTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.occurrence', 'app.song', 'app.occurrences_song');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Occurrence = ClassRegistry::init('Occurrence');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Occurrence);

		parent::tearDown();
	}

}
