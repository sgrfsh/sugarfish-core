<?php
/**
 * File: HeaderBase.class.php
 * Created on: Mon Sep 6 22:58 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name HeaderBase
 */

class HeaderBase implements TemplateManager {
	protected static $blnInstance;

	protected $strPageId = 'NotSet';
	protected $strPageTitle;

	protected $strMetaDesc;
	protected $strMetaKeywords;

	protected $strXmlMenuFile;
	protected $strXmlSubMenuFile;
	protected $strPageKey;
	protected $strSubPageKey;

	protected $strJavaScriptMode;
	protected $objXML;
	protected $strJavaScript;
	protected $strInlineJavaScript;

	protected $strJavaScriptXmlFile = 'js.xml';

	protected $strBodyTag = null;

	public function __construct() {
		if (!self::$blnInstance) {
			self::$blnInstance = true;
		} else {
			try {
				throw new CustomException(Exceptions::MULTIPLE_SINGLETON_INSTANTIATION, "Header can only be instantiated once");
			} catch (CustomException $e) {
				print $e;
				exit;
			}
		}
	}

	public function Render() {
		try {
			if (!empty($this->strPageId)) {

				// construct JavaScript
				if (!is_null($this->strJavaScriptXmlFile)) {
					$this->GetJavaScript();
				}

				$strOutput = $this->GetDocType();

				if (!Application::$SecurePage) {
					$strOutput .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n\n";
				} else {
					$strOutput .= "<html>\n\n";
				}

				$strOutput .= $this->GetHeadTag();

				if (!empty($this->strBodyTag)) {
					$strOutput .= "<body>\n\n";
				} else {
					$strOutput .= $this->strBodyTag;
				}

				$strOutput .= $this->GetHeaderContent();

				print $strOutput;
			} else {
				throw new CustomException(Exceptions::PAGE_ID_NOT_SET, "Page ID not set when Render() called");
			}
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

	protected function GetDocType() {
		$strOutput = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n";
		$strOutput .= "\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n\n";

		return $strOutput;
	}

	protected function GetHeadTag() {
		$strOutput = "<head>\n";

		if (!is_null($this->strPageTitle)) {
			$strOutput .= sprintf("\t<title>%s</title>\n", $this->strPageTitle);
		}

		$strOutput .= sprintf("\t<meta http-equiv=\"content-type\" content=\"text/html; %s/\">\n", Application::$EncodingType);

		if (!Application::$SecurePage) {
			$strOutput .= sprintf("\t<link rel=\"shortcut icon\" href=\"%s/favicon.ico\" />\n", __DOMAIN__);
		} else {
			$strOutput .= sprintf("\t<link rel=\"shortcut icon\" href=\"%s/favicon.ico\" />", __SECURE_DOMAIN__);
		}

		$strOutput .= $this->strJavaScript;

		if (!is_null($this->strInlineJavaScript)) {
			$strOutput .= sprintf("%s\n", $this->strInlineJavaScript);
		}

		$strOutput .= "</head>\n\n";

		return $strOutput;
	}

	protected function GetHeaderContent() {}

	protected function GetJavaScript() {
		$this->objXML = simplexml_load_file(sprintf('%s/%s', __XML__, $this->strJavaScriptXmlFile));

		$this->ParseJavaScriptXML('global');

		// if strJavaScriptMode is null then load the JavaScript off of the page name
		$strPageId = is_null($this->strJavaScriptMode)?$this->strPageId:$this->strJavaScriptMode;
		$this->ParseJavaScriptXML($strPageId);
	}

	protected function ParseJavaScriptXML($strSearch) {
		$arrResult = $this->objXML->xpath($strSearch . '/file');
		while(list( , $strFile) = each($arrResult)) {
			foreach ($strFile->attributes() as $keyFile => $strAttr) {
				if ($keyFile == 'type') {
					$strType = $strAttr;
				}
			}

			switch ($strType) {
				case 'internal':
					$this->strJavaScript .= sprintf("\t<script type=\"text/javascript\" src=\"%s/%s?v=%s\" charset=\"utf-8\"></script>\n", __JAVASCRIPT__, $strFile, __ASSET_VERSION__);
					break;
				case 'external':
					$this->strJavaScript .= sprintf("\t<script type=\"text/javascript\" src=\"%s\" charset=\"utf-8\"></script>\n", $strFile);
			}
		}
	}

	public function SetPageId($strValue) {
		$this->strPageId = $strValue;
		return $this;
	}

	public function SetPageTitle($strValue) {
		$this->strPageTitle = $strValue;
		return $this;
	}

	public function SetMetaDesc($strValue) {
		$this->strMetaDesc = $strValue;
		return $this;
	}

	public function SetMetaKeywords($strValue) {
		$this->strKeywords = $strValue;
		return $this;
	}

	public function SetMenuFile($strValue) {
		$this->strXmlMenuFile = $strValue;
		return $this;
	}

	public function SetPageKey($strValue) {
		$this->strPageKey = $strValue;
		return $this;
	}

	public function SetSubMenuFile($strValue) {
		$this->strXmlSubMenuFile = $strValue;
		return $this;
	}

	public function SetSubPageKey($strValue) {
		$this->strSubPageKey = $strValue;
		return $this;
	}

	public function SetJavaScriptMode($strValue) {
		$this->strJavaScriptMode = $strValue;
		return $this;
	}

	public function SetJavaScriptXmlFile($strValue) {
		$this->strJavaScriptXmlFile = $strValue;
		return $this;
	}

	public function SetInlineJavaScript($strValue) {
		$this->strInlineJavaScript = $strValue;
		return $this;
	}

	public function SetBodyTag($strValue) {
		$this->strBodyTag = $strValue;
		return $this;
	}

	public function __set($strName, $mixValue) {
		switch ($strName) {
			case 'PageTitle':
				return ($this->strPageTitle = $mixValue);
			case 'MetaDesc':
				return ($this->strMetaDesc = $mixValue);
			case 'MetaKeywords':
				return ($this->strKeywords = $mixValue);
			case 'MenuFile':
				return ($this->strXmlMenuFile = $mixValue);
			case 'PageKey':
				return ($this->strPageKey = $mixValue);
			case 'SubMenuFile':
				return ($this->strXmlSubMenuFile = $mixValue);
			case 'SubPageKey':
				return ($this->strSubPageKey = $mixValue);
			case 'JavaScriptMode':
				return ($this->strJavaScriptMode = $mixValue);
			case 'JavaScriptXmlFile':
				return ($this->strJavaScriptXmlFile = $mixValue);
			case 'InlineJavaScript':
				return ($this->strInlineJavaScript = $mixValue);
			case 'BodyTag':
				return ($this->strBodyTag = $mixValue);
		}
	}
}
?>
