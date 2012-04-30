<?php
///////////////////////////////////
// Define Server-specific constants
///////////////////////////////////	
/*
 * This assumes that the configuration and functions include files are in the same directory
 * as this prepend include file.
 */
require_once "user_configuration.inc.php";
	
/**
  * Global Include file
  *
  * Includes all necessary class files and includes
  */

// Ensure prepend.inc is only executed once
if (!defined('__USER_PREPEND_INCLUDED__')) {
	define('__USER_PREPEND_INCLUDED__', 1);

	// USER CLASSES
	require_once __USER_CLASSES__ . '/_enumerations.inc.php';
	require_once __USER_CLASSES__ . '/models/SessionModel.class.php';

	// page classes
	require_once __USER_CLASSES__ . '/page/Header.class.php';
	require_once __USER_CLASSES__ . '/page/Footer.class.php';
	require_once __USER_CLASSES__ . '/page/PageFooter.class.php';
	require_once __USER_CLASSES__ . '/page/AlarmHeader.class.php';

	// data models
	require_once __DOCROOT__ . '/index/models/HomeModel.class.php';
	require_once __DOCROOT__ . '/dialog/models/DialogModel.class.php';
	require_once __DOCROOT__ . '/test/models/TestModel.class.php';
	require_once __DOCROOT__ . '/blah/models/BlahModel.class.php';
	require_once __DOCROOT__ . '/html5/models/JSTestModel.class.php';
	require_once __DOCROOT__ . '/words/models/WordsModel.class.php';

	require_once __USER_CLASSES__ . '/UserFunctions.class.php';
	require_once __USER_CLASSES__ . '/DataModel.class.php';
	require_once __USER_CLASSES__ . '/Session.class.php';

	// code highlighter
	require_once __USER_CLASSES__ . '/external/geshi/geshi.php';
	require_once __USER_CLASSES__ . '/external/CodeHighlighter.class.php';

	require_once __USER_CLASSES__ . '/UserFunctions.class.php';
	require_once __USER_CLASSES__ . '/DataModel.class.php';
	require_once __USER_CLASSES__ . '/Session.class.php';
	require_once __USER_CLASSES__ . '/ContentHandler.class.php';

	// wordnik
	require_once __USER_CLASSES__ . '/external/wordnik/wordnik.class.php';

	// yt
	require_once __USER_CLASSES__ . '/ytdata/YTHandler.class.php';
	require_once __USER_CLASSES__ . '/ytdata/YTEntity.class.php';
	require_once __USER_CLASSES__ . '/ytdata/YTVideo.class.php';
	require_once __USER_CLASSES__ . '/ytdata/YTVideoArray.class.php';
	require_once __USER_CLASSES__ . '/ytdata/YTChannel.class.php';
	require_once __USER_CLASSES__ . '/ytdata/YTChannelArray.class.php';
}
?>
