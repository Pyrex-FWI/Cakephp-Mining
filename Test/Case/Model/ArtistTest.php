<?php
App::uses('Artist', 'Mining.Model');

/**
 * Artist Test Case
 *
 */
class ArtistTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('plugin.mining.artist', 'plugin.mining.song', 'plugin.mining.genre', 'app.artists_song');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Artist = ClassRegistry::init('Artist');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Artist);

		parent::tearDown();
	}

/**
 * testCreateArtistSongIfNotExist method
 *
 * @return void
 */
	public function testCreateArtistSongIfNotExist() {

	}
/**
 * testLinkSong method
 *
 * @return void
 */
	public function testLinkSong() {

	}
/**
 * testArtistIsLinkedWithSong method
 *
 * @return void
 */
	public function testArtistIsLinkedWithSong() {

	}
/**
 * testFindArtist method
 *
 * @return void
 */
	public function testFindArtist() {

	}
/**
 * testCreateArtist method
 *
 * @return void
 */
	public function testCreateArtist() {

	}
}
