<?php
/**
 * File: AdminFooter.class.php
 * Created on: Sun Jul 25 23:23 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 */

class AdminFooter extends FooterBase {

	public function __construct() {
		parent::__construct();
	}

	protected function GetFooterContent() {
		$strOutput = "<div id=\"footer_wrap\">\n";
		$strOutput .= "\t<div id=\"footer\">\n";
		$strOutput .= "\t\t<div id=\"left\">\n";
		$strOutput .= sprintf("\t\t\t%s\n", Functions::Copyright());
		$strOutput .= "\t\t</div>\n\n";

		$strOutput .= "\t\t<div id=\"right\">\n";
		$strOutput .= sprintf("\t\t\t<img src=\"%s/logos/sfc_logo.png\" width=\"209\" height=\"45\" alt=\"sugarfish core\" /></a>\n", __IMAGES__);
		$strOutput .= "\t\t</div>\n";
		$strOutput .= "\t\t<div class=\"cf\"></div>\n";
		$strOutput .= "\t\t<div id=\"bottom\">\n";
		$strOutput .= "\t\t</div>\n";
		$strOutput .= "\t</div> <!--footer end-->\n";
		$strOutput .= "</div> <!--footer_wrap end-->\n\n";

		$strOutput .= sprintf("<div id=\"busy\"><img src=\"%s/spinner.gif\" width=\"220\" height=\"19\" class=\"spinner\" /></div>\n\n", __IMAGES__);

		$strOutput .= "</body>\n";
		$strOutput .= "</html>";

		return $strOutput;
	}
}
?>
