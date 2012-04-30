<?php
/**
 * File : Button.class.php
 * Created on: Fri Jul 16 21:03 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 */

 class Button {
 	protected $strControlId;

	public function __construct($strControlId = null) {
		$this->strControlId = $strControlId;
	}

	public function __set($strName, $mixValue) {
		switch ($strName) {
			case "ControlId":
				$this->strControlId = $mixValue;
				break;
		}
	}
}
?>
