<?php
/**
 * File : FormControlBase.class.php
 * Created on: Thu Sep 2 21:03 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name FormControlBase
 */

abstract class FormControlBase implements TemplateManager {

	protected $objParentObject;
	protected $strControlId;

	public function __construct($objParentObject = null, $strControlId = null) {}

	public function Render() {}
}
?>
