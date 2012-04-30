<?php
/**
 * File: Footer.class.php
 * Created on: Sun Jul 25 23:23 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 */

class Footer extends FooterBase {

	public function __construct() {
		parent::__construct();
	}

	protected function GetFooterContent() {
		/*
		$strOutput = '<div id="footer">';
		$strOutput .= '</div>';
		$strOutput .= '<div class="cf"></div>';
		*/

		return $strOutput;
	}
}
?>
