<?php
App::uses('ColGridHelper', 'Mining.View/Helper');
App::uses('View','View');
/**
 * ColGridHelper Test Case
 *
 */
class ColGridHelperTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->ColGrid = new ColGridHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ColGrid);

		parent::tearDown();
	}

/**
 * testGetColGrid method
 *
 * @return void
 */
	public function testGetColGrid() {
		$except = array('song.id','song.title','song.genre_id','song.filename','song.artist_id');
		//debug($this->ColGrid->getColGrid());
		$this->assertEquals($except,$this->ColGrid->getColGrid());
	}
/**
 * testPrintColGridChoose method
 *
 * @return void
 */
	public function testPrintColGridChoose() {

	}
/**
 * testPrintColGridChooseTable method
 *
 * @return void
 */
	public function testPrintColGridChooseTable() {

	}
}
