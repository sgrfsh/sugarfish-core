<?php
/**
 * File : UrlHandler.class.php
 * Created on: Sun Sep 19 12:48 CDT 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name UrlHandler
 * 
 * static Helper class
 */

class UrlHandler {

	/**
	* This faux constructor method throws a caller exception.
	* The UrlHandler object should never be instantiated!!!
	*
	* @return void
	*/
	public final function __construct() {
		try {
			$strMessage = "UrlHandler should never be instantiated. All methods and variables are publically statically accessible";
			throw new CustomException(Exceptions::STATIC_CLASS_INSTANTIATION, $strMessage);
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

	public static function BuildUrl($arrArgs = null) {
		if (
			!array_key_exists('module', $arrArgs) ||
			!array_key_exists('controller', $arrArgs) ||
			!array_key_exists('action', $arrArgs)
		) {
			throw new CustomException(Exceptions::ERROR, 'URL must contain a Module, Controller and Action');
		}

		$strUrl = sprintf('/%s/%s/%s', $arrArgs['module'], $arrArgs['controller'], $arrArgs['action']);

		if (array_key_exists('params', $arrArgs)) {
			$strUrl .= self::BuildParams($arrArgs['params']);
		}

		return $strUrl;
	}

	protected static function BuildParams($arrParams) {
		$strUrl = null;
		foreach ($arrParams as $strName => $strValue) {
			$strUrl .= sprintf('/%s/%s', $strName, $strValue);
		}

		return $strUrl;
	}
}
?>
