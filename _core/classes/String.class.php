<?php
/**
 * File : String.class.php
 * Created on: Thu Oct 16 00:54 CDT 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name String
 *
 * An abstract utility class to handle string manipulation. All methods are statically available.
 */

abstract class String {
	/**
	 * This faux constructor method throws a caller exception.
	 * The String object should never be instantiated, and this constructor
	 * override simply guarantees it.
	 *
	 * @return void
	 */

	/**
	 * Returns the first character of a given string, or null if the given
	 * string is null.
	 * @param string $strString 
	 * @return string the first character, or null
	 */
	public final static function FirstCharacter($strString) {
		if (strlen($strString) > 0) {
			return substr($strString, 0 , 1);
		} else {
			return null;
		}
	}

	/**
	 * Returns the last character of a given string, or null if the given
	 * string is null.
	 * @param string $strString 
	 * @return string the last character, or null
	 */
	public final static function LastCharacter($strString) {
		$intLength = strlen($strString);
		if ($intLength > 0) {
			return substr($strString, $intLength - 1);
		} else {
			return null;
		}
	}

	/**
	 * Truncates a string to a given length
	 * 
	 * @param string $strString string to truncate
	 * @param integer $intLength the length of the returned string
	 * @param boolean $blnRemovePunctuation optinally removes periods and commas from the end of the returned string
	 * @param string $strTail optional string to append to returned string
	 */
	public static function Truncate($strString, $intLength = 30, $blnRemovePunctuation = true, $strTail = "&nbsp;&hellip;") {
		$strString = trim($strString);
		$intTxtLen = strlen($strString);
		if ($intTxtLen > $intLength) {
			for($i=1;$strString[$intLength-$i]!=" ";$i++) {
				if ($i == $intLength) {
					return substr($strString, 0, $intLength) . $strTail;
				}
			}
			if ($blnRemovePunctuation) {
				for(;$strString[$intLength-$i]=="," || $strString[$intLength-$i]=="." || $strString[$intLength-$i]==" ";$i++) {;}
				$strString = substr($strString, 0, $intLength-$i+1) . $strTail;
			}
		}
		return $strString;
	}

	/**
	 * Escapes the string so that it can be safely used in as an Xml Node (basically, adding CDATA if needed)
	 * @param string $strString string to escape
	 * @return string the XML Node-safe String
	 */
	public final static function XmlEscape($strString) {
		if ((strpos($strString, '<') !== false) || (strpos($strString, '&') !== false)) {
			$strString = str_replace(']]>', ']]]]><![CDATA[>', $strString);
			$strString = sprintf('<![CDATA[%s]]>', $strString);
		}
		return $strString;
	}

	/**
	 * Returns an array in an easy-to-read format
	 * @param array $arrName name of input array
	 * @return string the formatted array as a string
	 */
	public final static function ArrayFormat($arrName) {
		return sprintf('<pre>%s</pre>', print_r($arrName, true));
	}

	/**
	 * Returns a delimiter separated string
	 * @param array $arrValues values to be delimited
	 * @param string $strDelimiter optional delimiter, default ', '
	 * @return string the formatted array as a string
	 */
	public final static function InsertDelimiters($arrValues, $strDelimiter = ', ') {
		$strOutput = null;
		$blnIsFirst = true;
		foreach ($arrValues as $strValue) {
			if (!is_null($strValue)) {
				if (!$blnIsFirst) {
					$strOutput .= sprintf('%s%s', $strDelimiter, $strValue);
				} else {
					$strOutput .= $strValue;
				}
				$blnIsFirst = false;
			}
		}

		return $strOutput;
	 }
}
?>
