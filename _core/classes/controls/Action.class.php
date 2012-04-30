<?php
/**
 * File: Action.class.php
 * Created on: Fri Sep 10 23:15 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name Action
 */

class Action {

	protected $objEvent;
	protected $strMethodName;
	protected $mixParameters;

	public function __construct($strMethodName = null, $mixParameters = null) {
		$this->strMethodName = $strMethodName;
		$this->mixParameters = $mixParameters;
	}

	public static function RenderActions(FormControl $objControl, $strEventName, $objActions) {
		$strToReturn = '';

		if ($objActions && count($objActions)) {
			foreach ($objActions as $objAction) {
				if ($objAction->objEvent->JavaScriptEvent != $strEventName) {
					throw new Exception('Invalid Action Event in this entry in the ActionArray');
				}

				if ($objAction->objEvent->Delay > 0) {
					$strCode = sprintf("sf.setTimeout('%s', '%s', %s);", $objControl->ControlId, addslashes($objAction->RenderScript($objControl)), $objAction->objEvent->Delay);
				} else {
					$strCode = chr(32) . $objAction->RenderScript($objControl);
				}

				$strToReturn .= $strCode;
			}
		}

		if ($objControl->ReturnFalse) {
			$strToReturn .= ' return false;';
		}

		if (strlen($strToReturn)) {
			return sprintf('%s="%s" ', $strEventName, substr($strToReturn, 1));
		} else {
			return null;
		}
	}

	public function RenderScript(FormControl $objControl) {
		if (is_array($this->mixParameters)) {
			$strParameters = '';
			$i = 1;
			foreach ($this->mixParameters as $objParameter) {
				$strParameter = ($objParameter instanceof Variable)?$objParameter->Variable:$objParameter->Literal;
				$strParameters .= sprintf("%s%s ", $strParameter, ($i < count($this->mixParameters))?',':'');
				$i++;
			}
			return trim(sprintf("%s(%s); ", $this->MethodName, trim($strParameters)));
		} else {
			$strParameter = ($this->mixParameters instanceof Variable)?$this->mixParameters->Variable:$this->mixParameters->Literal;
			return trim(sprintf("%s(%s); ", $this->MethodName, $strParameter));
		}
	}

	public function __set($strName, $mixValue) {
		switch ($strName) {
			case 'Event':
				return ($this->objEvent = $mixValue);
			default:
				throw new Exception(sprintf("Action Property '%s' does not exist", $strName));
		}
	}
	
	public function __get($strName) {
		switch ($strName) {
			case 'Event': return $this->objEvent;
			case 'MethodName': return $this->strMethodName;
			default:
				throw new Exception(sprintf("Action Property '%s' does not exist", $strName));
		}
	}
}
?>
