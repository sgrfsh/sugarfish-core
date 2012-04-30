<?php
/**
 * File : TextBox.class.php
 * Created on: Fri Jul 16 21:03 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name TextBox
 */

 class TextBox extends FormControl {
	// styles
	protected $strText = null;
	protected $strFormat = '%s';

	// behavior
	protected $intMaxLength = 0;
	protected $blnReadOnly = false;
	protected $blnHtml = false;

	// layout
	protected $strTextMode = TextMode::SingleLine;
	protected $intLines = 1;
	protected $blnWrap = true;

	// attributes
	protected $strLabel;
	protected $strLabelWidth;

	public function __construct($objParentObject = null, $strControlId = null) {
		parent::__construct($objParentObject, $strControlId);
	}

	public function GetAttributes($blnIncludeCustom = true, $blnIncludeAction = true) {
		$strToReturn = parent::GetAttributes($blnIncludeCustom, $blnIncludeAction);

		if ($this->blnReadOnly) {
			$strToReturn .= 'readonly ';
		}

		if ($this->strTextMode == TextMode::MultiLine) {
			if ($this->intLines > 1) {
				$strToReturn .= sprintf('rows="%s" ', $this->intLines);
			}
			if (!$this->blnWrap) {
				$strToReturn .= 'wrap="off" ';
			}
		} else {
			if ($this->intMaxLength) {
				$strToReturn .= sprintf('maxlength="%s" ', $this->intMaxLength);
			}
		}

		return $strToReturn;
	}

	protected function GetControlHtml() {
		$strStyle = $this->GetStyleAttributes();
		if ($strStyle) {
			$strStyle = sprintf('style="%s"', $strStyle);
		}

		if (!empty($this->strLabel)) {
			if (!empty($this->strLabelWidth)) {
				$strLabelSpan = sprintf('<span style="width:%s; display:inline-block; vertical-align:top">', $this->strLabelWidth);
			}
			$strLabel = sprintf('%s<label for="%s">%s</label>%s', $strLabelSpan, $this->strControlId, $this->strLabel, empty($strLabelSpan)?'':'</span>');
		}
		
		switch ($this->strTextMode) {
			case TextMode::Password:
				$strToReturn = sprintf('%s<input type="password" name="%s" id="%s" value="' . $this->strFormat . '" %s%s />', $strLabel, $this->strControlId, $this->strControlId, Application::HtmlEntities($this->strText), $this->GetAttributes(), $strStyle);
				break;
			case TextMode::MultiLine:
				$strToReturn = sprintf('%s<textarea name="%s" id="%s" %s%s>' . $this->strFormat . '</textarea>', $strLabel, $this->strControlId, $this->strControlId, $this->GetAttributes(), $strStyle, Application::HtmlEntities($this->strText)); 
				break;
			case TextMode::SingleLine:
			default:
				$strToReturn = sprintf('%s<input type="text" name="%s" id="%s" value="' . $this->strFormat . '" %s%s />', $strLabel, $this->strControlId, $this->strControlId, Application::HtmlEntities($this->strText), $this->GetAttributes(), $strStyle);
		}

		return $strToReturn;
	}

	public function SetText($mixValue) {
		$this->strText = $mixValue;
		return $this;
	}

	public function SetFormat($mixValue) {
		$this->strFormat = $mixValue;
		return $this;
	}

	public function SetMaxLength($mixValue) {
		$this->intMaxLength = $mixValue;
		return $this;
	}

	public function SetReadOnly($mixValue) {
		$this->blnReadOnly = $mixValue;
		return $this;
	}

	public function SetHtml($mixValue) {
		$this->blnHtml = $mixValue;
		return $this;
	}

	public function SetTextMode($mixValue) {
		$this->strTextMode = $mixValue;
		return $this;
	}

	public function SetLines($mixValue) {
		$this->intLines = $mixValue;
		return $this;
	}

	public function SetWrap($mixValue) {
		$this->blnWrap = $mixValue;
		return $this;
	}

	public function SetLabel($mixValue) {
		$this->strLabel = $mixValue;
		return $this;
	}

	public function SetLabelWidth($mixValue) {
		$this->strLabelWidth = $mixValue;
		return $this;
	}

	public function __get($strName) {
		switch ($strName) {
			case "Text": return $this->strText;
			case "Format": return $this->strFormat;
			case "MaxLength": return $this->intMaxLength;
			case "ReadOnly": return $this->blnReadOnly;
			case "TextMode": return $this->strTextMode;
			case "Wrap": return $this->blnWrap;
			case "Label": return $this->strLabel;
			case "LabelWidth": return $this->strLabelWidth;

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
			case "Text":
				$this->strText = $mixValue;
				break;
			case "Format":
				$this->strFormat = $mixValue;
				break;
			case "MaxLength":
				$this->intMaxLength = $mixValue;
				break;
			case "ReadOnly":
				$this->blnReadOnly = $mixValue;
				break;
			case "Html":
				$this->blnHtml = $mixValue;
				break;
			case "TextMode":
				$this->strTextMode = $mixValue;
				break;
			case "Lines":
				$this->intLines = $mixValue;
				break;
			case "Wrap":
				$this->blnWrap = $mixValue;
				break;
			case "Label":
				$this->strLabel = $mixValue;
				break;
			case "LabelWidth":
				$this->strLabelWidth = $mixValue;
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
