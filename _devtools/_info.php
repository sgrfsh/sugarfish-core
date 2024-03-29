<?php
/**
 * File : _info.php
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
		body{font-family:Arial,Helvetica,sans-serif;font-size:14px;margin:0px;background-color:white;}
		a:link,a:visited{text-decoration:none;}
		a:hover{text-decoration:underline;}
		.page{padding:10px;}
		.headingLeft{background-color:#464;color:#fff;padding:10px 0 10px 10px;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;font-weight:bold;width:70%;vertical-align:top;}
		.headingLeftLarge{font-size:18px;}
		.headingRight{background-color:#464;color:#fff;padding:10px 10px 10px 0;font-family:Verdana,Arial,Helvetica,sans-serif;font-size:10px;width:30%;vertical-align:top;text-align:right;}
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
			<td nowrap="nowrap" class="headingLeft">SFc Development Framework <?php _p(__VERSION__); ?><br /><span class="headingLeftLarge">Information</span></td>
			<td nowrap="nowrap" class="headingRight">
				<b>PHP Version:</b> <?php _p(PHP_VERSION); ?>;&nbsp;&nbsp;<b>Zend Engine Version:</b> <?php _p(zend_version()); ?>;<br />
				<?php if (array_key_exists('OS', $_SERVER)) printf('<b>Operating System:</b> %s;&nbsp;&nbsp;', $_SERVER['OS']); ?><b>Application:</b> <?php _p($_SERVER['SERVER_SOFTWARE']); ?>;&nbsp;&nbsp;<b>Server Name:</b> <?php _p($_SERVER['SERVER_NAME']); ?>
			</td>
		</tr>
	</table>

	<div id="actions">
		<a href="_errorlog">error log</a>
	</div>

	<div id="information">
		<?php
			_p("<p>", false);
				_p("Domain: " . __DOMAIN__, false);
			_p("</p>", false);

            _p("<p>", false);
				_p("Date: " . date("F jS, Y") . "<br />", false);
                _p("Time: " . date("H:i:s") . "<br />", false);
                _p("Timezone: " . date_default_timezone_get(), false);
			_p("</p>", false);

			_p("<p>", false);
				_p("Core: " . __CORE__ . "<br />", false);
				_p("Includes: " . __INCLUDES__ . "<br />", false);
				_p("Classes: " . __CLASSES__ . "<br />", false);
				_p("User Classes: " . __USER_CLASSES__ . "<br />", false);
			_p("</p>", false);

			_p("<p>", false);
				_p("Assets: " . __ASSETS__ . "<br />", false);
				//_p("Templates: " . __TEMPLATES__ . "<br />", false);
				_p("Cascading Style Sheets: " . __CSS__ . "<br />", false);
				_p("Images: " . __IMAGES__ . "<br />", false);
				_p("JavaScript: " . __JAVASCRIPT__, false);
			_p("</p>", false);

			_p("<p>", false);
				_p("Remote Address: " . Application::$RemoteAddress . "<br />", false);
				_p("Server Address: " . Application::$ServerAddress . "<br />", false);
		
				_p("Browser: ", false);

				if (Application::IsBrowser(BrowserType::InternetExplorer)) {
					_p("Internet Explorer", false);
					if (Application::IsBrowser(BrowserType::InternetExplorer_6_0)) {
						_p(" 6.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::InternetExplorer_7_0)) {
						_p(" 7.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::InternetExplorer_8_0)) {
						_p(" 8.0<br />", false);
					} else {
						_p("<br />", false);
					}
				} else if (Application::IsBrowser(BrowserType::Firefox)) {
					_p("Firefox", false);
					if (Application::IsBrowser(BrowserType::Firefox_1_0)) {
						_p(" 1.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::Firefox_1_5)) {
						_p(" 1.5<br />", false);
					} else if (Application::IsBrowser(BrowserType::Firefox_2_0)) {
						_p(" 2.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::Firefox_3_0)) {
						_p(" 3.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::Firefox_3_5)) {
						_p(" 3.5<br />", false);
					} else if (Application::IsBrowser(BrowserType::Firefox_3_6)) {
						_p(" 3.6<br />", false);
					} else {
						_p("<br />", false);
					}
				} else if (Application::IsBrowser(BrowserType::Safari)) {
					_p("Safari", false);
					if (Application::IsBrowser(BrowserType::Safari_2_0)) {
						_p(" 2.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::Safari_3_0)) {
						_p(" 3.0<br />", false);
					} else {
						_p("<br />", false);
					}
				} else if (Application::IsBrowser(BrowserType::Chrome)) {
					_p("Chrome", false);
					if (Application::IsBrowser(BrowserType::Chrome_2_0)) {
						_p(" 2.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::Chrome_3_0)) {
						_p(" 3.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::Chrome_4_0)) {
						_p(" 4.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::Chrome_5_0)) {
						_p(" 4.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::Chrome_6_0)) {
						_p(" 4.0<br />", false);
					} else if (Application::IsBrowser(BrowserType::Chrome_7_0)) {
						_p(" 7.0<br />", false);
					} else {
						_p("<br />", false);
					}
				}

				_p("Document Root: " . Application::$DocumentRoot . "<br />", false);
				_p("Encoding Type: " . Application::$EncodingType . "<br />", false);
				_p("Request URI: " . Application::$RequestUri . "<br />", false);
			_p("</p>", false);
		?>
	</div>

</body>
</html>
