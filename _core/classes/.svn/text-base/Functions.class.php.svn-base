<?php
/**
 * File : Functions.class.php
 * Created on: Mon May 3 23:52 CDT 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name Functions
 *
 * static Helper class
 */

class Functions {

	/**
	* This faux constructor method throws a caller exception.
	* The Functions object should never be instantiated!!!
	*
	* @return void
	*/
	public final function __construct() {
		try {
			$strMessage = "Functions should never be instantiated. All methods and variables are publically statically accessible";
			throw new CustomException(Exceptions::STATIC_CLASS_INSTANTIATION, $strMessage);
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

	/**
	 * Microtime functionality. If a (float|int) is passed in function
	 * returns the difference between the now time and the time passed
	 * in. Otherwise it gets the standard microtime as a float and returns
	 * it
	 */
	public static function GetMicrotime($intFromTime = null) {
		if ($intFromTime) {
			return microtime(true) - $intFromTime;
		} else {
			return microtime(true);
		}
	}

	/**
	 * HTTP address validation. Returns true if URL contains 'http://' or 'https://'
	 */
	public static function IsValidHttpAddress($strUrl) {
		if (strpos($strUrl, 'http://') === false && strpos($strUrl, 'https://') === false) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Email address validation. Returns true if email address is correctly formatted
	 */
	public static function IsValidEmailAddress($strEmailAddress) {
		if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $strEmailAddress)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Date/time functions
	 */
	public static function NumericMonthToString($intMonth, $blnShort = false) {
		$strFormat = (!$blnShort?'F':'M');
		$intTimestamp = mktime(0, 0, 0, $intMonth, 1, 1969);

		return date($strFormat, $intTimestamp);
	}

	public static function DateGreaterThanToday($objDateTime = null, $blnOrEqual = false) {
		if (!is_null($objDateTime)) {
	    		return ($blnOrEqual)?(date_format($objDateTime,"U") >= date("U")):(date_format($objDateTime,"U") > date("U"));
		}else{
			return false;
		}
	}

	public static function DateLessThanToday($objDateTime = null, $blnOrEqual = false) {
		if (!is_null($objDateTime)) {
	    		return ($blnOrEqual)?(date_format($objDateTime,"U") <= date("U")):(date_format($objDateTime,"U") < date("U"));
		}else{
			return false;
		}
	}

	public static function IsExpired($intTimestamp, $intNumDays = 30) {
		if (!is_numeric($intTimestamp)) {
			return false;
		}
		$intNow = time();
		$intExpiration = $intTimestamp + DateTimeSpan::SecondsPerDay * $intNumDays;
		if ($intExpiration <= $intNow) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * PHP port of Ruby on Rails famous distance_of_time_in_words method.
	 *  See http://api.rubyonrails.com/classes/ActionView/Helpers/DateHelper.html for more details.
	 *
	 * Note: changed the method to calculate time elapsed from $intFromTime until now.
	 * Outputs a date if the result is longer than a day
	 */
	public static function DistanceOfTimeInWords($intFromTime, $blnIncludeSeconds = false) {
		$intToTime = time();
		$intDistanceInMinutes = round(abs($intToTime - $intFromTime) / 60);
		$intDistanceInSeconds = round(abs($intToTime - $intFromTime));

		if ($intDistanceInMinutes >= 0 and $intDistanceInMinutes <= 1) {
			if (!$blnIncludeSeconds) {
				return ($intDistanceInMinutes == 0) ? 'less than a minute ago' : '1 minute ago';
			} else {
				if ($intDistanceInSeconds >= 0 and $intDistanceInSeconds <= 4) {
					return 'less than 5 seconds ago';
				} elseif ($intDistanceInSeconds >= 5 and $intDistanceInSeconds <= 9) {
					return 'less than 10 seconds ago';
				} elseif ($intDistanceInSeconds >= 10 and $intDistanceInSeconds <= 19) {
					return 'less than 20 seconds ago';
				} elseif ($intDistanceInSeconds >= 20 and $intDistanceInSeconds <= 39) {
					return 'half a minute ago';
				} elseif ($intDistanceInSeconds >= 40 and $intDistanceInSeconds <= 59) {
					return 'less than a minute ago';
				} else {
					return '1 minute ago';
				}
			}
		} elseif ($intDistanceInMinutes >= 2 and $intDistanceInMinutes <= 44) {
			return $intDistanceInMinutes . ' minutes ago';
		} elseif ($intDistanceInMinutes >= 45 and $intDistanceInMinutes <= 89) {
			return 'about 1 hour ago';
		} elseif ($intDistanceInMinutes >= 90 and $intDistanceInMinutes <= 1439) {
			return 'about ' . round(floatval($intDistanceInMinutes) / 60.0) . ' hours ago';
		} elseif ($intDistanceInMinutes >= 1440 and $intDistanceInMinutes <= 2160) {
			return 'about 1 day ago';
		} else {
			return date(DateFormats::COMPACT , $intFromTime);
		}
	}

	public static function DatePlusNDays($strDateTime = null, $intDaysToAdd, $blnFromToday = false, $blnEndOfDay = false) {
		if (is_null($strDateTime)) {
			$strDateTime = date(DateFormats::DATETIME);
		}
		if (!$blnFromToday) {
			$intStart = strtotime($strDateTime);
		} else {
			$intStart = time();
		}

		$intEnd = $intStart + $intDaysToAdd * DateTimeSpan::SecondsPerDay;

		if ($blnEndOfDay) {
			$intEnd = strtotime($strDateToConvert = date("Y-m-d 23:59:59", $intEnd));
		}

		return date(DateFormats::DATETIME, $intEnd);
	}

	/**
	 * Like distanceOfTimeInWords, but where intToTime is fixed to the output of time()
	 *
	 */
	public static function TimeAgoInWords($intFromTime, $blnIncludeSeconds = false) {
		return self::DistanceOfTimeInWords($intFromTime, time(), $blnIncludeSeconds);
	}

	public static function RequisitionExpiration($strExpirationDateTime) {
		$intNow = time();
		$intExpiration = strtotime($strExpirationDateTime);

		$intDiff = $intExpiration - $intNow;

		if ($intNow > $intExpiration || ($intDiff) > (SecondsIn::DAY * 5)) {
			return;
		}

		$fltNumDays = $intDiff / SecondsIn::DAY;

		$strPosition = 'position:relative; top:-3px; margin:0 0 0 5px;';

		if ($fltNumDays > 1) {
			$strMessage = sprintf('<span style="%s color:#008000">This job will expire in %s days</span>', $strPosition, ceil($fltNumDays));
		} else {
			if ($fltNumDays == 1) {
				$strMessage = sprintf('<span style="%s color:#008000">This job will expire in 1 day</span>', $strPosition);
			} else {

				$fltNumHours = $intDiff / SecondsIn::HOUR;

				if ($fltNumHours > 1) {
					$strMessage = sprintf('<span style="%s color:#e66f00">This job will expire in %s hours</span>', $strPosition, ceil($fltNumHours));
				} else {
					if ($fltNumHours == 1) {
						$strMessage = sprintf('<span style="%s color:#e66f00">This job will expire in 1 hour</span>', $strPosition);
					} else {

						$fltNumMinutes = $intDiff / SecondsIn::MINUTE;

						if ($fltNumMinutes > 1) {
							$strMessage = sprintf('<span style="%s color:#f00">This job will expire in %s minutes</span>', $strPosition, ceil($fltNumMinutes));
						} else {
							if ($fltNumMinutes == 1) {
								$strMessage = sprintf('<span style="%s color:#f00">This job will expire in 1 minute</span>', $strPosition);
							}
						}
					}
				}
			}
		}

		return $strMessage;
	}

	/**
	 * Output the copyright notice
	 *
	 */
	public static function Copyright($blnLong = false, $blnSymbol = true) {
		$intYear = date("Y");
		$strCompanyName = ($blnLong == false)?'Ian Atkin<div class="cf"></div>ALL RIGHTS RESERVED.':'Ian Atkin. All rights reserved. All other trademarks are the property of their respective owners.';

		$strSymbol = ($blnSymbol)?'&copy;':'';
		if ($intYear > 2008) {
			return sprintf("%s2008-%s, %s", $strSymbol, $intYear, $strCompanyName);
		} else {
			return sprintf("%s%s, %s", $strSymbol, $intYear, $strCompanyName);
		}
	}

	/**
	 * Takes a link (or even plain text) and create a JavaScript snippet that will output same
	 * using an encoded version. This makes it just that bit harder for bots and spiders to scrape email addresses or
	 * links from the page.
	 * 
	 * (Inspired by JROX Affiliate Manager code, reverse engineered from same)
	 *
	 */
	public static function LinkObfuscator($strLink) {
		// remove carriage returns, tabs, excess whitespace
		$strLink = self::RemoveExtraWhitespace($strLink);

		$intBreak = rand(0, strlen($strLink));
		$strFirst = substr($strLink, 0, $intBreak+1);
		$strSecond = substr($strLink, $intBreak+1, strlen($strLink)-($intBreak+1));

		// if we want to include carriage returns or tabs then we need to omit 6, 7 and 60 thru 79!
		//$intRnd = rand(0, 40);
		//$intRnd0 = ($intRnd < 21) ? rand(8, 59) : ($intRnd > 20 && $intRnd < 31) ? rand(80, 128) : rand(0, 5);
		$intRnd0 = rand(0, 128);
		$intRnd1 = rand(0, 49);
		$intRnd2 = rand(50, 99);
		for ($i=0; $i<strlen($strFirst); $i++) {
			$intFirst = ord(substr($strFirst, $i, 1))+ord($intRnd0)-32;
			$strFirstTrans .= urlencode(chr($intFirst));
		}
		for ($i=0; $i<strlen($strSecond); $i++) {
			$intSecond = ord(substr($strSecond, $i, 1))+ord($intRnd0)-32;
			$strSecondTrans .= urlencode(chr($intSecond));
		}

		$strEncodedLink = "<script type=\"text/javascript\">";
		$strEncodedLink .= "var _str" . $intRnd1 . "=\"" . $strFirstTrans . "\";";
		if (rand(0,100) < 20) {
			$strEncodedLink .= "</script><script type=\"text/javascript\">";
		}
		$strEncodedLink .= "var _str00=\"%" . dechex(ord($intRnd0)) . "\";";
		if (rand(0,100) < 20) {
			$strEncodedLink .= "</script><script type=\"text/javascript\">";
		}
		$strEncodedLink .= "var _str" . $intRnd2 . "=\"" . $strSecondTrans . "\";";
		if (rand(0,100) < 20) {
			$strEncodedLink .= "</script><script type=\"text/javascript\">";
		}
		$strEncodedLink .= "var _str=unescape(_str" . $intRnd1 . "+_str" . $intRnd2 . ");";
		if (rand(0,100) < 20) {
			$strEncodedLink .= "</script><script type=\"text/javascript\">";
		}
		$strEncodedLink .= "_str00=unescape(_str00);";
		if (rand(0,100) < 20) {
			$strEncodedLink .= "</script><script type=\"text/javascript\">";
		}
		$strEncodedLink .= "_str00=_str00.charCodeAt(0);";
		if (rand(0,100) < 20) {
			$strEncodedLink .= "</script><script type=\"text/javascript\">";
		}
		$strEncodedLink .= "var _out=\"\";";
		if (rand(0,100) < 20) {
			$strEncodedLink .= "</script><script type=\"text/javascript\">";
		}
		$strEncodedLink .= "for(var i=0;i<_str.length;i++){_out+=String.fromCharCode(((_str.charCodeAt(i)-(_str00))%240)+32);}";
		if (rand(0,100) < 20) {
			$strEncodedLink .= "</script><script type=\"text/javascript\">";
		}
		$strEncodedLink .= "document.write(_out);";
		$strEncodedLink .= "</script>";

		return $strEncodedLink;
	}

	public function EmailEncoder($strLink, $strCssClass = null) {
		for ($i = 0; $i < strlen($strLink); $i++) {
			$strEncodedLink .= "&#" . ord($strLink[$i]);
		}
		if (!is_null($strCssClass)) {
			$strCssClass = sprintf(' class="%s"', $strCssClass);
		}
		$strEncodedLink = sprintf('<a href="&#109&#97&#105&#108&#116&#111&#58%1$s"%2$s>%1$s</a>', $strEncodedLink, $strCssClass);

		return $strEncodedLink;
	}

	public static function ByteConvert($intFilesize) {
		$arrSymbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');

		$intExp = 0;
		$fltConvertedValue = 0;

		if( $bytes > 0 ) {
			$intExp = floor( log($bytes)/log(1024) );
			$fltConvertedValue = ($intFilesize/pow(1024,floor($exp)));
		}

		return sprintf('%.2f '.$arrSymbols[$intExp], $fltConvertedValue);
	}

	public function FormatMoney($fltValue, $blnShowDecimals = true) {
		if ($blnShowDecimals) {
			$strValue =  trim(money_format('%#10.2n', $fltValue));
		} else {
			$strValue =  trim(money_format('%#10.0n', $fltValue));
		}
		return $strValue;
	}

	/**
	 * Replace certain characters (for example, those that are created in Microsoft Word) with their web-safe equivalent
	 * Remove undesirable tags and styles
	 */
	public static function SanitizeInputText($strText, $blnStripHTML = false, $blnCompact = false) {

		if ($blnCompact) {
			$strText = self::RemoveBreaks($strText);
		}

		if ($blnStripHTML) {

			// remove excessive space/breaks
			$strText = str_replace('&nbsp;', ' ', $strText);
			$strText = preg_replace('~<br>([[:space:]]{0,})<br>([[:space:]]{0,})<br>~si', '<br>', $strText);

			// remove 'meta' tags
			$strText = preg_replace('~<meta(.*?)\>~si', '', $strText);

			// remove 'link' tags
			$strText = preg_replace('~<link(.*?)\>~si', '', $strText);

			// remove 'xml' tags
			$strText = str_replace('<xml>', '', $strText);
			$strText = str_replace('</xml>', '', $strText);

			// remove Microsoft namespace declarations
			$strText = preg_replace('~<w:(.*?)\>~si', '', $strText);
			$strText = preg_replace('~</w:(.*?)\>~si', '', $strText);
			$strText = preg_replace('~<o:(.*?)\>~si', '', $strText);
			$strText = preg_replace('~</o:(.*?)\>~si', '', $strText);

			// remove Microsoft conditional comments
			//<!--[if gte mso 9]><![endif]-->
			$strText = preg_replace('~<!--\[if.*?-->~si', '', $strText);

			// remove 'div' tags
			$strText = preg_replace('~<div(.*?)\>~si', '', $strText);
			$strText = str_replace('</div>', '', $strText);

			// remove specific font styles
			$strText = preg_replace('~([[:space:]]?)font-(family|size):(.*?)\;([[:space:]]?)~i', '', $strText);
			$strText = preg_replace('~(\;?)([[:space:]]?)font-(family|size):(.*?)\"~i', '"', $strText);

			// remove 'font' tags
			$strText = preg_replace('~<font(.*?)\>~si', '', $strText);
			$strText = str_replace('</font>', '', $strText);

			// remove 'style'/'class' tags
			$strText = preg_replace('~([[:space:]]{0,})style=(\"|\')(.*?)(\"|\')~si', '', $strText);
			$strText = preg_replace('~([[:space:]]{0,})class=(\"|\')(.*?)(\"|\')~si', '', $strText);

			// remove various unwanted tags
			$strText = preg_replace(
				array(
					'@<head[^>]*?>.*?</head>@si',
					'@<style[^>]*?>.*?</style>@si',
					'@<script[^>]*?.*?</script>@si',
					'@<object[^>]*?.*?</object>@si',
					'@<embed[^>]*?.*?</embed>@si',
					'@<applet[^>]*?.*?</applet>@si',
					'@<noframes[^>]*?.*?</noframes>@si',
					'@<noscript[^>]*?.*?</noscript>@si',
					'@<noembed[^>]*?.*?</noembed>@si'
				),
				array(
					' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' '
				),
				$strText
			);

			// remove empty tags and tags containing only non-breaking space entities
			$strText = preg_replace(
				array(
					'@<div[^>]*?>([[:space:]|&nbsp;]{0,})</div>@si',
					'@<span[^>]*?>([[:space:]|&nbsp;]{0,})</span>@si',
					'@<p[^>]*?>([[:space:]|&nbsp;]{0,})</p>@si'
				),
				array(
					' ', ' ', ' '
				),
				$strText
			);

			// remove any existing 'target' tags
			$strText = preg_replace('~([[:space:]]{0,})target="(.{0,})"([[:space:]]{0,})~i', '', $strText);
			// add 'target' tag to links
			$strText = preg_replace('~href="([^mailto:].[^\>]{1,})">~i', 'href="$1" target="_new">', $strText);

		}

		// replace Microsoft 'smart' characters
		$arrOriginals = array("%u2026", "%u2033", "%u201D", "%u2018", "%u2019", "%u201C", "%u2022", "%u2013", "%u2014", "%u2122");
		$arrReplacements   = array("&hellip;", "&quot;", "&quot;", "&#039;", "&#039;", "&#034;", "&#149;", "&ndash;", "&mdash;", "&trade;");
		$strText = str_replace($arrOriginals, $arrReplacements, $strText);

		// other non-standard characters
		$arrOriginals = array(chr(128), chr(133), chr(145), chr(146), chr(147), chr(148), chr(149), chr(150), chr(151), chr(153), chr(163), chr(174), chr(183), chr(233));
		$arrReplacements   = array("&euro;", "&#039;", "&hellip;", "&#039;", "&quot;", "&quot;", "&#149;", "&ndash;", "&mdash;", "&trade;", "&#163;", "&reg;", "&#149;", "&eacute;");
		$strText = str_replace($arrOriginals, $arrReplacements, $strText);

		return $strText;
	}

	public static function CleanRenderedText($strText) {
		// allows for comments in the copy but not on the rendered page
		$strText = preg_replace('~<!--(.|\s)*?-->~si', '', $strText);

		return $strText;
	}

	/**
	 * Replace certain characters (for example, those that are created in Microsoft Word) with their web-safe equivalent
	 *
	 */
	public static function CleanTextInput($strText, $blnStripHTML = false) {
		if ($blnStripHTML) {
			$strText = strip_tags($strText);
		}

		$strText = ereg_replace("%u2026", "&hellip;", $strText);	// ellipses
		$strText = ereg_replace(133, "&#hellip;", $strText);		// ellipses
		$strText = ereg_replace("%u2033", "&quot;", $strText);		// double prime
		$strText = ereg_replace(8226, "&quot;", $strText);			// double prime
		$strText = ereg_replace("%u201D", "&quot;", $strText);		// right double quote
		$strText = ereg_replace(8221, "&quot;", $strText);			// right double quote
		$strText = ereg_replace(148, "&quot;", $strText);			// right double quote
		$strText = ereg_replace("%u2018", "&#039;", $strText);		// left single quote
		$strText = ereg_replace(8216, "&#039;", $strText);			// left single quote
		$strText = ereg_replace(145, "&#039;", $strText);			// left single quote
		$strText = ereg_replace("%u2019", "&#039;", $strText);		// right single quote
		$strText = ereg_replace(8217, "&#039;", $strText);			// right single quote
		$strText = ereg_replace(146, "&#039;", $strText);			// right single quote
		$strText = ereg_replace("%u201C", "&#034;", $strText);		// left double quote
		$strText = ereg_replace(8220, "&#034;", $strText);			// left double quote
		$strText = ereg_replace(147, "&#034;", $strText);			// left double quote
		$strText = ereg_replace("%u2022", "&#149;", $strText);		// bullet
		$strText = ereg_replace(8226, "&#149;", $strText);			// bullet
		$strText = ereg_replace(149, "&#149;", $strText);			// bullet
		$strText = ereg_replace(8211, "&#150;", $strText);			// en dash
		$strText = ereg_replace(150, "&#150;", $strText);			// en dash
		$strText = ereg_replace("%u2013", "&mdash;", $strText);		// em dash
		$strText = ereg_replace("%u2014", "&mdash;", $strText);		// em dash
		$strText = ereg_replace(8212, "&#151;", $strText);			// em dash
		$strText = ereg_replace(151, "&#151;", $strText);			// em dash
		$strText = ereg_replace("%u2122", "&trade;", $strText);		// trademark
		$strText = ereg_replace(8482, "&trade;", $strText);			// trademark
		$strText = ereg_replace(153, "&trade;", $strText);			// trademark
		$strText = ereg_replace(169, "&copy;", $strText);			// copyright mark
		$strText = ereg_replace(174, "&reg;", $strText);			// registration mark

		return $strText;
	}

	public static function RemoveBreaks($strText) {
		/* @todo: this is a hack at best; I'm sure there is a better way!!! */
		$strText = str_replace('<br>', chr(32), $strText);
		$strText = str_replace('<p>', chr(32), $strText);

		// remove excess whitespace
		$strText = self::RemoveExtraWhitespace($strText);

		return $strText;
	}

	public static function RemoveExtraWhitespace($strText) {
		return preg_replace('/\s\s+/', chr(32), $strText);
	}

	public static function VarDump($blnReturn = false) {
		// dump vars to log

		$strVarDump = "\n -- BEGIN VARIABLE DUMP --\n";

		if (count($_GLOBAL) > 0) {
			$strVarDump .= "\n -- BEGIN GLOBAL VARS --\n";
			$strVarDump .= print_r($_GLOBAL, true);
		}

		if (count($_GET) > 0) {
			$strVarDump .= "\n -- BEGIN GET VARS --\n";
			$strVarDump .= print_r($_GET, true);
		}

		if (count($_POST) > 0) {
			$strVarDump .= "\n -- BEGIN POST VARS --\n";
			$strVarDump .= print_r($_POST, true);
		}

		if (count($_SESSION) > 0) {
			$strVarDump .= "\n -- BEGIN SESSION VARS --\n";
			$strVarDump .= print_r($_SESSION, true);
		}

		if (count($_COOKIE) > 0) {
			$strVarDump .= "\n -- BEGIN COOKIE VARS --\n";
			$strVarDump .= print_r($_COOKIE, true);
		}

		$strVarDump .= "\n -- END VARIABLE DUMP --\n\n";

		if (!$blnReturn) {
			Application::Log($strVarDump);
		} else {
			return $strVarDump;
		}
	}
}
?>
