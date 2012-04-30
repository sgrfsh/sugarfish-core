<?php
/**
 * File: RequestHandler.class.php
 * Created on: Thu Aug 26 00:13 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * 
 * @package sugarfish_core
 * @name RequestHandler
 */

class RequestHandler {

	public function Append() {

		if (count((array)$_GET) > 0) {
			foreach ($_GET as $strParam => $mixValue) {
				$this->$strParam = $mixValue;
			}
		}

		if (count((array)$_POST) > 0) {
			foreach ($_POST as $strParam => $mixValue) {
				$this->$strParam = $mixValue;
			}
		}
	}
}
?>
