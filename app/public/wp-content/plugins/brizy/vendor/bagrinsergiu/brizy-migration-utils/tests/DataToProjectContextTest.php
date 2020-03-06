<?php

namespace Brizy;


use PHPUnit\Framework\TestCase;

class DataToProjectContextTest extends TestCase {

	public function test__construct() {
		$globals = (object)[];
		$buildPath = "/path";

		$o = new DataToProjectContext($globals,$buildPath);

		$this->assertEquals($globals,$o->getData(), 'It should return the valid value for data');
		$this->assertEquals($buildPath,$o->getBuildPath(), 'It should return the valid value for path');
	}

	public function testSetBuildPath() {
		$globals = (object)[];
		$buildPath = "/path";
		$secondBuildPath = "/path";

		$o = new DataToProjectContext($globals,$buildPath);
		$o->setBuildPath( $secondBuildPath );

		$this->assertEquals($secondBuildPath,$o->getBuildPath(), 'It should return the valid value for path');
	}
}
