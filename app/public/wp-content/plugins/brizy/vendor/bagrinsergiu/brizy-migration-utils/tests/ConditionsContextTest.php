<?php

namespace Brizy;


use PHPUnit\Framework\TestCase;

class ConditionsContextTest extends TestCase {

	public function testGetGlobalBlocks() {
		$o = new ConditionsContext([]);
		$global_blocks = (object) [];
		$o->setGlobalBlocks( $global_blocks );

		$this->assertEquals($global_blocks,$o->getGlobalBlocks(),'It should return the correct global blocks');
	}

	public function testSetConfig() {
		$o = new ConditionsContext([]);
		$config = (object) [];
		$o->setConfig( $config );

		$this->assertEquals($config,$o->getConfig(),'It should return the correct config value');
	}
}
