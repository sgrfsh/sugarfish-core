<?php
/**
 * File:	FormHandler.class.php
 * Created on:  Thu Jul 15 9:34 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name FormHandler
 */    

class FormHandler implements TemplateManager {

	protected $strFormId;
	protected $strFormName;
	protected $strFormAction;
	protected $strFormMethod;
	protected $strFormTemplate;
	protected $arrControls = array();

	public function __construct($strFormId, $strFormName = null, $strFormAction = null, $strFormMethod = null) {

		try {
			if (empty($strFormId)) {
				throw new CustomException(Exceptions::NULL_FORM_ID, "Illegal Form Creation Error: No form ID given, expected string");
			} else {
				$this->strFormId = $strFormId;
			}
		} catch (CustomException $e) {
			print $e;
			exit;
		}

		if (!empty($strFormName)) {
			$this->strFormName = $strFormName;
		} else {
			$this->strFormName = $strFormId;
		}

		if (!empty($strFormAction)) {
			$this->strFormAction = $strFormAction;
		}

		if (!empty($strFormMethod)) {
			$this->strFormMethod = $strFormMethod;
		}

	}

	/**
	 * add child control to FormHandler or ListControl object
	 *
	 * @param $objControl
	 */
	public function AddChildControl($objControl) {
		array_push($this->arrControls, $objControl);
		//$this->Append($objControl);
	}

	/*
	public function Append($objControl) {
		try {
			if (array_key_exists($objControl->ControlId, $this->arrControls)) {
				throw new CustomException(Exceptions::DUPLICATE_CONTROL, sprintf("Control '%s' already exists in form", $objControl->ControlId));
			} else {
				array_push($this->arrControls, $objControl);
			}
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}
	*/

	/**
	 * render the form
	 *
	 */
	public function Render() {
		$strAttributes = sprintf('name="%s"', $this->strFormName);
		if (!empty($this->strFormAction)) {
			$strAttributes .= sprintf(' action="%s"', $this->strFormAction);
		}
		if (!empty($this->strFormMethod)) {
			$strAttributes .= sprintf(' method="%s"', $this->strFormMethod);
		}
		printf("\n<form id=\"%s\" %s>\n", $this->strFormId, $strAttributes);

		/**
		 * @todo: build out this method to handle all controls, either by way
		 * of a Form Template, or using HtmlBefore and HtmlAfter values
		 */
		foreach($this->arrControls as $objControl) {
			$objControl->Render();
		}

		print "\n</form>\n";
	}

	public function SetFormName($mixValue) {
		$this->strFormName = $mixValue;
		return $this;
	}

	public function SetFormAction($mixValue) {
		$this->strFormAction = $mixValue;
		return $this;
	}

	public function SetFormMethod($mixValue) {
		$this->strFormMethod = $mixValue;
		return $this;
	}

	public function SetFormTemplate($mixValue) {
		$this->strFormTemplate = $mixValue;
		return $this;
	}

	public function __get($strName) {
		switch ($strName) {
			case 'FormId':
				return $this->strFormId;
				break;
			case 'FormName':
				return $this->strFormName;
				break;
			case 'FormAction':
				return $this->strFormAction;
				break;
			case 'FormMethod':
				return $this->strFormMethod;

			default:
				try {
					throw new CustomException(Exceptions::ERROR, sprintf("FormHandler Property '%s' does not exist", $strName));
				} catch(CustomException $e) {
					print $e;
					exit;
				}
		}
	}

	public function __set($strName, $mixValue) {
		switch ($strName) {
			case 'FormName':
				$this->strFormName = $mixValue;
				break;
			case 'FormAction':
				$this->strFormAction = $mixValue;
				break;
			case 'FormMethod':
				$this->strFormMethod = $mixValue;
				break;
			case 'FormTemplate':
				$this->strFormTemplate = $mixValue;

			default:
				try {
					throw new CustomException(Exceptions::ERROR, sprintf("FormHandler Property '%s' does not exist", $strName));
				} catch(CustomException $e) {
					print $e;
					exit;
				}
		}
	}
}
?>
