<?php
require_once "prepend.inc.php";

/**
 * File: RoutingHandler.class.php
 * Created on: Thu Sep 21 15:21 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 */

class RoutingHandler {

	private static $arrPathInfo = array();
	private static $arrParams = array();

	private static $strModule = null;
	private static $strController = null;
	private static $strAction = null;

	public static function Run() {
		$strUrl = preg_replace('/\/\/+/', '/', Application::$RequestUri);

		$arrParams = explode('?', $strUrl);
		$arrPathInfo = explode('/', $arrParams[0]);
		self::$arrPathInfo = array_slice($arrPathInfo, 1, 3);

		/**
		 * convert '/index/index/index[/]' to '/'
		 */
		if (self::$arrPathInfo[0] == 'index' && self::$arrPathInfo[1] == 'index' && self::$arrPathInfo[2] == 'index') {
			Application::Redirect('/');
		}
	
		/**
		 * test for 'index' page
		 */
		if (count(self::$arrPathInfo) == 1 && empty(self::$arrPathInfo[0])) {
			self::$arrPathInfo = array('index', 'index', 'index');
		}

		/**
		 * test for invalid route;
		 * this usually means there aren't enough slash-delimited values to
		 * comprise a route
		 */
		try {
			if (count(self::$arrPathInfo) == 2) {
				throw new CustomException(Exceptions::ERROR, sprintf("Call to undefined route: '%s'", $strUrl));
			}
		} catch(CustomException $e) {
			header(HttpResponse::NOT_FOUND);
			print $e;
			exit;
		}

		self::$arrParams = array_slice($arrPathInfo, 4);

		$arrOutput = array('path' => self::$arrPathInfo, 'params' => self::$arrParams);
		//Application::Log(sprintf('<pre>%s</pre>', print_r($arrOutput, true)));

		$blnFoundController = false;
		foreach (self::$arrPathInfo as $strNode) {

			/**
			 * URI components may contain dashes (-) for display
			 * purposes. We need to remove them so that the module,
			 * controller, and action match up.
			 */
            $strNode = str_replace('-', '', $strNode);

			if ($blnFoundController) {
				self::$strAction = sprintf('%sAction', $strNode);
				break;
			}
			if (!file_exists(sprintf('%s/%s/controllers/%sController.class.php', __DOCROOT__, self::$strModule, $strNode))) {
				// it's a module
				self::$strModule .= sprintf('%s', $strNode);
			} else {
				// it's a controller
				self::$strController = sprintf('%sController', $strNode);
				$blnFoundController = true;
			}
		}

		try {
			if (!$blnFoundController) {
				throw new CustomException(Exceptions::ERROR, sprintf("Call to undefined route: '%s'", $strUrl));
			}
		} catch(CustomException $e) {
			header(HttpResponse::NOT_FOUND);
			print $e;
			exit;
		}

		require_once (sprintf('%s/%s/controllers/%s.class.php', __DOCROOT__, self::$strModule, self::$strController));

		RoutingHandler::SetParams();

		RoutingHandler::RunControllerAction();
	}

	private static function SetParams() {
		// gather the params
		if (count(self::$arrParams) > 0) {
			$i = 1;
			foreach (self::$arrParams as $mixValue) {
				if ($i % 2 == 1) {
					$strName = $mixValue;
				} else {
					$_POST[$strName] = $mixValue;
				}
				$i++;
			}
		}
		foreach ($_GET as $strName => $mixValue) {
			$_POST[$strName] = $mixValue;
		}
		self::$arrParams = $_POST;
	}

	private static function RunControllerAction() {
		// run the controller
		$strController = self::$strController;
		$strAction = self::$strAction;

		/**
		 * this is experimental in nature;
		 * it's intended to prevent internal content being routed through here;
		 * it seems to work!
		 */
		if (strpos($strAction, 'http') !== false) {
			return false;
		}

		//Application::Log(sprintf('Routing to: %s->%s()', $strController, $strAction)); 

		$_CONTROLLER = new $strController;
		try {
			if (method_exists($_CONTROLLER, $strAction)) {
				$_CONTROLLER->$strAction();
			} else {
				$_CONTROLLER->ActionErrorHandler($strController, $strAction);
			}
		} catch(CustomException $e) {
			header(HttpResponse::NOT_FOUND);
			print $e;
			exit;
		}

		// if we're redirecting then we don't need to render anything
		if (!Application::$NoRender) {

			ob_start('ob_gzhandler');
			ob_start();
			if (isset($_CONTROLLER->objHeader) && Application::$Layout != Layout::Plain) {
				$_CONTROLLER->objHeader->Render();
			}

			$_CONTROLLER->Render();

			if (isset($_CONTROLLER->objFooter) && Application::$Layout != Layout::Plain) {
				$_CONTROLLER->objFooter->Render();
			}
			ob_end_flush();

		}
	}

	public function GetModule() {
		return self::$strModule;
	}

	public function GetController() {
		return self::$strController;
	}

	public function GetAction() {
		return self::$strAction;
	}

	public function GetParams() {
		return self::$arrParams;
	}
}
?>
