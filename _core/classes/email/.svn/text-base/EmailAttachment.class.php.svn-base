<?php
/**
 * File : EmailAttachment.class.php
 * Created on: Wed Nov 12 01:57 CDT 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name EmailAttachment
 */

class EmailAttachment {
	protected $strFilePath;
	protected $strMimeType;
	protected $strFileName;
	protected $strEncodedFileData;

	public function __construct($strFilePath, $strSpecifiedMimeType = null, $strSpecifiedFileName = null) {
		// Set File Path
		if (!is_file(realpath($strFilePath))) {
			throw new Exception('File Not Found: ' . $strFilePath);
		}
		$this->strFilePath = realpath($strFilePath);


		// Set the File MIME Type -- if Explicitly Set, use it
		// otherwise, use MimeType to determine
		if ($strSpecifiedMimeType) {
			$this->strMimeType = $strSpecifiedMimeType;
		} else {
			$this->strMimeType = MimeType::GetMimeTypeForFile($this->strFilePath);
		}


		// Set the File Name -- if explicitly set, use it
		// Otherwise, use basename() to determine
		if ($strSpecifiedFileName) {
			$this->strFileName = $strSpecifiedFileName;
		} else {
			$this->strFileName = basename($this->strFilePath);
		}

		// Read file into a Base64 Encoded Data Stream
		$strFileContents = file_get_contents($this->strFilePath, false);
		$this->strEncodedFileData = chunk_split(base64_encode($strFileContents));
	}

	public function __get($strName) {
		switch ($strName) {
			case 'FilePath': return $this->strFilePath;
			case 'MimeType': return $this->strMimeType; 
			case 'FileName': return $this->strFileName;
			case 'EncodedFileData': return $this->strEncodedFileData;
			default:
				return parent::__get($strName);
		}
	}
}
?>
