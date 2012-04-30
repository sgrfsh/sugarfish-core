<?php
/**
 * File : Literal.class.php
 * Created on: Sat Sep 11 9:33 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name Literal
 */

class Literal {

	private $strValue;

	public function __construct($strValue) {
		$this->strValue = $strValue;
		return $this;
	}

	public function __get($strName) {
		switch ($strName) {
			case "Literal": return sprintf('%1$s%2$s%1$s', chr(39), addslashes($this->strValue));
		}
	}
}
?>
