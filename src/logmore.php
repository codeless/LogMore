<?php

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
		# only neccessary if additional arguments were passed:
		$formated_message = (isset($args[0]))
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
		return self::add(LOG_EMERG, func_get_args());
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
		return self::add(LOG_ALERT, func_get_args());
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
		return self::add(LOG_CRIT, func_get_args());
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
		return self::add(LOG_ERR, func_get_args());
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
		return self::add(LOG_WARNING, func_get_args());
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
		return self::add(LOG_NOTICE, func_get_args());
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
		return self::add(LOG_INFO, func_get_args());
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
		return self::add(LOG_DEBUG, func_get_args());
	}

};
/**
 * Class: LogMore
 */
class LogMore extends LogMoreBase {

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
	 * 	$facility - Logging facility
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
		$option=LOG_PID,
		$facility=LOG_USER)
	{
		if (!$rc = openlog($ident, $option, $facility)) {
			trigger_error(E_USER_ERROR, 'Failed to open log');
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
			trigger_error(E_USER_ERROR, 'Failed to close log');
		}

		return $rc;
	}

};
