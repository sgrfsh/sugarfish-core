<?php
/**
 * File : RadioButtonList.class.php
 * Created on: Sat Sep 11 21:21 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name RadioButtonList
 */

 class RadioButtonList extends GroupControl {

 	protected $arrChildControls = array();
 
 	public function __construct($objParentObject = null, $strControlId = null) {
		parent::__construct($objParentObject, $strControlId);

		$this->strControlId = $strControlId;
	}

	public function AddChildControl(FormControl $objControl) {
		array_push($this->arrChildControls, $objControl);
	}

	protected function GetControlHtml() {}

	public function Render() {
		foreach ($this->arrChildControls as $objChildControl) {
			$objChildControl->Render();
		}
	}
}
?>
