<?php
/**
 * File : MimeType.class.php
 * Created on: Wed Nov 12 02:10 CDT 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name MimeType
 */

abstract class MimeType {
	// Constants for Mime Types
	const _Default = 'application/octet-stream';
	const Executable = 'application/octet-stream';
	const Gif = 'image/gif';
	const Html = 'text/html';
	const JavaScript = 'text/javascript';
	const Jpeg = 'image/jpeg';
	const Mp3 = 'audio/mpeg';
	const MpegVideo = 'video/mpeg';
	const MsExcel = 'application/vnd.ms-excel';
	const MsPowerpoint = 'application/vnd.ms-powerpoint';
	const MsWord = 'application/vnd.ms-word';
	const Pdf = 'application/pdf';
	const PlainText = 'text/plain';
	const Png = 'image/png';
	const RichText = 'text/richtext';
	const Quicktime = 'video/quicktime';
	const Xml = 'text/xml';
	const Zip = 'application/zip';

	/**
	 * MimeTypeFor array is used in conjunction with GetMimeTypeForFilename()
	 * @var string[]
	 */
	public static $MimeTypeFor = array(
		'doc' => MimeType::MsWord,
		'exe' => MimeType::Executable,
		'gif' => MimeType::Gif,
		'htm' => MimeType::Html,
		'html' => MimeType::Html,
		'jpeg' => MimeType::Jpeg,
		'jpg' => MimeType::Jpeg,
		'mov' => MimeType::Quicktime,
		'mp3' => MimeType::Mp3,
		'mpeg' => MimeType::MpegVideo,
		'mpg' => MimeType::MpegVideo,
		'pdf' => MimeType::Pdf,
		'php' => MimeType::PlainText,
		'png' => MimeType::Png,
		'ppt' => MimeType::MsPowerpoint,
		'rtf' => MimeType::RichText,
		'sql' => MimeType::PlainText,
		'txt' => MimeType::PlainText,
		'xls' => MimeType::MsExcel,
		'xml' => MimeType::Xml,
		'zip' => MimeType::Zip
	);


	/**
	 * the absolute file path of the MIME Magic Database file
	 * @var string
	 */
	public static $MagicDatabaseFilePath = null;


	/**
	 * Returns the suggested MIME type for an actual file.  Using file-based heuristics
	 * (data points in the ACTUAL file), it will utilize either the PECL FileInfo extension
	 * OR the Magic MIME extension (if either are available) to determine the MIME type.  If all
	 * else fails, it will fall back to the basic GetMimeTypeForFilename() method.
	 *
	 * @param string $strFilePath the absolute file path of the ACTUAL file
	 * @return string
	 */
	public static function GetMimeTypeForFile($strFilePath) {
		// Clean up the File Path and pull out the filename
		$strRealPath = realpath($strFilePath);
		if (!is_file($strRealPath))
			throw new Exception('File Not Found: ' . $strFilePath);
		$strFilename = basename($strRealPath);
		$strToReturn = null;

		// First attempt using the PECL FileInfo extension
		if (class_exists('finfo')) {
			if (MimeType::$MagicDatabaseFilePath)
				$objFileInfo = new finfo(FILEINFO_MIME, MimeType::$MagicDatabaseFilePath);
			else
				$objFileInfo = new finfo(FILEINFO_MIME);
			$strToReturn = $objFileInfo->file($strRealPath);
		}


		// Next, attempt using the legacy MIME Magic extension
		if ((!$strToReturn) && (function_exists('mime_content_type'))) {
			$strToReturn = mime_content_type($strRealPath);
		}


		// Finally, use internal method for determining MIME type
		if (!$strToReturn)
			$strToReturn = MimeType::GetMimeTypeForFilename($strFilename);


		if ($strToReturn)
			return $strToReturn;
		else
			return MimeType::_Default;
	}


	/**
	 * Returns the suggested MIME type for a filename by stripping
	 * out the extension and looking it up from MimeType::$MimeTypeFor
	 *
	 * @param string $strFilename
	 * @return string
	 */
	public static function GetMimeTypeForFilename($strFilename) {
		if (($intPosition = strrpos($strFilename, '.')) !== false) {
			$strExtension = trim(strtolower(substr($strFilename, $intPosition + 1)));
			if (array_key_exists($strExtension, MimeType::$MimeTypeFor))
				return MimeType::$MimeTypeFor[$strExtension];
		}

		return MimeType::_Default;
	}
}
?>
