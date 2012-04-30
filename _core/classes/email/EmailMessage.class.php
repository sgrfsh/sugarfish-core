<?php
/**
 * File : EmailMessage.class.php
 * Created on: Wed Nov 12 01:57 CDT 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name EmailMessage
 */

class EmailMessage {
	protected $strFrom;
	protected $strTo;
	protected $strSubject;
	protected $strBody;
	protected $strHtmlBody;

	protected $strCc;
	protected $strBcc;
	protected $strHeaderArray = array();
	protected $objFileArray = array();

	public function __construct($strFrom = null, $strTo = null, $strSubject = null, $strBody = null) {
		$this->strFrom = $strFrom;
		$this->strTo = $strTo;

		// We must cleanup the Subject and Body -- use the Property to set
		$this->Subject = $strSubject;
		$this->Body = $strBody;
	}

	public function AddAttachment(EmailAttachment $objFile) {						
		$this->objFileArray[$objFile->FileName] = $objFile;
	}

	public function Attach($strFilePath, $strSpecifiedMimeType = null, $strSpecifiedFileName = null) {
		$this->AddAttachment(new EmailAttachment($strFilePath, $strSpecifiedMimeType, $strSpecifiedFileName));
	}

	public function RemoveAttachment($strFileName) {
		if (array_key_exists($strName, $this->objFileArray)) {
			unset($this->objFileArray[$strName]);
		}
	}

	public function SetHeader($strName, $strValue) {
		$this->strHeaderArray[$strName] = $strValue;
		return $this;
	}

	public function GetHeader($strName) {
		if (array_key_exists($strName, $this->strHeaderArray)) {
			return $this->strHeaderArray[$strName];
		}
		return null;
	}

	public function RemoveHeader($strName, $strValue) {
		if (array_key_exists($strName, $this->strHeaderArray)) {
			unset($this->strHeaderArray[$strName]);
		}
	}

	public function SetFrom($mixValue) {
		$this->strFrom = $mixValue;
		return $this;
	}

	public function SetTo($mixValue) {
		$this->strTo = $mixValue;
		return $this;
	}

	public function SetSubject($mixValue) {
		$strSubject = trim($mixValue);
		$strSubject = str_replace("\r", "", $strSubject);
		$strSubject = str_replace("\n", " ", $strSubject);
		$this->strSubject = $strSubject;
		return $this;
	}

	public function SetBody($mixValue) {
		$strBody = $mixValue;
		$strBody = str_replace("\r", "", $strBody);
		$strBody = str_replace("\n", "\r\n", $strBody);
		$this->strBody = $strBody;
		return $this;
	}

	public function SetHtmlBody($mixValue) {
		$strHtmlBody = $mixValue;
		$strHtmlBody = str_replace("\r", "", $strHtmlBody);
		$strHtmlBody = str_replace("\n", "\r\n", $strHtmlBody);
		$this->strHtmlBody = $strHtmlBody;
		return $this;
	}

	public function SetCc($mixValue) {
		$this->strCc = $mixValue;
		return $this;
	}

	public function SetBcc($mixValue) {
		$this->strBcc = $mixValue;
		return $this;
	}

	public function __get($strName) {
		switch ($strName) {
			case 'From': return $this->strFrom;
			case 'To': return $this->strTo;
			case 'Subject': return $this->strSubject;
			case 'Body': return $this->strBody;
			case 'HtmlBody': return $this->strHtmlBody;

			case 'Cc': return $this->strCc;
			case 'Bcc': return $this->strBcc;

			case 'HeaderArray': return $this->strHeaderArray;
			case 'FileArray': return $this->objFileArray;
			case 'HasFiles': return (count($this->objFileArray) > 0) ? true : false;
		}
	}

	public function __set($strName, $mixValue) {
		switch ($strName) {
			case 'From': return ($this->strFrom = $mixValue);
			case 'To': return ($this->strTo = $mixValue);
			case 'Subject':
				$strSubject = trim($mixValue);
				$strSubject = str_replace("\r", "", $strSubject);
				$strSubject = str_replace("\n", " ", $strSubject);
				return ($this->strSubject = $strSubject);
			case 'Body':
				$strBody = $mixValue;
				$strBody = str_replace("\r", "", $strBody);
				$strBody = str_replace("\n", "\r\n", $strBody);
				return ($this->strBody = $strBody);
			case 'HtmlBody':
				$strHtmlBody = $mixValue;
				$strHtmlBody = str_replace("\r", "", $strHtmlBody);
				$strHtmlBody = str_replace("\n", "\r\n", $strHtmlBody);
				return ($this->strHtmlBody = $strHtmlBody);

			case 'Cc': return ($this->strCc = $mixValue);
			case 'Bcc': return ($this->strBcc = $mixValue);
		}
	}
}
?>
