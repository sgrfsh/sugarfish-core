<?php
/**
 * File:		YTEntity.class.php
 * Created on:	Mon Jul 12 22:22 CST 2010
 *
 * @name		YTEntity
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 */

class YTEntity {

	private $arrPayload;

	public function __construct($arrInput) {
		$this->arrPayload = $arrInput;
	}

	public function __get($strName) {
		switch ($strName) {
			case 'VideoArray':
				return $this->arrPayload;
		}
	}
}
?>
