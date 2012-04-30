<?php
/**
 * File: PageNavigator.class.php
 * Created on: Tue Mar 07 20:36 CST 2011
 *
 * @author Ian
 *
 * @copyright  2009-2011 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name PageNavigator
 */

class PageNavigator {
	protected $intCurrentPage;
	protected $intItemTotal;
	protected $intItemsPerPage;
	protected $strPagination;

	public function CreatePagination($intCurrentPage, $intItemTotal, $intItemsPerPage = 12) {
		$this->intCurrentPage = $intCurrentPage;
		$this->intItemTotal = $intItemTotal;
		$this->intItemsPerPage = $intItemsPerPage;

		// set up the variables we need
		$intLastPage = ceil($this->intItemTotal/$this->intItemsPerPage);
		$strPrevLink = '<div id="prev_page" class="prevlink"></div>';
		$strFirstPage = $this->intCurrentPage != 1?'<span id="page_1" class="firstpage">1</span>':'<div class="selected">1</div>';
		$strLastPage = $this->intCurrentPage != $intLastPage?sprintf('<span id="page_%1$s" class="lastpage">%1$s</span>', $intLastPage):sprintf('<div class="selected">%s</div>', $intLastPage);
		$strNextLink = '<div id="next_page" class="nextlink"></div>';
		$strSeparator = '<div class="ellipsis">&hellip;</div>';

		// create the pagination
		$this->strPagination = '<div class="pagination">';
		if ($this->intCurrentPage > 1) {
			$this->strPagination .= $strPrevLink;
		}
		$this->strPagination .= $strFirstPage;
		if ($this->intCurrentPage > 3) {
			$this->strPagination .= $strSeparator;
		}
		for ($i=$this->intCurrentPage-1; $i < $this->intCurrentPage+2; $i++) {
			if ($i > 1 && $i < $intLastPage) {
				$this->strPagination .= $i != $this->intCurrentPage?sprintf('<span id="page_%1$s">%1$s</span>', $i):sprintf('<div class="selected">%s</div>', $i);
			}
		}
		if ($this->intCurrentPage < $intLastPage-2) {
			$this->strPagination .= $strSeparator;
		}
		$this->strPagination .= $strLastPage;
		if ($this->intCurrentPage < $intLastPage) {
			$this->strPagination .= $strNextLink;
		}
		$this->strPagination .= '</div>';
	}

	public function __get($strName) {
		switch ($strName) {
			case 'Pagination':
				return $this->strPagination;
				break;
			case 'DisplayPagination':
				if ($this->intItemTotal > $this->intItemsPerPage) {
					return true;
				}
		}
	}
}
?>
