<?php
/**
 * File : ListItem.class.php
 * Created on: Tue Apr 13 23:20 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name ListItem
 */

	class ListItem extends FormControl {
		protected $strIndex = null;
		protected $strValue = null;

		// attributes
		protected $objItemStyle;
		protected $blnSelected = false;
		protected $blnDisabled = false;

		public function __construct($strIndex, $strValue, $blnSelected = false, $blnDisabled = false) {
			$this->strIndex = $strIndex;
			$this->strValue = $strValue;
			$this->blnSelected = $blnSelected;
		}

		public function __get($strIndex) {
			switch ($strIndex) {
				case "Index":
					return $this->strIndex;
				case "Value":
					return $this->strValue;
				case "Selected":
					return $this->blnSelected;
				case "Disabled":
					return $this->blnDisabled;
				case "ItemStyle":
					return $this->objItemStyle;
			}
		}

		public function __set($strIndex, $mixValue) {
			switch ($strIndex) {
				case "Index":
					$this->strIndex = $mixValue;
					break;
				case "Value":
					$this->strValue = $mixValue;
					break;
				case "Selected":
					$this->blnSelected = $mixValue;
					break;
				case "Disabled":
					$this->blnDisabled = $mixValue;
					break;
				case "ItemStyle":
					$this->objItemStyle = $mixValue;
					break;
			}
		}
	}
?>
