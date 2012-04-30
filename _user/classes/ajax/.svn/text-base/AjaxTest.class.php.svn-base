<?php
/**
 * File: AjaxTest.class.php
 * Created on: Mon Jul 3 22:05 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 */

require_once "prepend.inc.php";

class AjaxTest extends AjaxBase {

	protected function test($arrArgs) {
		//print json_encode(array("strReturn" => $arrArgs['str'], "strCrap" => $arrArgs['crap']));
		print json_encode(array("strReturn" => $arrArgs['str']));
		/* or plain text
		print $arrArgs['str'];
		*/
	}
}

new AjaxTest;
?>
