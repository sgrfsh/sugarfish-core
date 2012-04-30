<?php
/**
 * File: Menu.class.php
 * Created on: Mon Jun 1 23:00 CST 2009
 *
 * @author		Ian
 *
 * @copyright 	2009 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name Menu
 */

class Menu implements TemplateManager {
	private $strXmlFile;
	private $strMenuType;
	private $strPageKey;
	private $arrMenu;

	public function __construct($strXmlFile, $strMenuType = null, $strPageKey = null) {
		$this->strMenuType = $strMenuType;
		$this->strPageKey = $strPageKey;
		$this->arrMenu = array();

		switch($this->strMenuType) {
			case 'submenu':
				$this->strXmlFile = __XML__ . '/menu/submenu/' . $strXmlFile;
				break;
			case 'footer':
				$this->strXmlFile = __XML__ . '/menu/footer/' . $strXmlFile;
				break;
			default:
				$this->strXmlFile = __XML__ . '/menu/' . $strXmlFile;
		}

		if (file_exists($this->strXmlFile)) {
			$objParser = new XMLParser($this->strXmlFile);
	
			if (!$objParser->Parse()) {
				$strError = sprintf("xml parse failed %s, %d", __FILE__, __LINE__);
				Application::Log($strError);
				$this->arrMenu = array();
			} else {
				$this->arrMenu = $objParser->document['MENUS'][0]['MENU'];
				//print '<pre>' . print_r($this->arrMenu, true) . '</pre>';
			}
		} else {
			Application::Log(sprintf("%s doesn't exist, %s, %s", $this->strXmlFile, __FILE__, __LINE__));
			$this->arrMenu = array();
		}
	}

	public function Render($blnReturn = false) {
		switch($this->strMenuType) {
			case 'footer':
				if (!$blnReturn) {
					_p($this->RenderFooterMenu(), false);
				} else {
					return $this->RenderFooterMenu();
				}
				break;
			default:
				if (!$blnReturn) {
					_p($this->RenderMenu(), false);
				} else {
					return $this->RenderMenu();
				}
		}
	}

	private function RenderMenu() {
		$strMenuHTML = "<ul id=\"menu\">\n";
		foreach ($this->arrMenu as $objMenu) {
			$arrMenuItem = $objMenu['ITEM'][0];
			$arrSubMenu = $arrMenuItem['SUBMENU'];
			$blnSubMenu = !is_null($arrSubMenu);

			if ($arrMenuItem['ACTIVE'][0]['data'] == 1) {
				//get the URL
				$strHref = $arrMenuItem['URL'][0]['data'];
				$strXmlPageKey = is_null($arrMenuItem['PAGEKEY'][0]['data'])?'no':$arrMenuItem['PAGEKEY'][0]['data'];

				$strCloseLi = '</li>';
				$strDiv = '';
				if ($blnSubMenu) {
					$strCloseLi = '';
					$strDiv = "\t\t<div class=\"cf\"></div>\n";
				}
				if ($strXmlPageKey == '_new') {
					$strMenuHTML .= sprintf("\t<li><a href=\"%s\" target=\"_new\">%s</a>%s\n%s", $strHref, $arrMenuItem['NAME'][0]['data'], $strCloseLi, $strDiv);
				} else {
					//print $this->strPageKey . ' = ' . $strXmlPageKey;
					if ($strXmlPageKey == $this->strPageKey) {
						$strMenuHTML .= sprintf("\t<li class=\"active\"><a href=\"%s\">%s</a>%s\n%s", $strHref, $arrMenuItem['NAME'][0]['data'], $strCloseLi, $strDiv);
					} else {
						$strMenuHTML .= sprintf("\t<li><a href=\"%s\">%s</a>%s\n%s", $strHref, $arrMenuItem['NAME'][0]['data'], $strCloseLi, $strDiv);
					}
				}

				if ($blnSubMenu) {
					$strMenuHTML .= "\t\t<ul>\n";
					$intCount = count($arrSubMenu);
					$intCounter = 0;
					$strOpenSpan = '<span>';
					$strCloseSpan = '</span>';
					foreach ($arrSubMenu as $objSubMenu) {
						if ($intCounter == 0) {
							$strClass = ' class="top"';
						}
						if ($intCounter == $intCount-1) {
							$strClass = ' class="bot"';
							$strOpenSpan = '';
							$strCloseSpan = '';
						}
						$arrSubMenuItem = $objSubMenu['ITEM'][0];
						if ($arrSubMenuItem['ACTIVE'][0]['data'] == 1) {
							//get the URL
							$strSubHref = $arrSubMenuItem['URL'][0]['data'];
							$strXmlPageKey = is_null($arrSubMenuItem['PAGEKEY'][0]['data'])?'no':$arrSubMenuItem['PAGEKEY'][0]['data'];

							if ($strXmlPageKey == '_new') {
								$strMenuHTML .= sprintf("\t\t\t<li%s>%s<a href=\"%s\" target=\"_new\">%s</a>%s</li>\n", $strClass, $strOpenSpan, $strSubHref, $arrSubMenuItem['NAME'][0]['data'], $strCloseSpan);
							} else {
								$strMenuHTML .= sprintf("\t\t\t<li%s>%s<a href=\"%s\">%s</a>%s</li>\n", $strClass, $strOpenSpan, $strSubHref, $arrSubMenuItem['NAME'][0]['data'], $strCloseSpan);
							}
							//print '<pre>' . print_r($arrSubMenu, true) . ' </pre>';
							
						} // else item is disabled
						$intCounter++;
					}
					$strMenuHTML .= "\t\t</ul>\n";
				}

				if ($blnSubMenu) {
					$strMenuHTML .= "\t</li>\n";
				}

			} // else item is disabled
		}
		$strMenuHTML .= "</ul>";

		return $strMenuHTML;
	}

	private function RenderFooterMenu() {
		$strMenuHTML = "<ul>\n";
		foreach($this->arrMenu as $objMenu) {
			$arrMenuItem = $objMenu['ITEM'][0];
			if ($arrMenuItem['ACTIVE'][0]['data'] == 1) {
				//get the URL
				$strHref = $arrMenuItem['URL'][0]['data'];
			} // else item is disabled

			$strXmlPageKey = is_null($arrMenuItem['PAGEKEY'][0]['data'])?'no':$arrMenuItem['PAGEKEY'][0]['data'];

			if ($strXmlPageKey == '_new') {
				$strMenuHTML .= sprintf("\t<li><a href=\"%s\" target=\"_new\">%s</a></li>\n" , $strHref, $arrMenuItem['NAME'][0]['data']);
			} else {
				$strMenuHTML .= sprintf("\t<li><a href=\"%s\">%s</a></li>\n" , $strHref, $arrMenuItem['NAME'][0]['data']);
			}
		}
		$strMenuHTML .= "</ul>\n";

		return $strMenuHTML;
	}
}
?>
