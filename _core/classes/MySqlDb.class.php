<?php
/**
 * File: MySqlDb.class.php
 * Created on: Wed Apr 21 13:47 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * 
 * @deprecated
 */

class MySqlDb {
	private static $hdlConnection;

	/**
	 * This faux constructor method throws a caller exception.
	 * The DataModel object should never be instantiated!!!
	 *
	 * @return void
	 */
	public final function __construct() {
		try {
			$strMessage = "MySqlDb should never be instantiated. All methods and variables are publically statically accessible";
		throw new CustomException(Exceptions::STATIC_CLASS_INSTANTIATION, $strMessage);
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

	public static function Initialize() {
		self::ConnectDb();
	}

	public static function ConnectDb($strDatabase = __DB__, $strServer = __DB_SERVER__, $strUsername = __DB_USERNAME__, $strPassword = __DB_PASSWORD__, $blnNewConnection = true, $intClientFlags = 0) {
		try {
			if (!self::$hdlConnection = mysql_connect($strServer, $strUsername, $strPassword, $blnNewConnection, $intClientFlags)) {
				throw new CustomException(self::ErrorNumber(), self::ErrorMessage());
			} else {
				self::Query('USE ' . $strDatabase);
			}
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

	public static function ErrorNumber()	{
		return mysql_errno(self::$hdlConnection);
	}

	public static function ErrorMessage()	{
		return mysql_error(self::$hdlConnection);
	}

	public static function EscapeString($strString) {
		return mysql_real_escape_string($strString);
	}

	public static function Query($strQuery) {
		if ($strQuery != sprintf('USE %s', __DB__)) {
			self::LogDb('<pre style="font-family:Arial,sans-serif; font-size:11px; color:#fc0000">' . addslashes($strQuery) . '<br />[' . Application::$RemoteAddress . ']</pre>');
		}
		return mysql_query($strQuery, self::$hdlConnection);
	}

	public static function FetchArray($objResult, $constArrayType = MYSQL_BOTH) {
		return mysql_fetch_array($objResult, $constArrayType);
	}

	public static function FetchRow($objResult) {
		return mysql_fetch_row($objResult);
	}

	public static function FetchAssoc($objResult) {
			return mysql_fetch_assoc($objResult);
	}

	public static function FetchObject($objResult) {
		return mysql_fetch_object($objResult);
	}

	/**
	 * Return the number of rows for a given query result
	 *
	 * @return  number of rows in query
 	 */
	public static function NumRows($objResult, $blnFormat = false) {
		if ($intNumRows = mysql_num_rows($objResult)) {
			return ($blnFormat) ? number_format($intNumRows) : $intNumRows;
		} else {
			return ($blnFormat) ? number_format(0) : 0;
		}
	}

	/**
	 * Return the next auto-increment value for a given table
	 *
	 * @return  auto-increment value or error if no auto-increment exists
	 */
	public static function NextAutoIncrement($strTable = null) {
		if ($strTable) {
			$objResult = mysql_query(sprintf("SHOW TABLE STATUS LIKE '%s';", $strTable));
			$objRow = mysql_fetch_assoc($objResult);
			$intAutoInc = $objRow['Auto_increment'];
			if (!is_null($intAutoInc)) {
				return $intAutoInc;
			} else {
				return sprintf( "&quot;%s&quot; does not contain an auto-increment column", $strTable);
			}
		}
	}

	/**
	 * Count all rows in the given table
	 *
	 * @return $intCount;
	 */
	public static function Count($strTable = null, $blnFormat = false) {
		if ($strTable) {
			$objResult = mysql_query(sprintf("SELECT * FROM %s;", $strTable));
			$intCount = self::NumRows($objResult, $blnFormat);
			return $intCount;
		}
	}

	public static function CloseDb() {
		if (isset(self::$hdlConnection)) {
			mysql_close(self::$hdlConnection);
			unset(self::$hdlConnection);
		}
	}

	public static function LogDb($mixValue) {
		if (__LOG_DB_QUERIES__) {
			error_log($mixValue);
		}
	}
}
?>
