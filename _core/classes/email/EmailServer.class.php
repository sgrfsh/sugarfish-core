<?php
/**
 * File : EmailServer.class.php
 * Created on: Wed Nov 12 01:57 CDT 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name EmailServer
 */
abstract class EmailServer {
	/**
	 * @var string SmtpServer
	 */
	public static $SmtpServer = 'localhost';

	/**
	 * @var integer SmtpPort
	 */
	public static $SmtpPort = 25;

	/**
	 * @var string OriginatingServerIp
	 */
	public static $OriginatingServerIp;

	/**
	 * @var boolean $TestMode
	 */
	public static $TestMode = false;

	/**
	 * @var string $TestModeDirectory
	 */		
	public static $TestModeDirectory = '/tmp';

	/**
	 * @var bool $AuthPlain
	 */
	public static $AuthPlain = false;

	/**
	 * @var bool $AuthLogin
	 */
	public static $AuthLogin = false;

	/**
	 * @var string $SmtpUsername
	 */
	public static $SmtpUsername = '';

	/**
	 * @var string $SmtpPassword
	 */
	public static $SmtpPassword = '';

	/**
	 * @var string $EncodingType
	 */
	public static $EncodingType = null;

	/**
	 * @param string $strAddresses Single string containing e-mail addresses and anything else
	 * @return string[] An array of e-mail addresses only, or NULL if none
	 */
	public static function GetEmailAddresses($strAddresses) {
		$strAddressArray = null;

		// Address Lines cannot have any linebreaks
		if ((strpos($strAddresses, "\r") !== false) || (strpos($strAddresses, "\n") !== false)) {
			return null;
		}

		preg_match_all ("/[a-zA-Z0-9_.+-]+[@][\-a-zA-Z0-9_.]+/", $strAddresses, $strAddressArray);
		if (
			(is_array($strAddressArray)) &&
			(array_key_exists(0, $strAddressArray)) &&
			(is_array($strAddressArray[0])) &&
			(array_key_exists(0, $strAddressArray[0]))
		) {
			return $strAddressArray[0];
		}

		return null;
	}

