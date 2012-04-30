<?php
/**
 * File: Header.class.php
 * Created on: Mon Sep 6 22:58 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 */

class Header extends HeaderBase {

	public function __construct() {
		parent::__construct();

		$this->strMetaDesc = 'Ian Atkin. Web Systems Developer, Usability Specialist, Project Manager, Team Leader.';
		$this->strMetaKeywords = 'web, development, software, programmer, designer, usability, SEO, systems, architect, analyst';
	}

	protected function GetDocType() {
		$strOutput = "<!DOCTYPE html>\n\n";

		$strOutput .= "<!--\n";
		$strOutput .= sprintf("All code is copyright %s\n", Functions::Copyright(true, false));
		$strOutput .= "//-->\n\n";

		return $strOutput;
	}

	protected function GetHeadTag() {
		$strOutput = "<head>\n";
		$strOutput .= sprintf("\t<title>%s</title>\n", ($this->strPageTitle == '')?'Ian Atkin':$this->strPageTitle . ' | Ian Atkin');
		$strOutput .= sprintf("\t<meta http-equiv=\"content-type\" content=\"text/html; charset=%s\" />\n", Application::$EncodingType);
		$strOutput .= "\t<meta http-equiv=\"imagetoolbar\" content=\"false\" />\n";
		$strOutput .= sprintf("\t<meta name=\"description\" content=\"%s\" />\n", isset($this->strMetaDesc)?$this->strMetaDesc:'description');
		$strOutput .= sprintf("\t<meta name=\"keywords\" content=\"%s\" />\n", isset($this->strMetaKeywords)?$this->strMetaKeywords:'keywords');
		$strOutput .= sprintf("\t<meta name=\"generator\" content=\"Sugarfish Core (%s)\">\n", __VERSION__);
		$strOutput .= "\t<meta name=\"author\" content=\"Ian Atkin\" />\n";
		$strOutput .= "\t<link rev=\"made\" href=\"mailto:iatkin@sugarfish.org\" />\n";
		$strOutput .= "\t<link rel=\"home\" href=\"http://www.ianatkin.info/\" />\n";

		$strOutput .= "\t<link rel=\"shortcut icon\" href=\"/favicon.ico\" />\n";

		/*
		if (isset($strRss)) {
			$strOutput .= sprintf("%s\n", $strRss);
		}
		*/

		$strOutput .= sprintf("\t<link rel=\"stylesheet\" href=\"%s/global.css?v=%s\" type=\"text/css\" media=\"all\" />\n", __CSS__, __ASSET_VERSION__);
		$strOutput .= sprintf("\t<link rel=\"stylesheet\" href=\"%s/jquery/jquery-ui-1.8.5.custom.css?v=%s\" type=\"text/css\" media=\"all\" />\n", __CSS__, __ASSET_VERSION__);
		if (Application::IsBrowser(BrowserType::InternetExplorer)) {
			$strOutput .= sprintf("\t<link rel=\"stylesheet\" href=\"%s/ie.css?v=%s\" type=\"text/css\" media=\"all\" />\n", __CSS__, __ASSET_VERSION__);
		}

		$strOutput .= $this->strJavaScript;

		if (!is_null($this->strInlineJavaScript)) {
                        $strOutput .= sprintf("%s\n", $this->strInlineJavaScript);
                }

		$strOutput .= "</head>\n\n";
        
        $strOutput .= "<body>\n\n";

		return $strOutput;
	}
}
?>
