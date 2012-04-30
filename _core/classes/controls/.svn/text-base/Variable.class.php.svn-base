<?php
/**
 * File : Variable.class.php
 * Created on: Sat Sep 11 9:33 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name Variable
 */

class Variable {

	private $strValue;

	public function __construct($strValue) {
		$this->strValue = $strValue;
		return $strValue;
	}

	public function __get($strName) {
		switch ($strName) {
			case "Variable": return $this->strValue;
		}
	}
}
?>
