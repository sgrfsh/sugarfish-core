<?php
require_once "prepend.inc.php";

class AjaxBlahwindow extends AjaxBase {

	protected function Initialize() {
		$this->objBlahModel = new BlahModel;
	}

	protected function processMessages($arrArgs) {
		$arrResults = $this->objBlahModel->ProcessMessages($arrArgs['sender_id']);
		print json_encode($arrResults);
	}

	protected function writeMessage($arrArgs) {
		$this->objBlahModel->WriteMessage($arrArgs['recipient_id'], $arrArgs['message_content']);
	}

	protected function logMessage($arrArgs) {
		$strLabel = $arrArgs['label'];
		$strMessage = $arrArgs['message'];
		Application::Log(sprintf('%s: %s', $strLabel, $strMessage));
	}
}

new AjaxBlahwindow;
?>
