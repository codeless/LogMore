<?php
/*
Title: License

LogMore is available under the ISC license:

Copyright (c) 2012 by Manuel Hiptmair <more@codeless.at>

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted, provided that the above
copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
*/




/**
 * Class: LogMoreBase
 */
abstract class LogMoreBase {

	/**
	 * Function: add
	 *
	 * Adds a message to the log.
	 *
	 * Parameters:
	 *
	 * 	$priority - Priority value of the message to log
	 * 	$data - An array holding the message on index 0;
	 * 		additional arguments can follow and will
	 * 		be used to format the message using vsprintf
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	private static function add($priority, $data) {
		# Get the message:
		$message = array_shift($data);

		# Format message:
		$formated_message = self::format($message, $data);

		# Write to log:
		return syslog($priority, $formated_message);
	}


	/**
	 * Function: format
	 *
	 * Formats a message and returns it.
	 *
	 * Parameters:
	 *
	 * 	$message - The message to format
	 * 	$args - Arguments for vsprintf in an array
	 *
	 * Returns:
	 *
	 * 	The formated message.
	 */
	public static function format($message, $args) {
		# Format message
		# Only neccessary if additional arguments were passed.
		# To allow NULL-arguments also, the usage of sizeof()
		# over iset() is favored:
		$formated_message = (sizeof($args))
			? vsprintf($message, $args)
			: $message;

		return $formated_message;
	}


	/**
	 * Function: emerg
	 *
	 * system is unusable
	 *
	 * Parameters:
	 *
	 * 	$message - The message to log, can be a format
	 * 		string which is passed to sprintf.
	 * 	$args - Arguments for vsprintf
	 * 	$... - ...
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	public static function emerg() {
		# Get arguments to this function:
		$args = func_get_args();

		# Add message to log:
		return self::add(LOG_EMERG, $args);
	}

	/**
	 * Function: alert
	 *
	 * action must be taken immediately
	 *
	 * Parameters:
	 *
	 * 	$message - The message to log, can be a format
	 * 		string which is passed to sprintf.
	 * 	$args - Arguments for vsprintf
	 * 	$... - ...
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	public static function alert() {
		# Get arguments to this function:
		$args = func_get_args();

		# Add message to log:
		return self::add(LOG_ALERT, $args);
	}

	/**
	 * Function: crit
	 *
	 * critical conditions
	 *
	 * Parameters:
	 *
	 * 	$message - The message to log, can be a format
	 * 		string which is passed to sprintf.
	 * 	$args - Arguments for vsprintf
	 * 	$... - ...
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	public static function crit() {
		# Get arguments to this function:
		$args = func_get_args();

		# Add message to log:
		return self::add(LOG_CRIT, $args);
	}

	/**
	 * Function: err
	 *
	 * error conditions
	 *
	 * Parameters:
	 *
	 * 	$message - The message to log, can be a format
	 * 		string which is passed to sprintf.
	 * 	$args - Arguments for vsprintf
	 * 	$... - ...
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	public static function err() {
		# Get arguments to this function:
		$args = func_get_args();

		# Add message to log:
		return self::add(LOG_ERR, $args);
	}

	/**
	 * Function: warning
	 *
	 * warning conditions
	 *
	 * Parameters:
	 *
	 * 	$message - The message to log, can be a format
	 * 		string which is passed to sprintf.
	 * 	$args - Arguments for vsprintf
	 * 	$... - ...
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	public static function warning() {
		# Get arguments to this function:
		$args = func_get_args();

		# Add message to log:
		return self::add(LOG_WARNING, $args);
	}

	/**
	 * Function: notice
	 *
	 * normal, but significant, condition
	 *
	 * Parameters:
	 *
	 * 	$message - The message to log, can be a format
	 * 		string which is passed to sprintf.
	 * 	$args - Arguments for vsprintf
	 * 	$... - ...
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	public static function notice() {
		# Get arguments to this function:
		$args = func_get_args();

		# Add message to log:
		return self::add(LOG_NOTICE, $args);
	}

	/**
	 * Function: info
	 *
	 * informational message
	 *
	 * Parameters:
	 *
	 * 	$message - The message to log, can be a format
	 * 		string which is passed to sprintf.
	 * 	$args - Arguments for vsprintf
	 * 	$... - ...
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	public static function info() {
		# Get arguments to this function:
		$args = func_get_args();

		# Add message to log:
		return self::add(LOG_INFO, $args);
	}

	/**
	 * Function: debug
	 *
	 * debug-level message
	 *
	 * Parameters:
	 *
	 * 	$message - The message to log, can be a format
	 * 		string which is passed to sprintf.
	 * 	$args - Arguments for vsprintf
	 * 	$... - ...
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	public static function debug() {
		# Get arguments to this function:
		$args = func_get_args();

		# Add message to log:
		return self::add(LOG_DEBUG, $args);
	}

};
/**
 * Class: LogMore
 */
class LogMore extends LogMoreBase {

	private static $ident;

	/**
	 * Function: open
	 *
	 * Calling this static method is optional, but recommended.
	 * By passing an ident-string to this method, the systems
	 * logging daemon is able to filter the following messages
	 * easily.
	 * For a detailed information please consult the official
	 * PHP manual, Chapter "Function Reference", "Other Services",
	 * "Network" extension.
	 *
	 * Parameters:
	 * 	$ident - An identification string for the application 
	 * 		that uses LogMore
	 * 	$option - Indicator for logging options
	 * 		Default: LOG_PID | LOG_PERROR
	 * 	$facility - Logging facility
	 * 		Default: LOG_USER
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 *
	 * See also:
	 *
	 * 	<close>
	 */
	public static function open(
		$ident,
		$option=null,
		$facility=null)
	{
		# If log has already been opened
		if (self::$ident) {
			LogMore::info(
				'Ignoring attempt to open log for ident %s',
				$ident);
			$rc = false;
		} else {
			# Set defaults:
			if (!isset($option)) {
				$option = LOG_PID | LOG_PERROR;
			}
			if (!isset($facility)) {
				$facility = LOG_USER;
			}

			if (!$rc = openlog($ident, $option, $facility)) {
				trigger_error('Failed to open log', E_USER_ERROR);
			}

			# Store ident for future calls of LogMore::open():
			self::$ident = $ident;
		}

		return $rc;
	}

	/**
	 * Function: close
	 *
	 * Like open(), the use of close() is optional.
	 *
	 * Returns:
	 *
	 * 	true - on success
	 * 	false - on failure
	 */
	public static function close() {
		if (!$rc = closelog()) {
			trigger_error('Failed to close log', E_USER_ERROR);
		} else {
			# Delete ident:
			self::$ident = null;
		}

		return $rc;
	}


	public static function getIdent() { return self::$ident; }

};
