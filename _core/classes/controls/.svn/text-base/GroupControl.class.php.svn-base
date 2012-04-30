<?php
/**
 * File : GroupControl.class.php
 * Created on: Tue Apr 13 23:01 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name GroupControl
 */

class GroupControl extends FormControlBase {

	public function __construct($objParentObject = null, $strControlId = null) {
		parent::__construct($objParentObject, $strControlId);

		try {
			if ($objParentObject instanceof FormHandler) {
				$objParentObject->AddChildControl($this);
			} else {
				throw new CustomException(Exceptions::INVALID_CONTROL_PARENT_OBJECT, 'ParentObject must be a FormHandler object');
			}
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

	public function Render() {}

	public function __get($strName) {
		switch ($strName) {
			case "ControlId": return $this->strControlId;

			default:
				try {
					throw new CustomException(Exceptions::ERROR, sprintf("GroupControl Property '%s' does not exist", $strName));
				} catch(CustomException $e) {
					print $e;
					exit;
				}
		}
	}
}
?>
