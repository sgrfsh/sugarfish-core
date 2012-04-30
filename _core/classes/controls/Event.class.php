<?php
/**
 * File: Event.class.php
 * Created on: Fri Sep 10 08:14 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name Event
 */

class Event {
	protected $strJavaScriptEvent;
	protected $intDelay;

	public function __construct($intDelay = 0) {
		try {
			if ($intDelay) {
				$this->intDelay = $intDelay;
			}
		} catch (Exception $e) {
			print $e;
			exit;
		}
	}

	public function __get($strName) {
		switch ($strName) {
			case 'JavaScriptEvent':
				return $this->strJavaScriptEvent;
			case 'Delay':
				return $this->intDelay;
			default:
				throw new Exception(sprintf("Event Property '%s' does not exist", $strName));
		}
	}
}
?>
