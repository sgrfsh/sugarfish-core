<?php
/**
 * File: Controller.class.php
 * Created on: Wed Sep 8 17:19 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * 
 * @package sugarfish_core
 * @name Page
 */

class Controller extends ControllerBase {

	protected function Initialize() {}

	public function Render() {
		$_CONTROL = $this->GetControls();
		$_PARAM = $this->GetParams();

		if (empty($_CONTROL)) {
			unset($_CONTROL);
		}

		if (empty($_PARAM)) {
			unset($_PARAM);
		}

		$arrDefinedVars = get_defined_vars();
		if (!empty($arrDefinedVars)) {
			// output the contents of the ControlHandler object to the error log
			//Application::Log(String::ArrayFormat($arrDefinedVars));
		} 

		// find the template file
		$arrUrl = explode('?', Application::$RequestUri);
		$strUrl = $arrUrl[0];
		$strUrl = preg_replace('/\/\/+/', '/', $strUrl);
		$arrPathInfo = explode('/', $strUrl);
		$strModule = $arrPathInfo[1];
		$strAction = $arrPathInfo[3];
		if (empty($strModule) && empty($this->strTemplate)) {
			// default controller/template
			$strTemplate = sprintf('%s/%s/templates/index.tpl.php', __DOCROOT__, __DEFAULT_CONTROLLER__);
		} else {
			if (!isset($this->strTemplate)) {
				$strTemplate = sprintf('%s/%s/templates/%s.tpl.php', __DOCROOT__, $strModule, $strAction);
			} else {
				$strTemplate = sprintf('%s/%s/templates/%s.tpl.php', __DOCROOT__, $strModule, $this->strTemplate);
			}
		}

		// if we're redirecting then we're not rendering a template, even if there is one available
		if (!Application::$NoRender) {
			try {
				if (file_exists($strTemplate)) {
					ob_start();
					require_once($strTemplate);
					$strEvaluatedTemplate = ob_get_contents();
					ob_end_clean();

					print $strEvaluatedTemplate;
				} else {
					// if the template file is missing, throw an exception
					throw new CustomException(Exceptions::TEMPLATE_NOT_FOUND, sprintf('Template: "%s" does not exist', $strTemplate));
				}
			} catch (CustomException $e) {
				print $e;
				exit;
			}
		}
	}
}
?>