	/**
	 * @param EmailMessage $objMessage Message to Send
	 * @return void
	 */
	public static function Send(EmailMessage $objMessage) {
		$objResource = null;

		if (EmailServer::$TestMode) {
			// Open up a File Resource to the TestModeDirectory
			$strArray = split(' ', microtime());
			$strFileName = sprintf('%s/email_%s%s.txt', EmailServer::$TestModeDirectory, $strArray[1], substr($strArray[0], 1));
			$objResource = fopen($strFileName, 'w');
			if (!$objResource) {
				throw new Exception(sprintf('Unable to open Test SMTP connection to: %s', $strFileName));
			}

			// Clear the Read Buffer
			if (!feof($objResource)) {
				fgets($objResource, 4096);
			}

			// Write the Connection Command
			fwrite($objResource, sprintf("telnet %s %s\r\n", EmailServer::$SmtpServer, EmailServer::$SmtpPort));
		} else {
			$objResource = fsockopen(EmailServer::$SmtpServer, EmailServer::$SmtpPort);
			if (!$objResource) {
				throw new Exception(sprintf('Unable to open SMTP connection to: %s %s', EmailServer::$SmtpServer, EmailServer::$SmtpPort));
			}
		}

		// Connect
		$strResponse = null;
		if (!feof($objResource)) {
			$strResponse = fgets($objResource, 4096);

			// Iterate through all "220-" responses (stop at "220 ")
			while ((substr($strResponse, 0, 3) == "220") && (substr($strResponse, 0, 4) != "220 ")) {
				if (!feof($objResource)) {
					$strResponse = fgets($objResource, 4096);
				}
			}

			// Check for a "220" response
			if ((strpos($strResponse, "220") === false) || (strpos($strResponse, "220") != 0)) {
				throw new Exception(sprintf('Error Response on Connect: %s', $strResponse));
			}
		}

		// Send: EHLO
		/*
		fwrite($objResource, sprintf("EHLO %s\r\n", EmailServer::$OriginatingServerIp));
		if (!feof($objResource)) {
			$strResponse = fgets($objResource, 4096);

			// Iterate through all "250-" responses (stop at "250 ")
			while ((substr($strResponse, 0, 3) == "250") && (substr($strResponse, 0, 4) != "250 ")) {
				if (!feof($objResource)) {
					$strResponse = fgets($objResource, 4096);
				}
			}

			// Check for a "250" response
			if ((strpos($strResponse, "250") === false) || (strpos($strResponse, "250") != 0)) {
				throw new Exception(sprintf('Error Response on EHLO: %s', $strResponse));
			}
		}
		*/

		// Send Authentication
		if (EmailServer::$AuthPlain) {
			fwrite($objResource, "AUTH PLAIN " . base64_encode(EmailServer::$SmtpUsername . "\0" . EmailServer::$SmtpUsername . "\0" . EmailServer::$SmtpPassword) . "\r\n");
			if (!feof($objResource)) {
				$strResponse = fgets($objResource, 4096);
				if ((strpos($strResponse, "235") === false) || (strpos($strResponse, "235") != 0)) {
					throw new Exception(sprintf('Error in response from AUTH PLAIN: %s', $strResponse));
				}
			}
		}

		if (EmailServer::$AuthLogin) {
			fwrite($objResource,"AUTH LOGIN\r\n");
			if (!feof($objResource)) {
				$strResponse = fgets($objResource, 4096);
				if ((strpos($strResponse, "334") === false) || (strpos($strResponse, "334") != 0)) {
					throw new Exception(sprintf('Error in response from AUTH LOGIN: %s', $strResponse));
				}
			}

			fwrite($objResource, base64_encode(EmailServer::$SmtpUsername) . "\r\n");
			if (!feof($objResource)) {
				$strResponse = fgets($objResource, 4096);
				if ((strpos($strResponse, "334") === false) || (strpos($strResponse, "334") != 0)) {
					throw new Exception(sprintf('Error in response from AUTH LOGIN: %s', $strResponse));
				}
			}

			fwrite($objResource, base64_encode(EmailServer::$SmtpPassword) . "\r\n");
			if (!feof($objResource)) {
					$strResponse = fgets($objResource, 4096);
				if ((strpos($strResponse, "235") === false) || (strpos($strResponse, "235") != 0)) {
					throw new Exception(sprintf('Error in response from AUTH LOGIN: %s', $strResponse));
				}
			}
		}

		// Setup MAIL FROM line
		$strAddressArray = EmailServer::GetEmailAddresses($objMessage->From);
		if (count($strAddressArray) != 1) {
			throw new Exception(sprintf('Not a valid From address: %s', $objMessage->From));
		}

		// Send: MAIL FROM line
		fwrite($objResource, sprintf("MAIL FROM: <%s>\r\n", $strAddressArray[0]));			
		if (!feof($objResource)) {
			$strResponse = fgets($objResource, 4096);
			
			// Check for a "250" response
			if ((strpos($strResponse, "250") === false) || (strpos($strResponse, "250") != 0)) {
				throw new Exception(sprintf('Error Response on MAIL FROM: %s', $strResponse));
			}
		}

		// Setup RCPT TO line(s)
		$strAddressToArray = EmailServer::GetEmailAddresses($objMessage->To);
		if (!$strAddressToArray) {
			throw new Exception(sprintf('Not a valid To address: %s', $objMessage->To));
		}

		$strAddressCcArray = EmailServer::GetEmailAddresses($objMessage->Cc);
		if (!$strAddressCcArray) {
			$strAddressCcArray = array();
		}

		$strAddressBccArray = EmailServer::GetEmailAddresses($objMessage->Bcc);
		if (!$strAddressBccArray) {
			$strAddressBccArray = array();
		}

		$strAddressCcBccArray = array_merge($strAddressCcArray, $strAddressBccArray);
		$strAddressArray = array_merge($strAddressToArray, $strAddressCcBccArray);

		// Send: RCPT TO line(s)
		foreach ($strAddressArray as $strAddress) {
			fwrite($objResource, sprintf("RCPT TO: <%s>\r\n", $strAddress));
			if (!feof($objResource)) {
				$strResponse = fgets($objResource, 4096);
				
				// Check for a "250" response
				if ((strpos($strResponse, "250") === false) || (strpos($strResponse, "250") != 0)) {
					throw new Exception(sprintf('Error Response on RCPT TO: %s', $strResponse));
				}
			}
		}

		// Send: DATA
		fwrite($objResource, "DATA\r\n");
		if (!feof($objResource)) {
			$strResponse = fgets($objResource, 4096);
			
			// Check for a "354" response
			if ((strpos($strResponse, "354") === false) || (strpos($strResponse, "354") != 0)) {
				throw new Exception(sprintf('Error Response on DATA: %s', $strResponse));
			}
		}

		// Send: Required Headers
		fwrite($objResource, sprintf("Date: %s\r\n", date(DateFormats::RFC2822)));
		fwrite($objResource, sprintf("To: %s\r\n", $objMessage->To));
		fwrite($objResource, sprintf("From: %s\r\n", $objMessage->From));

		// Send: Optional Headers
		if ($objMessage->Subject) {
			fwrite($objResource, sprintf("Subject: %s\r\n", $objMessage->Subject));
		}
		if ($objMessage->Cc) {
			fwrite($objResource, sprintf("Cc: %s\r\n", $objMessage->Cc));
		}

		// Send: Content-Type Header (if applicable)
		$semi_random = md5(time());			
		$strBoundary = sprintf('==emailserver_multipart_boundary____x%sx', $semi_random);
		
		// Send: Other Headers (if any)
		foreach ($objArray = $objMessage->HeaderArray as $strKey => $strValue) {
			fwrite($objResource, sprintf("%s: %s\r\n", $strKey, $strValue));
		}

		// if we are adding an html or files to the message we need these headers.
		if ($objMessage->HasFiles || $objMessage->HtmlBody) {
			fwrite($objResource, "MIME-Version: 1.0\r\n");
			fwrite($objResource, sprintf("Content-Type: multipart/mixed;\r\n boundary=\"%s\"\r\n", $strBoundary));
			fwrite($objResource, sprintf("This is a multipart message in MIME format.\r\n\r\n"));
			fwrite($objResource, sprintf("--%s\r\n", $strBoundary));				
		}					

		$strAltBoundary = sprintf('==emailserver_alternative_boundary____x%sx', $semi_random);

		// Send: Body

		// Setup Encoding Type (use EmailServer if specified, otherwise default to Application's)
		if (!($strEncodingType = EmailServer::$EncodingType)) {
			$strEncodingType = Application::$EncodingType;
		}

		if ($objMessage->HtmlBody) {
			fwrite($objResource, sprintf("Content-Type: multipart/alternative;\r\n boundary=\"%s\"\r\n\r\n", $strAltBoundary));
			fwrite($objResource, sprintf("--%s\r\n", $strAltBoundary));
			fwrite($objResource, sprintf("Content-Type: text/plain; charset=\"%s\"\r\n", $strEncodingType));
			fwrite($objResource, sprintf("Content-Transfer-Encoding: 7bit\r\n\r\n"));
			fwrite($objResource, $objMessage->Body);
			fwrite($objResource, "\r\n\r\n");
			fwrite($objResource, sprintf("--%s\r\n", $strAltBoundary));
			fwrite($objResource, sprintf("Content-Type: text/html; charset=\"%s\"\r\n", $strEncodingType));
			fwrite($objResource, sprintf("Content-Transfer-Encoding: quoted-printable\r\n\r\n"));								
			fwrite($objResource, $objMessage->HtmlBody);
			fwrite($objResource, "\r\n\r\n");
			fwrite($objResource, sprintf("--%s--\r\n", $strAltBoundary));
		} elseif ($objMessage->HasFiles) {
			fwrite($objResource, sprintf("Content-Type: multipart/alternative;\r\n boundary=\"%s\"\r\n\r\n", $strAltBoundary));				
			fwrite($objResource, sprintf("--%s\r\n", $strAltBoundary));
			fwrite($objResource, sprintf("Content-Type: text/plain; charset=\"%s\"\r\n", $strEncodingType));
			fwrite($objResource, sprintf("Content-Transfer-Encoding: 7bit\r\n\r\n"));
			fwrite($objResource, $objMessage->Body);
			fwrite($objResource, "\r\n\r\n");
			fwrite($objResource, sprintf("--%s--\r\n", $strAltBoundary));
		} else {
			fwrite($objResource, "\r\n" . $objMessage->Body);
		}

		// Send: File Attachments
		if($objMessage->HasFiles) {
			foreach ($objArray = $objMessage->FileArray as $objFile) {
				fwrite($objResource, sprintf("--%s\r\n", $strBoundary));
				fwrite($objResource, sprintf("Content-Type: %s;\r\n", $objFile->MimeType ));
				fwrite($objResource, sprintf("      name=\"%s\"\r\n", $objFile->FileName ));
				fwrite($objResource, "Content-Transfer-Encoding: base64\r\n");
				fwrite($objResource, "Content-Length: %s\r\n", strlen($objFile->EncodedFileData));
				fwrite($objResource, "Content-Disposition: attachment;\r\n");
				fwrite($objResource, sprintf("      filename=\"%s\"\r\n\r\n", $objFile->FileName));
				fwrite($objResource, $objFile->EncodedFileData);
			}
		}

		// close a message with these boundaries if the message had files or had html
		if($objMessage->HasFiles || $objMessage->HtmlBody) {
   			fwrite($objResource, sprintf("\r\n\r\n--%s--\r\n", $strBoundary)); // send end of file attachments...
		}

		// Send: Message End
		fwrite($objResource, "\r\n.\r\n");
		if (!feof($objResource)) {
			$strResponse = fgets($objResource, 4096);
			
			// Check for a "250" response
			if ((strpos($strResponse, "250") === false) || (strpos($strResponse, "250") != 0)) {
				throw new Exception(sprintf('Error Response on MAIL FROM: %s', $strResponse));
			}
		}

		// Send: QUIT
		fwrite($objResource, "QUIT\r\n");
		if (!feof($objResource)) {
			$strResponse = fgets($objResource, 4096);
		}
			
		// Close the Resource
		fclose($objResource);
	}
}

EmailServer::$OriginatingServerIp = Application::$ServerAddress;
?>
