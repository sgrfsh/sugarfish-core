<?php
/**
 * File : Application.class.php
 * Created on: Mon Sep 15 00:10 CDT 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name Application
 *
 * static Helper class
 */

abstract class Application {

	//////////////////////////
	// Public Static Variables
	//////////////////////////

	/**
	 * Internal bitmask signifying which BrowserType the user is using
	 * Use the Application::IsBrowser() method to do browser checking
	 *
	 * @var integer BrowserType
	 */
	public static $BrowserType = BrowserType::Unsupported;

	/**
	 * Path of the "web root" or "document root" of the web server
	 *
	 * @var string DocumentRoot
	 */
	public static $DocumentRoot;

	/**
	 * Boolean value set to true if the current page is secure
	 *
	 * @var string SecurePage
	 */
	public static $SecurePage;

	/**
	 * The full Request URI that was requested
	 * So for "http://www.domain.com/folder/script.php/15/25/?item=15&value=22"
	 * Application::$RequestUri would be "/folder/script.php/15/25/?item=15&value=22"
	 *
	 * @var string RequestUri
	 */
	public static $RequestUri;

	/**
	 * The IP address of the server running the script/PHP application
	 * This is either the LOCAL_ADDR or the SERVER_ADDR server constant, depending
	 * on the server type, OS and configuration.
	 *
	 * @var string ServerAddress
	 */
	public static $ServerAddress;

	/**
	 * The IP address of the client machine
	 *
	 * @var string RemoteAddress
	 */
	public static $RemoteAddress;

	/**
	 * The encoding type for the application (e.g. UTF-8, ISO-8859-1, etc.)
	 *
	 * @var string EncodingType
	 */
	public static $EncodingType = 'utf-8';

	/**
	 * Tells the application when a redirect is in effect
	 *
	 * @var boolean blnRedirecting
	 */
	public static $NoRender = false;

	/**
	 * Tells the application which layout to use
	 *
	 * @var string Layout
	 */
	public static $Layout;

	/**
	 * Supplies the ControlHandler with the next control ID for an anonymous control
	 * i.e. when an explicit control ID has not been supplied
	 *
	 * @var integer NextControlId
	 */
	public static $NextControlId = 0;

	/**
	* This faux constructor method throws a caller exception.
	* The Application object should never be instantiated!!!
	*
	* @return void
	*/
	public final function __construct() {
		throw new CustomException(Exceptions::STATIC_CLASS_INSTANTIATION, "Application should never be instantiated. All methods and variables are publically statically accessible.");
	}

	////////////////////////
	// Public Static Methods
	////////////////////////

