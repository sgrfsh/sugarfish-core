<?php
/**
 * File : BrowserType.class.php
 * Created on: Sun May 17 10:31 CDT 2009
 *
 * @author Ian
 *
 * @copyright  2009 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package dev
 * @name BrowserType
 */

class BrowserType {
		const InternetExplorer		= 1;
		const InternetExplorer_6_0	= 2;
		const InternetExplorer_7_0	= 4;
		const InternetExplorer_8_0	= 8;
		const InternetExplorer_9_0	= 16;
		
		const Firefox				= 32;
		const Firefox_1_0			= 64;
		const Firefox_1_5			= 128;
		const Firefox_2_0			= 256;
		const Firefox_3_0			= 512;
		const Firefox_3_5			= 1024;
		const Firefox_3_6			= 2048;
		
		const Safari				= 4096;
		const Safari_2_0			= 8192;
		const Safari_3_0			= 16384;
		const Safari_4_0			= 32765;
		
		const Chrome				= 65536;
		const Chrome_2_0			= 131072;
		const Chrome_3_0			= 262144;
		const Chrome_4_0			= 524288;
		const Chrome_5_0			= 1048576;
		const Chrome_6_0			= 2097152;
		const Chrome_7_0			= 4194304;

		const iPhone				= 8388608;
		const iPod					= 8388608;
		const iPad					= 8388608;

		const Unsupported			= 16777216;
	}
?>
