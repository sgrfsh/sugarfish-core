<?php
/**
 * File : CustomException.class.php
 * Created on: Sun Aug 1 23:55 CDT 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name CustomException
 */

class CustomException extends Exception {
	public static $strMessage;
	public static $intErrorNumber;

	protected static $strConsoleOutput;
	protected static $strErrorLogOutput;

	public function __construct($intErrorNumber = 0, $strMessage) {
		self::$strMessage = $strMessage;
		self::$intErrorNumber = $intErrorNumber;
		$this->CheckForProgrammerError();
	}

	private function CheckForProgrammerError() {
		self::$strMessage = sprintf('<strong>%s.</strong>', self::$strMessage);

		// instantiate the Exception class
		parent::__construct(self::$strMessage, self::$intErrorNumber);

		self::$strErrorLogOutput = sprintf(
			'<div style="font-family:Arial,Helvetica,sans-serif;background-color:#fff;color:#f00">
				%s<br />
				Stack Trace:
				<pre style="background-color:pink;margin:5px 0 0 0">%s</pre>
				<span style="font-size:11px">[%s]</span>
			</div>',
			$this->getMessage(),
			$this->getTraceAsString(),
			Application::$RemoteAddress
		);

		Application::Log(self::$strErrorLogOutput);

		$strOS = array_key_exists('OS', $_SERVER)?sprintf('<b>Operating System:</b> %s', $_SERVER['OS']):'';
		self::$strConsoleOutput = sprintf(
			'<div style="position:absolute;left:0;top:0;width:100%%;z-index:10000;font-family:Arial,Helvetica,sans-serif;font-size:10pt">
				<table border="0" cellspacing="0" width="100%%">
					<tr>
						<td nowrap="nowrap" style="background-color:#464;color:#fff;padding:10px 0 10px 10px;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;font-weight:bold;width:70%%;vertical-align:top">SFc Development Framework %s<br /><span style="font-size:18px;color:#fff">Error Report</span></td>
						<td nowrap="nowrap" style="background-color:#464;color:#fff;padding:10px 10px 10px 0;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;width:30%%;vertical-align:top;text-align:right">
							<b>PHP Version:</b> %s;&nbsp;&nbsp;<b>Zend Engine Version:</b> %s;<br />
							%s&nbsp;&nbsp;<b>Application:</b> %s;&nbsp;&nbsp;<b>Server Name:</b> %s
						</td>
					</tr>
				</table>
				<div style="padding:5px;background-color:#fff;color:#f00">
					<p style="padding:0;font-family:Arial,Helvetica,sans-serif;font-size:12pt;color:#f00;border:0">%s</p>
					<p style="padding:0;font-family:Arial,Helvetica,sans-serif;font-size:10pt;color:#f00;font-weight:normal;border:0">
						Stack Trace:
						<pre style="background-color:pink;padding:3px 5px">%s</pre>
					</p>
				</div>
			</div>',
			__VERSION__,
			PHP_VERSION,
			zend_version(),
			$strOS,
			$_SERVER['SERVER_SOFTWARE'],
			$_SERVER['SERVER_NAME'],
			$this->getMessage(),
			$this->getTraceAsString()
		);
	}

	// override __toString
	public function __toString() {
		if (__SHOW_FRIENDLY_ERROR__) {
			ob_clean();
			ob_start();
			require_once(__FRIENDLY_ERROR__);
			$strFriendlyError = ob_get_contents();
			ob_end_clean();
			return $strFriendlyError;
		} else {
			return self::$strConsoleOutput;
		}
	}
}
?>
