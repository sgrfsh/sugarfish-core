<?php
/**
 * File: AjaxBase.class.php
 * Created on: Mon Jul 3 21:50 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name AjaxBase
 */

class AjaxBase {

	public function __construct() {

		$this->Initialize();

		// is this request a POST or GET?
		$arrArgs = empty($_GET)?$_POST:$_GET;

		if (array_key_exists('mode', $arrArgs)) {
			// get the contained method
			$strMethod = $arrArgs['mode'];

			// remove the 'mode'
			unset($arrArgs['mode']);

			// run the contained method
			//Application::Log(sprintf('Running AJAX (%s): Mode: %s; Arguments:<pre>%s</pre>', get_class($this), $strMethod, print_r($arrArgs, true)));
			$this->$strMethod($arrArgs);
		}
	}

	protected function Initialize() {}
}
?>
