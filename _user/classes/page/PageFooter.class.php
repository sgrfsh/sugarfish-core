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

class PageFooter extends FooterBase {

	public function __construct() {
		parent::__construct();
	}

	protected function GetFooterContent() {
		$strOutput = '<div id="page_footer">';
		$strOutput .= '<div id="page_footer_lip">';
		$strOutput .= sprintf('<div class="sfc_logo"><a href="/dialog/popup/show" id="sugarfish_core" class="popup" title="sugarfish core: a lightweight scaffold" width="600" height="540"><img src="%s/logos/sfc_logo.png" style="padding:10px" /></a></div>', __IMAGES__);
		$strOutput .= '<div class="cf"></div>';
		$strOutput .= sprintf('<div id="footnote">This site is powered by <strong>Sugarfish Core</strong> version %s<br />Copyright &copy;2008-%s, <a href="http://www.sugarfish.org/" target="_new">Ian Atkin</a></div>', __VERSION__, date("Y"));
		$strOutput .= '</div>';
		$strOutput .= '<div class="cf"></div>';

		return $strOutput;
	}
}
?>
