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
		}

		return $rc;
	}

};
