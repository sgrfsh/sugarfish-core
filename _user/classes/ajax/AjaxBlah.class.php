<?php
require_once "prepend.inc.php";

class AjaxBlah extends AjaxBase {

	protected function Initialize() {
		$this->objBlahModel = new BlahModel;
	}

	protected function keepAlive() {
		$this->objBlahModel->KeepAlive();
		print json_encode(array('status' => 'ok'));
	}

	protected function getOnlineUsers() {
		if ($arrResults = $this->objBlahModel->GetOnlineUsers()) {
			print json_encode($arrResults);
		}
	}

	protected function getStatus() {
		$arrResults = $this->objBlahModel->GetStatus();
		print json_encode($arrResults);
	}

	protected function setStatus($arrArgs) {
		$this->objBlahModel->SetStatus($arrArgs['status']);
		print json_encode(array('status' => 'ok'));
	}

    protected function checkForRecentMessages() {
        $arrResults = $this->objBlahModel->CheckForRecentMessages();
        print json_encode($arrResults);
    }

	protected function logMessage($arrArgs) {
		$strLabel = $arrArgs['label'];
		$strMessage = $arrArgs['message'];
		Application::Log(sprintf('%s: %s', $strLabel, $strMessage));
	}
}

new AjaxBlah;
?>
