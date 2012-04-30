<?php
/**
 * File : _phpinfo.php
 * Created on: Mon Sep 15 00:10 CDT 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 */

	require_once "prepend.inc.php";

	function DisplayMonospacedText($strText) {
		$strText = Application::HtmlEntities($strText);
		$strText = str_replace('	', '    ', $strText);
		$strText = str_replace(' ', '&nbsp;', $strText);
		$strText = str_replace("\r", '', $strText);
		$strText = str_replace("\n", '<br/>', $strText);

		_p($strText, false);
	}

	//////////////////
	// Output the Page
	//////////////////
?>
<html>
<head>
	<title>SFc Development Framework: Information</title>
	<style>
		a:link,#actions a:visited{text-decoration:none;}
		a:hover{text-decoration:underline;}
		.page{padding:10px;}
		.headingLeft{background-color:#464;color:#fff;padding:10px 0 10px 10px;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;font-weight:bold;width:70%;vertical-align:top;border:0;}
		.headingLeftLarge{font-size:18px;}
		.headingRight{background-color:#464;color:#fff;padding:10px 10px 10px 0;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;width:30%;vertical-align:top;text-align:right;border:0;}
		.title{font-family:Verdana,Arial,Helvetica,sans-serif;font-size:19px;font-style:italic;color:#305;}
		pre,.code{padding:10px 10px 10px 10px;margin-left:50px;font-size:11px;font-family:Lucida Console,Courier New,Courier,monospaced;}
		.code_title{font-family:Verdana,Arial,Helvetica,sans-serif;font-size:12px;font-weight:bold;}
		#information{border:2px dashed #999;background-color:#efefef;padding:10px;}
		#actions{height:20px;padding:3px 0 3px 10px;}
		#actions a,#actions a:hover, #actions a:visited{color:#369;padding:0 2px 0 2px;}
		#actions a:hover{text-decoration:none;outline:1px solid #369;background:#fff;}
	</style>
</head>
<body>

	<table border="0" cellspacing="0" width="100%">
		<tr>
			<td nowrap="nowrap" class="headingLeft">SFc Development Framework <?php _p(__VERSION__); ?><br /><span class="headingLeftLarge">PHP Information</span></td>
			<td nowrap="nowrap" class="headingRight">
				<b>PHP Version:</b> <?php _p(PHP_VERSION); ?>;&nbsp;&nbsp;<b>Zend Engine Version:</b> <?php _p(zend_version()); ?>;<br />
				<?php if (array_key_exists('OS', $_SERVER)) printf('<b>Operating System:</b> %s;&nbsp;&nbsp;', $_SERVER['OS']); ?><b>Application:</b> <?php _p($_SERVER['SERVER_SOFTWARE']); ?>;&nbsp;&nbsp;<b>Server Name:</b> <?php _p($_SERVER['SERVER_NAME']); ?>
			</td>
		</tr>
	</table>

	<div id="actions">
		<a href="_info">home</a>
	</div>

	<div id="information">
		<?php
			_p("<p>", false);
			phpinfo();
			_p("</p>", false);
		?>
	</div>

	<style type="text/css">
		body,td,th,h1{font-family:Arial,Helvetica,sans-serif;font-size:14px;margin:0px;}
		h2{background-color:#efefef;}
		.e{background-color:#9cf;font-weight:bold;color:#000;}
		.h{background-color:#69c;font-weight:bold;color:#000;}
		hr{width:0;background-color:#ccc;border:0;height:0;color:#ccc;}
	</style>
</body>
</html>
