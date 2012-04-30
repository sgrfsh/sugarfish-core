<?php
/**
 * File : ListControl.class.php
 * Created on: Tue Apr 13 23:01 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name ListControl
 */

class ListControl extends FormControl {

  	protected $arrChildControls = array();

  	// attributes
  	protected $strCssClass;
  	protected $objItemStyle;
  	protected $intSize = null;
  	protected $blnDisabled = false;
  	protected $blnMultiple = false;

  	// data
  	protected $strDataModelTable;
	protected $strIndexCol;
	protected $strValueCol;
  
	public function __construct($objParentObject = null, $strControlId = null, $strDataModelTable = null, $arrColumns = null) {
		parent::__construct($objParentObject, $strControlId);

		$this->strControlId = $strControlId;

		if (!is_null($arrColumns) && !is_array($arrColumns)) {
			return false;
		}

		// if we're passing a DataModel table then we auto add the values from it
		if (!is_null($strDataModelTable)) {
			$this->strDataModelTable = $strDataModelTable;
			if (!is_null($arrColumns)) {
				$this->strIndexCol = $arrColumns[0];
				$this->strValueCol = $arrColumns[1];
			} else {
				$this->strIndexCol = 'id';
				$this->strValueCol = 'value';
			}
			$this->FillList();
		}
	}

	// fill the list with data from a DataModel table
	private function FillList() {
		$objResult = MySqlDb::Query(
			sprintf("
				SELECT
					%1\$s.%2\$s AS id,
					%1\$s.%3\$s AS value
				FROM
					%1\$s;
			",
			$this->strDataModelTable, $this->strIndexCol, $this->strValueCol)
		);
		while ($objRow = MySqlDb::FetchAssoc($objResult)) {
			$strIndex = $objRow['id'];
			$strValue = $objRow['value'];
			$this->AddItem($strIndex, $strValue);
		}
	}

	public function Render() {
		/*
		print '<pre>';
			print_r($this->arrItems);
		print '</pre>';
		*/

		$strCssClass = (!is_null($this->strCssClass))?sprintf(' class="%s"', $this->strCssClass):'';
		$strSize = (!is_null($this->intSize))?sprintf(' size="%s"', $this->intSize):'';
		$strDisabled = ($this->blnDisabled)?' disabled':'';
		$strMultiple = ($this->blnMultiple)?' multiple':'';

		$strOutput = '';
		if (!is_null($this->strControlId)) {
			$strOutput = sprintf("<select id=\"%s\" name=\"%s\"%s%s%s%s>\n", $this->strControlId, $this->strControlId, $strCssClass, $strSize, $strDisabled, $strMultiple);
		} else {
			$strOutput = sprintf("<select%s%s%s%s>\n", $strCssClass, $strSize, $strDisabled, $strMultiple);
		}
		foreach ($this->arrItems as $objListItem) {
			$strIndex = (!is_null($objListItem->Index))?sprintf(" value=\"%s\"", $objListItem->Index):'';
			$strSelected = ($objListItem->Selected)?' selected':'';
			$strDisabled = ($objListItem->Disabled)?' disabled':'';
			$strOutput .= sprintf("\t<option%s%s%s>%s</option>\n", $strIndex, $strSelected, $strDisabled, $objListItem->Value);
		}
		$strOutput .= '</select>';
		print $strOutput;
	}

	public function AddItem($strIndex = null, $strValue, $blnSelected = false, $blnDisabled = false) {
		$objListItem = new ListItem($strIndex, $strValue, $blnSelected);
		// if an item is disabled then do not select it
		$objListItem->Disabled = $blnDisabled;
		$objListItem->Selected = $blnDisabled?false:$blnSelected;
		array_push($this->arrChildControls, $objListItem);
	}

