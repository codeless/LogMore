[+ AutoGen5 template php +]
<?php

require('src/LogMore.php');

/**
 * Class: LogMoreTest
 */

class LogMoreTest extends PHPUnit_Framework_TestCase {

	public function testPriorities() {[+ FOR priorities +]
		$this->assertEquals(true, LogMore::[+ name +]('Posting a [+ id +] message'));[+ 
ENDFOR priorities +]
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
				array('asdf', 'asdf', 'asdf')),
			array( 	'Some empty strings: , ,  ',
				'Some empty strings: %s, %.1s, %.2s',
				array(null, '', ' '))
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

	/**
	 * Tests, if LogMore can be opened multiple times with different ident,
	 * which should not be the case.
	 */
	public function testMultiOpen() {
		$ident = 'myident';
		LogMore::open($ident);
		LogMore::open('mynewident'); # Should raise a info-logentry!

		# Check if ident changed:
		$this->assertEquals($ident, LogMore::getIdent());

		# Close log to reopen again with new ident:
		LogMore::close();
		$new_ident = 'mynewident';
		LogMore::open($new_ident);

		# Check if ident changed:
		$this->assertEquals($new_ident, LogMore::getIdent());
	}

	public function testCounter() {
		# Close opened Loggers:
		LogMore::close();

		# Reopen
		LogMore::open('test');

		# Send some messages
		LogMore::debug('First message');
		LogMore::debug('Second message');
		LogMore::debug('Third message');

		# Control counter:
		$this->assertEquals(3, LogMore::getMessageCounter());

		# Close and reopen again: 
		LogMore::close();
		LogMore::open('anothertest');

		# Test message counter:
		LogMore::debug('First message');
		$this->assertEquals(1, LogMore::getMessageCounter());
	}

	public function testEnablingDisabling() {
		# Close opened Loggers:
		LogMore::close();

		# Reopen
		LogMore::open('test');

		# Send some messages
		LogMore::debug('First message');
		LogMore::debug('Second message');
		LogMore::debug('Third message');

		# Disable logging:
		LogMore::disable();

		# These message should get eliminated:
		LogMore::debug('First message');
		LogMore::debug('Second message');

		# Enable logging again:
		LogMore::enable();

		# Check counter:
		$this->assertEquals(3, LogMore::getMessageCounter());
	}

};
