<?php

namespace Brizy\Utils;

use PHPUnit\Framework\TestCase;

class UUIdTest extends TestCase {

	public function testUuid() {
		$uniqueValues = [
			UUId::uuid(32),
			UUId::uuid(32),
			UUId::uuid(32),
			UUId::uuid(32),
			UUId::uuid(32),
			UUId::uuid(32),
			UUId::uuid(32),
		];

		foreach($uniqueValues as $val) {
			$this->assertEquals( 32, strlen($val), 'The values should be 32 char long' );
		}

		$filteredUniqueValues = array_unique($uniqueValues);
		$diff = array_diff($uniqueValues, $filteredUniqueValues);

		$this->assertCount(0,$diff,'There should not generate duplicate values');
	}
}
