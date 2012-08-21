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
