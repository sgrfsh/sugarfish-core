<?php
/**
 * File: AdminiHeader.class.php
 * Created on: Mon Aug 2 19:03 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 */

class AdminHeader extends HeaderBase {

	protected $strJsXml = 'adm/js.xml';

	public function __construct() {
		parent::__construct();
	}

	protected function GetDocType() {
		$strOutput = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n";
		$strOutput .= "\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n\n";

		return $strOutput;
	}

	protected function GetHeadTag() {
		$strOutput .= "<head>\n";
		$strOutput .= sprintf("\t<title>%s</title>\n", ($this->strPageTitle == '')?'Ian Atkin':$this->strPageTitle . ' | Ian Atkin');
		$strOutput .= "\t<meta name=\"author\" content=\"Ian Atkin\" />\n";
		$strOutput .= "\t<link rev=\"made\" href=\"mailto:iatkin@sugarfish.org\" />\n";
		$strOutput .= "\t<link rel=\"home\" href=\"http://www.spookynoodles.com/\" />\n";

		if (!Application::$SecurePage) {
			$strOutput .= sprintf("\t<link rel=\"shortcut icon\" href=\"%s/favicon.ico\" />\n", __DOMAIN__);
		} else {
			$strOutput .= sprintf("\t<link rel=\"shortcut icon\" href=\"%s/favicon.ico\" />", __SECURE_DOMAIN__);
		}

		$strOutput .= sprintf("\t<link rel=\"stylesheet\" href=\"%s/adm/admin.css?v=%s\" type=\"text/css\" media=\"all\" />\n", __CSS__, __ASSET_VERSION__);

		$strOutput .= $this->strJavaScript;

		$strOutput .= "</head>\n\n";

		$strOutput .= "<body>\n\n";

		$strOutput .= "<div id=\"header_wrap\">\n";
		$strOutput .= "\t<div id=\"header\">\n\n";

		$strOutput .= "\t</div> <!--header end-->\n";
		$strOutput .= "</div> <!--header_wrap end-->\n\n";

		return $strOutput;
	}

	protected function GetHeaderContent() {
		// construct menu
		$objMenu = new Menu($this->strXmlMenuFile, 'menu', $this->strPageKey);
		if(isset($this->strXmlSubMenuFile)) {
			$this->objSubMenu = new Menu($this->strXmlSubMenuFile, 'submenu', $this->strSubPageKey);
		}

		$strOutput = '<div id="center">';
		$strOutput .= sprintf("\t<div class=\"menu_block\">%s</div>", $objMenu->Render());
		$strOutput .= '</div>';

		return $strOutput;
	}
}
?>
