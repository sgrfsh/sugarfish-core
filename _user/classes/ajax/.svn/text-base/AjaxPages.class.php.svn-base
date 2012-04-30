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

class AjaxPages extends AjaxBase {

	const __ROUTE__ = 'page/index/article/title';

	protected function Initialize() {
		$this->objPageModel = new PageModel;
	}

	protected function loadPage($arrArgs) {
		$intPage = $arrArgs['page'];
		$intNumItemsPerPage = 25;

		$intNumPages = count($arrPages = $this->objPageModel->getPages());

		$arrPages = array_slice($arrPages, ($intPage-1)*$intNumItemsPerPage, $intNumItemsPerPage);
		$objPageNavigator = new PageNavigator('loadPage', $intPage, $intNumPages, $intNumItemsPerPage, true);

		$strOutput = '<div style="float:right">';
			$strOutput .= '<div class="pagination">';
				if ($objPageNavigator->DisplayPagination) {
					$strOutput .= $objPageNavigator->Pagination;
				}
			$strOutput .= '</div>';
		$strOutput .= '</div>';
		$strOutput .= '<div class="cf"></div>';

		$strOutput .= '<ul>';
		foreach ($arrPages as $arrPage) {
			$strOutput .= sprintf("<li><a href=\"/%s/%s\">%s</a></li>", self::__ROUTE__, $arrPage['url'], $arrPage['title']);
		}
		$strOutput .= '</ul>';

		$strOutput .= '<div class="cf"></div>';
		$strOutput .= '<div style="float:right">';
			$strOutput .= '<div class="pagination">';
				if ($objPageNavigator->DisplayPagination) {
					$strOutput .= $objPageNavigator->Pagination;
				}
			$strOutput .= '</div>';
		$strOutput .= '</div>';

		print $strOutput;
	}

	protected function logMessage($arrArgs) {
		$strLabel = $arrArgs['label'];
		$strMessage = $arrArgs['message'];
		Application::Log(sprintf('%s: %s', $strLabel, $strMessage));
	}
}

new AjaxPages;
?>
