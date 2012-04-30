<?php
require_once "prepend.inc.php";

class AjaxJSTest extends AjaxBase {

	protected function Initialize() {
		$this->objJSTestModel = new JSTestModel;
	}

	protected function getMessage($arrArgs) {
		$intMessageId = $arrArgs['message_id'];
		$strResult = $this->objJSTestModel->GetMessage($intMessageId);
		print json_encode($strResult);
	}

	protected function getTags($arrArgs) {
		$intItemId = $arrArgs['item_id'];
		$arrResults = $this->objJSTestModel->GetTags($intItemId);
		print json_encode($arrResults);
	}
}

new AjaxJSTest;
?>
