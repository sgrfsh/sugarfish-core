<?php
/**
 * File: ControlHandler.class.php
 * Created on: Sun Jul 18 11:10 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name ControlHandler
 */

class ControlHandler {

	//public $intNextId = 0;

	/**
	 * append control to this ControlHandler
	 *
	 * @param $mixControl
	 * @param string $strControlId
	 * @return ControlHandler object
	 */
	public function Append($mixControl, $strControlId = null) {
		/**
		 * special case: FormHandler contains a Form ID which is used in place of a given Control ID
		 * 
		 */
		/* we don't need this anymore
		if ($mixControl instanceof FormHandler) {
			$strControlId = $mixControl->FormId;
		}
		*/

		if (is_null($strControlId)) {
			// we need to create a sequential control id
			$strControlId = sprintf('c%s', Application::$NextControlId);
			Application::$NextControlId++;
		} else {
			// check for non-alphanumeric id
			try {
				$strMatches = array();
				$strPattern = '/[A-Za-z0-9]*/';
				preg_match($strPattern, $strControlId, $strMatches);
				if (!(count($strMatches) && ($strMatches[0] == $strControlId))) {
					throw new CustomException(Exceptions::NON_ALPHANUMERIC_CONTROL_ID, sprintf("Control Id '%s' is not alphanumeric", $strControlId));
				}
			} catch (CustomException $e) {
				print $e;
				exit;
			}

			// check if id exists already or if it resembles an auto-generated id
			try {
				if (preg_match("/c([0-9]+)/", $strControlId)) {
					throw new CustomException(Exceptions::ILLEGAL_CONTROL_ID, sprintf("Illegal Control ID: '%s'; resembles auto-generated Control ID", $strControlId));
				}
				if (isset($this->$strControlId)) {
					throw new CustomException(Exceptions::CONTROL_EXISTS, sprintf("Control '%s' already exists", $strControlId));
				}
			} catch (CustomException $e) {
				print $e;
				exit;
			}
		}

		$this->$strControlId = $mixControl;

		return $this;
	}

	/**
	 * accessor method to generate a new form
	 *
	 * @param string $strFormId
	 * @param string $strFormName
	 * @param string $strFormAction
	 * @param string $strFormMethod
	 * @return FormHandler object
	 */
	public function GenerateForm($strFormId, $strFormName = null, $strFormAction = null, $strFormMethod = null) {
		$this->$strFormId = new FormHandler($strFormId, $strFormName, $strFormAction, $strFormMethod);

		return $this->$strFormId;
	}
}
?>