	/**
	 * This should be the first call to initialize all the static variables
	 * The application object also has static methods that are miscellaneous web
	 * development utilities, etc.
	 *
	 * @return void
	 */
	public static function Initialize() {
		// Setup Server Address
		self::$ServerAddress = $_SERVER['SERVER_ADDR'];
		self::$RemoteAddress = $_SERVER['REMOTE_ADDR'];

		// Setup RequestUri
		self::$RequestUri = $_SERVER['REQUEST_URI'];

		// Setup DocumentRoot
		self::$DocumentRoot = trim(__DOCROOT__);

		// Setup SecurePage
		self::$SecurePage = ($_SERVER['HTTPS'] == 'on')?true:false;

		self::$Layout = Layout::NotSet;

		// Setup Browser Type
		if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
			$strUserAgent = trim(strtolower($_SERVER['HTTP_USER_AGENT']));

			// Internet Explorer
			if (strpos($strUserAgent, 'msie') !== false) {
				Application::$BrowserType = BrowserType::InternetExplorer;

				if (strpos($strUserAgent, 'msie 6.0') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::InternetExplorer_6_0;
				} else if (strpos($strUserAgent, 'msie 7.0') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::InternetExplorer_7_0;
				} else if (strpos($strUserAgent, 'msie 8.0') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::InternetExplorer_8_0;
				} else if (strpos($strUserAgent, 'msie 9.0') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::InternetExplorer_9_0;
				} else {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Unsupported;
				}

			// Firefox
			} else if ((strpos($strUserAgent, 'firefox') !== false) || (strpos($strUserAgent, 'iceweasel') !== false)) {
				Application::$BrowserType = BrowserType::Firefox;
				$strUserAgent = str_replace('iceweasel/', 'firefox/', $strUserAgent);

				if (strpos($strUserAgent, 'firefox/1.0') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Firefox_1_0;
				} else if (strpos($strUserAgent, 'firefox/1.5') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Firefox_1_5;
				} else if (strpos($strUserAgent, 'firefox/2.0') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Firefox_2_0;
				} else if (strpos($strUserAgent, 'firefox/3.0') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Firefox_3_0;
				} else if (strpos($strUserAgent, 'firefox/3.5') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Firefox_3_5;
				} else if (strpos($strUserAgent, 'firefox/3.6') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Firefox_3_6;
				} else {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Unsupported;
				}

			// Safari
			} else if (strpos($strUserAgent, 'safari') !== false) {
				Application::$BrowserType = BrowserType::Safari;

				if (strpos($strUserAgent, 'safari/41') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Safari_2_0;
				} else if (strpos($strUserAgent, 'version/3.') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Safari_3_0;
				} else if (strpos($strUserAgent, 'version/4.') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Safari_4_0;
				} else {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Unsupported;
				}

			// Chrome
			} else if (strpos($strUserAgent, 'chrome') !== false) {
				Application::$BrowserType = BrowserType::Chrome;
				Application::$BrowserType = Application::$BrowserType | BrowserType::Unsupported;

				if (strpos($strUserAgent, 'chrome/2.') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Chrome_2_0;
				} else if (strpos($strUserAgent, 'chrome/3.') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Chrome_3_0;
				} else if (strpos($strUserAgent, 'chrome/4.') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Chrome_4_0;
				} else if (strpos($strUserAgent, 'chrome/4.') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Chrome_5_0;
				} else if (strpos($strUserAgent, 'chrome/4.') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Chrome_6_0;
				} else if (strpos($strUserAgent, 'chrome/7.') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Chrome_7_0;
				} else {
					Application::$BrowserType = Application::$BrowserType | BrowserType::Unsupported;
				}

			// Unsupported
			} else {
				Application::$BrowserType = BrowserType::Unsupported;

				// iPhone
				if (strpos($strUserAgent, 'iphone') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::iPhone;
				}

				// iPod
				if (strpos($strUserAgent, 'ipod') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::iPod;
				}

				// iPad
				if (strpos($strUserAgent, 'ipad') !== false) {
					Application::$BrowserType = Application::$BrowserType | BrowserType::iPad;
				}
			}
		}
	}

	public static function IsBrowser($intBrowserType) {
		return ($intBrowserType & self::$BrowserType);
	}
	
	/**
	 * This will redirect the user to a new web location. This can be a relative or absolute web path, or it
	 * can be an entire URL.
	 *
	 * @return void
	 */
	public static function Redirect($strLocation) {
		if ($strLocation != '_errorlog') {
			self::Log('Redirecting to: ' . $strLocation);
		}
		self::SetNoRender();

		ob_clean();

		if (array_key_exists('DOCUMENT_ROOT', $_SERVER) && ($_SERVER['DOCUMENT_ROOT'])) {
			header(sprintf('Location: %s', $strLocation));
		} else {
			printf('<script type="text/javascript">document.location = "%s";</script>', $strLocation);
		}
		exit();
	}

	/**
	 * This will set NoRender which prevents the rendering of a 'page'
	 * This is automatically called during a redirect
	 *
	 * @return void
	 */
	public static function SetNoRender() {
		self::$NoRender = true;
	}

	/**
	 * This will set NoRender which prevents the rendering of a 'page'
	 * This is automatically called during a redirect
	 *
	 * @return void
	 */
	public static function SetLayout($strLayout) {
		self::$Layout = $strLayout;
	}

	/**
	 * This will close the window. It will immediately end processing of the rest of the script.
	 *
	 * @return void
	 */
	public static function CloseWindow() {
		ob_clean();

		print('<script type="text/javascript">window.close();</script>');
	}

	/**
	 * Gets the value of the item $strItem. Will return NULL if it doesn't exist.
	 *
	 * @return string
	 */
	public static function Request($strItem) {
		$arrParams = RoutingHandler::GetParams();
		if (is_null($strItem)) {
			return $arrParams;
		}
		if (array_key_exists($strItem, $arrParams)) {
			return $arrParams[$strItem];
		} else {
			return null;
		}
	}

	/**
	 * Global/Central HtmlEntities command to perform the PHP equivalent of htmlentities.
	 * 
	 * This method is also used by the global print "_p" function.
	 *
	 * @param string $strText text string to perform html escaping
	 * @return string the html escaped string
	 */
	public static function HtmlEntities($strText) {
		return htmlentities($strText, ENT_COMPAT, self::$EncodingType);
	}

	/**
	 * Logs messages to the error log if __LOG_VERBOSE__ is set to true
	 * 
	 * @param mixed $mixValue any message or value
	 */
	public static function Log($mixValue) {
		if (__LOG_VERBOSE__) {
			if (is_object($mixValue) || is_array($mixValue)) {
				error_log(sprintf('<pre>%s</pre>', print_r($mixValue, true)));
			} else {
				error_log($mixValue);
			}
		}
	}
}
?>
