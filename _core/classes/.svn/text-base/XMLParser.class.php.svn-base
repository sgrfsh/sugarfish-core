<?php
/**
 * File: XMLParser.class.php
 * Created on: Mon Oct 27 18:33 CST 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name XMLParser
 */

class XMLParser {
	protected $objParser;
	protected $strFilePath;
	protected $arrDocument;
	protected $arrCurrentTag;
	protected $arrTagStack;
	protected $blnTrimWhitespace;
   
	public function __construct($strFilePath) {
		$this->objParser = xml_parser_create();
		$this->strFilePath = $strFilePath;
		$this->arrDocument = array();
		$this->arrCurrentTag =& $this->arrDocument;
		$this->arrTagStack = array();
		$this->blnTrimWhitespace = true;
	}
   
	public function Parse($strFilePath = null) {       
		// check to see if alternate file is passed in
		if (!is_null($strFilePath)) {
			$this->strFilePath = $strFilePath;
		}

		if (!file_exists($this->strFilePath)) {
			Application::Log("File name '" . $this->strFilePath. "' does not exist", __FILE__, __LINE__, __FUNCTION__, __CLASS__);
			return false;
		}

		xml_set_object($this->objParser, $this);
		xml_set_character_data_handler($this->objParser, 'DataHandler');
		xml_set_element_handler($this->objParser, 'StartHandler', 'EndHandler');

		if (!($strFilePath = fopen($this->strFilePath, "r"))) {
			Application::Log("Cannot open XML data file: $this->strFilePath", __FILE__, __LINE__, __FUNCTION__, __CLASS__);
			return false;
		}

		while($strData = fread($strFilePath, 4096)) {   
			if (!xml_parse($this->objParser, $strData, feof($strFilePath))) {
				die(sprintf("XML error: %s at line %d",
					xml_error_string(xml_get_error_code($this->objParser)),
					xml_get_current_line_number($this->objParser)));
			}
		}

		fclose($strFilePath);
		xml_parser_free($this->objParser);

		return true;
	}
   
	function StartHandler($objParser, $strName, $strAttribs) {
		if (!isset($this->arrCurrentTag[$strName]))
		$this->arrCurrentTag[$strName] = array();
		$arrNewTag = array();
		if (!empty($strAttribs)) {
			$arrNewTag['attr'] = $strAttribs;
		}
		array_push($this->arrCurrentTag[$strName], $arrNewTag);
		$t =& $this->arrCurrentTag[$strName];
		$this->arrCurrentTag =& $t[count($t)-1];
		array_push($this->arrTagStack, $strName);
	}
   
	function DataHandler($objParser, $strData) {
		($this->blnTrimWhitespace) && $strData = trim($strData);
		if (!empty($strData)) {
			if (isset($this->arrCurrentTag['data'])) {
				$this->arrCurrentTag['data'] .= $strData;
			} else {
				$this->arrCurrentTag['data'] = $strData;
			}
		}
	}
   
	function EndHandler($objParser, $strName) {
		$this->arrCurrentTag =& $this->arrDocument;
		array_pop($this->arrTagStack);
		for($i = 0; $i < count($this->arrTagStack); $i++) {
			$t =& $this->arrCurrentTag[$this->arrTagStack[$i]];
			$this->arrCurrentTag =& $t[count($t)-1];
		}
	}

	/**
	 * Public Properties: GET
	 *
	 * @param string $strName
	 * @return mixed
	 */
	public function __get($strName) {
		switch ($strName) {
			case 'FilePath':
			    return $this->strFilePath;
			case 'document':
			case 'Document':
			    return $this->arrDocument;
			case 'TrimWhitespace':
			    return $this->blnTrimWhitespace;
			default:
			    throw new Exception('Datamember "' . $strName . '" does not exist!');
		}
	}

	/**
	 * Public Properties: SET
	 *
	 * @param string $strName
	 * @param mixed $mixValue
	 * @return mixed
	 */
	public function __set($strName, $mixValue) {
		switch ($strName) {
			case 'FilePath':
				return ($this->strFilePath = $mixValue);
				break;
			case 'TrimWhitespace':
				return ($this->blnTrimWhitespace = $mixValue);
				break;
			default:
				throw new Exception('Datamember "' . $strName . '" does not exist!');
				break;
		}
	}
}
?>
