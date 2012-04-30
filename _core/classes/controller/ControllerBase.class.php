<?php
/**
 * File: ControllerBase.class.php
 * Created on: Sat Jul 17 01:06 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * 
 * @package sugarfish_core
 * @name PageBase
 */

abstract class ControllerBase implements TemplateManager {

	public $_CONTROL;
	public $_PARAM;

	public $strTemplate;

	public function __construct() {
		$this->_CONTROL = new ControlHandler;
		$this->_PARAM = new RequestHandler;
		$this->Initialize();
	}

	protected function Initialize() {
		try {
			throw new CustomException(Exceptions::INVALID_INSTANTIATION_ATTEMPT, "ControllerBase should never be instantiated directly");
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

	public function Render() {}

	protected function GetControls() {
		/**
		 * first, we test the _CONTROL object to see if it has params;
		 * if it does then we pass it on to '$_CONTROL';
		 * this means we can use it without referencing '$this'
		 * all over the template;
		 * then we unset the original object, freeing some memory
		 */
		if (count((array)$this->_CONTROL) > 0) {
			$objControl = $this->_CONTROL;
		}
		unset($this->_CONTROL);

		return $objControl;
	}

	protected function GetParams() {
		/**
		 * first, we test the _PARAM object to see if it has params;
		 * if it does then we pass it on to '$_PARAM';
		 * this means we can use it without referencing '$this'
		 * all over the template;
		 * then we unset the original object, freeing some memory
		 */
		$this->_PARAM->Append();

		if (count((array)$this->_PARAM) > 0) {
			$objParam = $this->_PARAM;
		}
		unset($this->_PARAM);

		return $objParam;
	}

	public function ActionErrorHandler($strController, $strAction) {
		throw new CustomException(Exceptions::ERROR, sprintf("Call to undefined action: '%s->%s()'", $strController, $strAction));
	}

	public function __set($strName, $strValue) {
		switch ($strName) {
			case 'Template':
				$this->strTemplate = $strValue;
				break;
			default:
				$this->$strName = $strValue;
		}
	}
}
?>
