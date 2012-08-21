[+ AutoGen5 template php +]
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

[+ FOR priorities +]
	/**
	 * Function: [+ name +]
	 *
	 * [+ description +]
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
	public static function [+ name +]() {
		# Get arguments to this function:
		$args = func_get_args();

		# Add message to log:
		return self::add([+ id +], $args);
	}
[+ ENDFOR priorities +]
};
