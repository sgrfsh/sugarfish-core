<?php
/**
 * File : CodeHighlighter.class.php
 * Created on: Mon Sep 6 16:39 CDT 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish core
 */

/**
 * this class extends the GeSHi code highlighting class
 * 
 * source and documentation:
 * http://qbnz.com/highlighter
 * http://qbnz.com/highlighter/geshi-doc.html
 */
class CodeHighlighter extends GeSHi {

	public $strOutput;

	/**
	 * these methods are extended so we can chain them in our call
	 */
	public function SetHeaderType($strType) {
		$this->set_header_type($strType);
		return $this;
	}

	public function EnableLineNumbers($blnFlag, $intNthRow = 5) {
		$this->enable_line_numbers($blnFlag, $intNthRow);
		return $this;
	}

	public function SetLineNumberStart($intNumber) {
		$this->start_line_numbers_at($intNumber);
		return $this;
	}

	public function SetLineStyle($strStyle1, $strStyle2 = null, $blnPreserveDefaults = false) {
		$this->set_line_style($strStyle1, $strStyle2, $blnPreserveDefaults);
		return $this;
	}

	public function EnableKeywordLinks($blnEnable = true) {
		$this->enable_keyword_links($blnEnable);
		return $this;
	}

	public function SetTabWidth($intWidth) {
		$this->set_tab_width($intWidth);
		return $this;
	}

	/**
	 * extended so we can 'trim' the source file
	 */
	public function set_source($source) {
		$this->source = trim($source);
		$this->highlight_extra_lines = array();
	}

	/**
	 * extended so we can access output at any time
	 */
	public function ParseCode() {
		$this->strOutput = $this->parse_code();
	}

	public function __get($strName) {
		switch ($strName) {
			case 'Output':
				return $this->strOutput;
		}
	}
}