	public function __get($strName) {
		switch ($strName) {
			case "ControlId":
				return $this->strControlId;
			case "ItemCount":
				if ($this->arrItems) {
					return count($this->arrItems);
				} else {
					return 0;
				}
			case "SelectedIndex":
				for ($intIndex = 0; $intIndex < count($this->arrItems); $intIndex++) {
					if ($this->arrItems[$intIndex]->Selected) {
						return $intIndex;
					}
				}
				return -1;
			case "SelectedName":
				for ($intIndex = 0; $intIndex < count($this->arrItems); $intIndex++) {
					if ($this->arrItems[$intIndex]->Selected) {
						return $this->arrItems[$intIndex]->Name;
					}
				}
				return null;
			case "SelectedValue":
				for ($intIndex = 0; $intIndex < count($this->arrItems); $intIndex++) {
					if ($this->arrItems[$intIndex]->Selected) {
						return $this->arrItems[$intIndex]->Value;
					}
				}
				return null;
			case "SelectedItem":
				for ($intIndex = 0; $intIndex < count($this->arrItems); $intIndex++) {
					if ($this->arrItems[$intIndex]->Selected) {
						return $this->arrItems[$intIndex];
					}
				}
				return null;
			case "SelectedItems":
				$objToReturn = array();
				for ($intIndex = 0; $intIndex < count($this->arrItems); $intIndex++) {
					if ($this->arrItems[$intIndex]->Selected) {
						array_push($objToReturn, $this->arrItems[$intIndex]);
					}
				}
				return $objToReturn;
			case "SelectedNames":
				$strNamesArray = array();
				for ($intIndex = 0; $intIndex < count($this->arrItems); $intIndex++) {
					if ($this->arrItems[$intIndex]->Selected) {
						array_push($strNamesArray, $this->arrItems[$intIndex]->Name);
					}
				}
				return $strNamesArray;
			case "SelectedValues":
				$objToReturn = array();
				for ($intIndex = 0; $intIndex < count($this->arrItems); $intIndex++) {
					if ($this->arrItems[$intIndex]->Selected) {
						array_push($objToReturn, $this->arrItems[$intIndex]->Value);
					}
				}
				return $objToReturn;
			case "CssClass":
				return $this->strCssClass;
				break;
			case "Size":
				return $this->intSize;
				break;
			case "Disabled":
				return $this->blnDisabled;
				break;
			case "Multiple":
				return $this->blnMultiple;
		}
	}

	public function __set($strName, $mixValue) {
		switch ($strName) {
			case "ControlId":
				$this->strControlId = $mixValue;
				break;
			case "SelectedIndex":
				// special case
				if ($mixValue == -1) {
					$mixValue = null;
				}
				if (($mixValue < 0) || ($mixValue > (count($this->arrItems) - 1))) {
					return false;
				}
				for ($intIndex = 0; $intIndex < count($this->arrItems); $intIndex++) {
					if ($mixValue == $intIndex) {
						$this->arrItems[$intIndex]->Selected = $this->arrItems[$intIndex]->Disabled?false:true;
					} else {
						$this->arrItems[$intIndex]->Selected = false;
					}
				}
				break;
			case "SelectedName":
				foreach ($this->arrItems as $objItem) {
					if ($objItem->Name == $mixValue) {
						$objItem->Selected = $objItem->Disabled?false:true;
					} else {
						$objItem->Selected = false;
					}
				}
				break;
			case "SelectedValue":
				foreach ($this->arrItems as $objItem) {
					if ($objItem->Value == $mixValue) {
						$objItem->Selected = $objItem->Disabled?false:true;
					} else {
						$objItem->Selected = false;
					}
				}
				break;
			case "SelectedNames":
				foreach ($this->arrItems as $objItem) {
					$objItem->Selected = false;
					foreach ($mixValue as $mixName) {
						if ($objItem->Name == $mixName) {
							$objItem->Selected = $objItem->Disabled?false:true;
							break;
						}
					}
				}
	                   break;
			case "SelectedValues":
				foreach ($this->arrItems as $objItem) {
					$objItem->Selected = false;
					foreach ($mixValue as $mixName) {
						if ($objItem->Value == $mixName) {
							$objItem->Selected = $objItem->Disabled?false:true;
							break;
						}
					}
				}
				break;
			case "DisableItem":
				foreach ($this->arrItems as $objItem) {
					if ($objItem->Index == $mixValue) {
						$objItem->Disabled = true;
						break;
					}
				}
				break;
			case "CssClass":
				$this->strCssClass = $mixValue;
				break;
			case "Size":
				$this->intSize = $mixValue;
				break;
			case "Disabled":
				$this->blnDisabled = $mixValue;
				break;
			case "Multiple":
				$this->blnMultiple = $mixValue;
		}
	}
}
?>
