<?php
/**
 * File : RadioButton.class.php
 * Created on: Sat Sep 11 16:00 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name RadioButton
 */

 class RadioButton extends FormControl {
	// appearance
	protected $strName;
	protected $strLabelAlign = TextAlign::Right;
	
	// behavior
	protected $blnHtmlEntities = true;

	// attributes
	protected $strLabel;
	protected $strLabelWidth;

	// miscellaneous
	protected $strGroupName = null;
	protected $blnChecked = false;

	public function __construct($objParentObject = null, $strControlId = null) {
		parent::__construct($objParentObject, $strControlId);

		if ($objParentObject instanceof RadioButtonList) {
			$this->strGroupName = $objParentObject->ControlId;
		} else {
			$this->strName = $this->strControlId;
		}
	}

	public function ParsePostData() {
		if (array_key_exists($strName, $_POST)) {
			if ($_POST[$strName] == $this->strControlId) {
				$this->blnChecked = true;
			} else {
				$this->blnChecked = false;
			}
		}
	}

	protected function GetControlHtml() {
		if ($this->blnDisabled) {
			$strDisabled = 'disabled ';
		} else {
			$strDisabled = "";
		}

		if ($this->intTabIndex) {
			$strTabIndex = sprintf('tabindex="%s" ', $this->intTabIndex);
		} else {
			$strTabIndex = "";
		}

		if ($this->strToolTip) {
			$strToolTip = sprintf('title="%s" ', $this->strToolTip);
		} else {
			$strToolTip = "";
		}

		if ($this->strCssClass) {
			$strCssClass = sprintf('class="%s" ', $this->strCssClass);
		} else {
			$strCssClass = "";
		}

		if ($this->strAccessKey) {
			$strAccessKey = sprintf('accesskey="%s" ', $this->strAccessKey);
		} else {
			$strAccessKey = "";
		}
			
		if ($this->blnChecked) {
			$strChecked = 'checked ';
		} else {
			$strChecked = "";
		}

		$strStyle = $this->GetStyleAttributes();
		if (strlen($strStyle) > 0) {
			$strStyle = sprintf('style="%s" ', $strStyle);
		}

		if (!empty($this->strLabel)) {
			if (!empty($this->strLabelWidth)) {
				$strLabelSpan = sprintf('<span style="width:%s; display:inline-block; vertical-align:top">', $this->strLabelWidth);
			}
			$strLabel = sprintf('%s<label for="%s">%s</label>%s', $strLabelSpan, $this->strControlId, $this->strLabel, empty($strLabelSpan)?'':'</span>');
		}
		
		$this->blnIsBlockElement = true;
		if ($this->strLabelAlign == TextAlign::Left) {
			$strToReturn = sprintf('<span %s%s%s%s%s>%s<input type="radio" id="%s" name="%s" value="%s" %s%s%s%s%s%s/></span>',
				$strCssClass,
				$strToolTip,
				$strStyle,
				$strCustomAttributes,
				$strDisabled,
				$strLabel,
				$this->strControlId,
				!empty($this->strGroupName)?$this->strGroupName:$this->strName,
				$this->strControlId,
				$strDisabled,
				$strChecked,
				$strActions,
				$strAccessKey,
				$strTabIndex,
				$this->GetAttributes()
			);
		} else {
			$strToReturn = sprintf('<span %s%s%s%s%s><input type="radio" id="%s" name="%s" value="%s" %s%s%s%s%s%s/>%s</span>',
				$strCssClass,
				$strToolTip,
				$strStyle,
				$strCustomAttributes,
				$strDisabled,
				$this->strControlId,
				!empty($this->strGroupName)?$this->strGroupName:$this->strName,
				$this->strControlId,
				$strDisabled,
				$strChecked,
				$strActions,
				$strAccessKey,
				$strTabIndex,
				$this->GetAttributes(),
				$strLabel
			);
		}

		return $strToReturn;
	}

	public function SetLabel($mixValue) {
		$this->strLabel = $mixValue;
		return $this;
	}

	public function SetLabelWidth($mixValue) {
		$this->strLabelWidth = $mixValue;
		return $this;
	}

	public function SetLabelAlign($mixValue) {
		$this->strLabelAlign = $mixValue;
		return $this;
	}

	public function SetHtmlEntities($mixValue) {
		$this->strHtmlEntities = $mixValue;
		return $this;
	}

	public function SetGroupName($mixValue) {
		$this->strGroupName = $mixValue;
		return $this;
	}

	public function SetChecked($mixValue) {
		$this->blnChecked = $mixValue;
		return $this;
	}

	public function __get($strName) {
		switch ($strName) {
			case "Label": return $this->strLabel;
			case "LabelWidth": return $this->strLabelWidth;
			case "LabelAlign": return $this->strTextAlign;
			case "GroupName": return $this->strGroupName;
			case "HtmlEntities": return $this->blnHtmlEntities;
			case "Checked": return $this->blnChecked;

			default:
				try {
					return parent::__get($strName);
				} catch(CustomException $e) {
					print $e;
					exit;
				}
		}
	}

	public function __set($strName, $mixValue) {
		switch ($strName) {
			case "Label":
				$this->strLabel = $mixValue;
				break;
			case "LabelWidth":
				$this->strLabelWidth = $mixValue;
				break;
			case "LabelAlign":
				$this->strTextAlign = $mixValue;
				break;
			case "HtmlEntities":
				$this->blnHtmlEntities = $mixValue;
				break;
			case "GroupName":
				$this->strGroupName = $mixValue;
				break;
			case "Checked":
				$this->blnChecked = $mixValue;
				break;

			default:
				try {
					parent::__set($strName, $mixValue);
				} catch(CustomException $e) {
					print $e;
					exit;
				}
		}
	}
}
?>
