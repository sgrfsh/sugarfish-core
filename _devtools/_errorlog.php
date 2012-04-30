<?php
/**
 * File : _errorlog.php
 * Created on: Mon Sep 15 00:10 CDT 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 */

	require_once "prepend.inc.php";

	final class ErrorLog {

		private $strFile;
		private $arrList;
		public $strOutput;

		public function __construct() {
			$this->strFile = '/repo/www/logs/error.log';
			$this->ReadErrorLog();
			$this->ListErrorLog();
		}
		
		// read error.log file into array
		private function ReadErrorLog() {
			$strCr = chr(10);
			$objFh = fopen($this->strFile, 'r');
			$strList = fread($objFh, filesize($this->strFile));
			fclose($objFh);
			$this->arrList = explode($strCr, $strList);
		}

		// display each line of error.log
		private function ListErrorLog() {
			$strLink = '<a href=' . chr(39);
			$strNewLink = '<a target="_new" href=' . chr(39) . 'http://php.net/';
			$strSpaceTab = chr(32) . chr(32) . chr(32) . chr(32);
			$strTab = '&nbsp;&nbsp;&nbsp;&nbsp;';
			$intCount = sizeof($this->arrList);

			foreach($this->arrList as $strLine) {
				$strLine = str_replace($strLink, $strNewLink, $strLine);
				$strLine = str_replace($strSpaceTab, $strTab, $strLine);
				$this->strOutput .= stripslashes($strLine) . '<br />';
			}
			if (strpos($this->strOutput, chr(13))) {
				$this->strOutput = str_replace(chr(13), '', $this->strOutput);
			}
		}

		public function DeleteErrorLog() {
			unlink($this->strFile);
		}
	}

	$objErrorlog = new ErrorLog;
	if($_GET['action'] == 'kill') {
		$objErrorlog->DeleteErrorLog();
		error_log('error.log deleted');
		Application::Redirect('_errorlog');
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>SFc Development Framework: Error Log</title>
	<style>
		body{font-family:Arial,Helvetica,sans-serif;font-size:14px;margin:0px;background-color:white;}
		a:link,a:visited{text-decoration:none;font-size:14px;}
		a:hover{text-decoration:underline;font-size:14px;}
		.page{padding:10px;}
		.headingLeft{background-color:#464;color:#fff;padding:10px 0 10px 10px;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;font-weight:bold;width:70%;vertical-align:top;}
		.headingLeftLarge{font-size:18px;}
		.headingRight{background-color:#464;color:#fff;padding:10px 10px 10px 0;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;width:30%;vertical-align:top;text-align:right;}
		.title{font-family:Verdana,Arial,Helvetica,sans-serif;font-size:19px;font-style:italic;color:#305;}
		pre,.code{background-color:#f4eeff;padding:10px 10px 10px 10px;margin-left:50px;font-size:11px;font-family:Lucida Console,Courier New,Courier,monospaced;}
		.code_title{font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;}
		#actions{height:20px;padding:3px 0 3px 10px;}
		#actions a,#actions a:hover, #actions a:visited{color:#369;padding:0 2px 0 2px;}
		#actions a:hover{text-decoration:none;outline:1px solid #369;background:#fff;}
		#errorlog{width:98%; height:700px; border:1px solid #464; padding:2px; margin:0 8px 0 8px; overflow:auto; line-height:14px;}
	</style>
	<script type="text/javascript">
		/*<![CDATA[*/
			function init() {
				objDiv = resize();
				objDiv.innerHTML = '<?=addslashes($objErrorlog->strOutput);?>';
				objDiv.scrollTop = objDiv.scrollHeight;
			}

			function resize() {
				var ht;
				var objDiv = document.getElementById("errorlog");

				if (typeof window.innerHeight != 'undefined') {
					ht = window.innerHeight
				} else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientHeight != 'undefined' && document.documentElement.clientHeight != 0) {
					ht = document.documentElement.clientHeight
				}

				if (ht < 200) {
					ht = 200;
				}
				objDiv.style.height = (ht - 100) + 'px';
				return objDiv;
			}
		/*]]>*/
	</script>
</head>

<body onload="init();" onresize="resize();">

	<table border="0" cellspacing="0" width="100%">
		<tr>
			<td nowrap="nowrap" class="headingLeft">SFc Development Framework <?php _p(__VERSION__); ?><br /><span class="headingLeftLarge">Error Log</span></td>
			<td nowrap="nowrap" class="headingRight">
				<b>PHP Version:</b> <?php _p(PHP_VERSION); ?>;&nbsp;&nbsp;<b>Zend Engine Version:</b> <?php _p(zend_version()); ?>;<br />
				<?php if (array_key_exists('OS', $_SERVER)) printf('<b>Operating System:</b> %s;&nbsp;&nbsp;', $_SERVER['OS']); ?><b>Application:</b> <?php _p($_SERVER['SERVER_SOFTWARE']); ?>;&nbsp;&nbsp;<b>Server Name:</b> <?php _p($_SERVER['SERVER_NAME']); ?>
			</td>
		</tr>
	</table>

	<div id="actions">
		<a href="_info">home</a>&nbsp;|&nbsp;<a href="_errorlog">refresh</a>&nbsp;|&nbsp;<a href="_errorlog?action=kill">delete</a>
	</div>

	<div id="errorlog">
		<!-- content -->
	</div>

</body>
</html>
