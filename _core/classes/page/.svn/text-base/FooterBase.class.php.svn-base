<?php
/**
 * File: FooterBase.class.php
 * Created on: Sun Jul 25 23:23 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name FooterBase
 */

class FooterBase implements TemplateManager {
	protected static $blnInstance;

	public function __construct() {
		if (!self::$blnInstance) {
			self::$blnInstance = true;
		} else {
			try {
				throw new CustomException(Exceptions::MULTIPLE_SINGLETON_INSTANTIATION, "Footer can only be instantiated once");
			} catch (CustomException $e) {
				print $e;
				exit;
			}
		}
	}

	public function Render() {
		$strOutput = $this->GetFooterContent();
		$strOutput .= "</body>\n";
		$strOutput .= "</html>";

		print $strOutput;
	}

	protected function GetFooterContent() {}
}
?>
