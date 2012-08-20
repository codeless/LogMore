[+ AutoGen5 template php +]
<?php

require('src/logmore.php');

/**
 * Class: LogMoreTest
 */

class LogMoreTest extends PHPUnit_Framework_TestCase {

	public function testPriorities() {
[+ FOR priorities +]$this->assertEquals(true, LogMore::[+ name +]('Posting a [+ id +] message'));
[+ ENDFOR priorities +]
	}

	/**
	 * Data provider for testFormating()
	 */
	public function providerFormatings() {
		return array(
			array( 	'Some numbers: 1, 0.1, 0.11',
				'Some numbers: %d, %.1f, %.2f',
				array(1, 0.11, 0.111)),
			array( 	'Some strings: asdf, a, as',
				'Some strings: %s, %.1s, %.2s',
				array('asdf', 'asdf', 'asdf'))
		);
	}

	/**
	 * Checks for correct formating
	 *
	 * @dataProvider providerFormatings
	 */
	public function testFormating($result, $message, $args) {
		# Testing the formating capabilites:
		$this->assertEquals($result, LogMore::format($message, $args));
	}

};
