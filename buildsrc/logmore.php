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

			# Reset counter:
			self::$messageCounter = 0;
		}

		return $rc;
	}

	public static function getIdent() { return self::$ident; }

};
