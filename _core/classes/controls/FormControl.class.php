<?php
/**
 * File : FormControl.class.php
 * Created on: Thu Sep 2 21:03 CST 2010
 *
 * @author		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name FormControl
 */

abstract class FormControl extends FormControlBase {
	// styles
	protected $strBackColor = null;
	protected $strBorderColor = null;
	protected $strBorderStyle = BorderStyle::DefaultStyle;
	protected $strBorderWidth = null;
	protected $strCssClass = null;
	protected $blnDisplay = true;
	protected $strDisplayStyle = DisplayStyle::DefaultStyle;
	protected $blnFontBold = false;
	protected $blnFontItalic = false;
	protected $strFontNames = null;
	protected $blnFontOverline = false;
	protected $strFontSize = null;
	protected $blnFontStrikeout = false;
	protected $blnFontUnderline = false;
	protected $strForeColor = null;
	protected $intOpacity = null;

	// behavior
	protected $strAccessKey = null;
	protected $strCursor = Cursor::DefaultStyle;
	protected $blnDisabled = false;
	protected $intTabIndex = 0;
	protected $strToolTip = null;
	protected $blnVisible = true;

	// layout
	protected $strWidth = null;
	protected $strHeight = null;
	protected $strHtmlBefore = null;
	protected $strHtmlAfter = null;
	protected $strOverflow = Overflow::DefaultStyle;
	protected $strPosition = Position::DefaultStyle;
	protected $strTop = null;
	protected $strLeft = null;

	// miscellaneous
	protected $arrCustomStyles;
	protected $arrCustomAttributes;
	protected $arrJavaScriptActions = array();
	protected $blnReturnFalse = false;
	protected $strError;
	protected $blnIsBlockElement = true;

	public function __construct($objParentObject = null, $strControlId = null) {
		parent::__construct($objParentObject, $strControlId);

		try {
			if (!is_null($objParentObject)) {
				if ($objParentObject instanceof FormControl || $objParentObject instanceof ListControl || $objParentObject instanceof GroupControl || $objParentObject instanceof FormHandler) {
					$objParentObject->AddChildControl($this);
				} else {
					throw new CustomException(Exceptions::INVALID_CONTROL_PARENT_OBJECT, 'ParentObject must be a Control, List, Group or FormHandler object');
				}
			} else {
				throw new CustomException(Exceptions::ERROR, 'ParentObject and Control ID must be specified');
			}
		} catch (CustomException $e) {
			print $e;
			exit;
		}

		// Verify ControlId is only AlphaNumeric Characters
		$strMatches = array();
		$strPattern = '/[A-Za-z0-9]*/';
		preg_match($strPattern, $strControlId, $strMatches);
		try {
			if (count($strMatches) && ($strMatches[0] == $strControlId)) {
				$this->strControlId = $strControlId;
			} else {
				throw new CustomException(Exceptions::NON_ALPHANUMERIC_CONTROL_ID, sprintf("Control ID '%s' is not alphanumeric", $strControlId));
			}
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

	public function Render($blnDisplayOutput = true) {
		return $this->RenderOutput($strOutput, $blnDisplayOutput);
	}

	protected function RenderOutput($strOutput, $blnDisplayOutput, $blnForceAsBlockElement = false) {
		if (($blnForceAsBlockElement) || ($this->blnIsBlockElement)) {
			$blnIsBlockElement = true;
		} else {
			$blnIsBlockElement = false;
		}

		// Check for Visibility
		if (!$this->blnVisible) {
			$strOutput = '';
		}

		$strStyle = '';
		if (($this->strPosition) && ($this->strPosition != Position::DefaultStyle)) {
			$strStyle .= sprintf('position:%s;', $this->strPosition);
		}

		if (!$this->blnDisplay) {
			$strStyle .= 'display:none;';
		} else if (!$blnIsBlockElement) {
			$strStyle .= 'display:inline;';
		}

		if (strlen(trim($this->strLeft)) > 0) {
			$strLeft = null;
			try {
				$strLeft = $this->strLeft;
			} catch (Exception $e) {}

			if (is_null($strLeft)) {
				$strStyle .= sprintf('left:%s;', $this->strLeft);
			} else {
				$strStyle .= sprintf('left:%spx;', $this->strLeft);
			}
		}

		$strStyle = empty($strStyle)?'':sprintf(' style="%s"', $strStyle);

		if ($blnIsBlockElement) {
			$strOutput = sprintf('<div id="%s_ctl"%s>%s</div>%s', $this->strControlId, $strStyle, $strOutput, $this->GetControlHtml());
		} else {
			$strOutput = sprintf('<span id="%s_ctl"%s>%s</span>%s', $this->strControlId, $strStyle, $strOutput, $this->GetControlHtml());
		}

		// Output or Return
		if ($blnDisplayOutput) {
			print($strOutput);
		} else {
			return $strOutput;
		}
	}

/*
	protected function RenderChildren($blnDisplayOutput = true) {
		$strToReturn = "";

		foreach ($this->GetChildControls() as $objControl)
			if (!$objControl->Rendered) {
				$strRenderMethod = 'Render';
				if ($objControl->RenderMethod) {
					$strRenderMethod = $objControl->RenderMethod;
				}
				$strToReturn .= $objControl->$strRenderMethod($blnDisplayOutput);
			}

		if ($blnDisplayOutput) {
			print($strToReturn);
			return null;
		} else {
			return $strToReturn;
		}
	}
*/

/*
	public function AddChildControl(FormControl $objControl) {
		array_push($this->arrChildControls, $objControl);
	}

	public function AddCssClass($strCssClassName) {
		$blnAdded = false;
		$strNewCssClass = '';
		$strCssClassName = trim($strCssClassName);

		foreach (explode(' ', $this->strCssClass) as $strCssClass)
			if ($strCssClass = trim($strCssClass)) {
				if ($strCssClass == $strCssClassName)
					$blnAdded = true;
				$strNewCssClass .= $strCssClass . ' ';
			}
		if (!$blnAdded)
			$this->CssClass = $strNewCssClass . $strCssClassName;
		else
			$this->CssClass = trim($strNewCssClass);
	}
*/

	public function AddAction($objEvent, $objAction) {
		if (!($objEvent instanceof Event)) {
			throw new Exception('First parameter of AddAction is expecting an object of type Event');
		}

		if (!($objAction instanceof Action)) {
			throw new Exception('Second parameter of AddAction is expecting an object of type Action');
		}

		// Store the Event object in the Action object
		$objAction->Event = $objEvent;

		// Pull out the Event Name
		$strEventName = $objEvent->JavaScriptEvent;

		if (!array_key_exists($strEventName, $this->arrJavaScriptActions)) {
			$this->arrJavaScriptActions[$strEventName] = array();
		}
		array_push($this->arrJavaScriptActions[$strEventName], $objAction);

		return $this;
	}

	protected function GetAttributes($blnIncludeCustom = true, $blnIncludeAction = true) {
		$strToReturn = "";

		if ($this->blnDisabled) {
			$strToReturn .= 'disabled ';
		}
		if ($this->intTabIndex) {
			$strToReturn .= sprintf('tabindex="%s" ', $this->intTabIndex);
		}
		if ($this->strToolTip) {
			$strToReturn .= sprintf('title="%s" ', Application::HtmlEntities($this->strToolTip));
		}
		if ($this->strCssClass) {
			$strToReturn .= sprintf('class="%s" ', $this->strCssClass);
		}
		if ($this->strAccessKey) {
			$strToReturn .= sprintf('accesskey="%s" ', $this->strAccessKey);
		}
		if ($blnIncludeCustom) {
			$strToReturn .= $this->GetCustomAttributes();
		}
		if ($blnIncludeAction) {
			$strToReturn .= $this->GetActionAttributes();
		}

		return $strToReturn;
	}
	
	protected function GetCustomAttributes() {
		$strToReturn = null;
		if ($this->arrCustomAttributes) {
			foreach ($this->arrCustomAttributes as $strKey => $strValue) {
				$strToReturn .= sprintf('%s="%s" ', $strKey, $strValue);
			}
		}

		return $strToReturn;
	}

	protected function GetActionAttributes() {
		if (!empty($this->arrJavaScriptActions)) {
			$strToReturn = null;
			foreach ($this->arrJavaScriptActions as $strEventName => $objActions) {
				$strToReturn .= $this->GetJavaScriptForEvent($strEventName);
			}

			return $strToReturn;
		}
	}

	protected function GetJavaScriptForEvent($strEventName) {
		return Action::RenderActions($this, $strEventName, $this->arrJavaScriptActions[$strEventName]);
	}

	protected function GetStyleAttributes() {
		$strToReturn = "";
		$strTextDecoration = "";

		if ($this->strWidth) {
			if (is_numeric($this->strWidth)) {
				$strToReturn .= sprintf("width:%spx;", $this->strWidth);
			} else {
				$strToReturn .= sprintf("width:%s;", $this->strWidth);
			}
		}
		if ($this->strHeight) {
			if (is_numeric($this->strHeight)) {
				$strToReturn .= sprintf("height:%spx;", $this->strHeight);
			} else {
				$strToReturn .= sprintf("height:%s;", $this->strHeight);
			}
		}
		if (($this->strDisplayStyle) && ($this->strDisplayStyle != DisplayStyle::DefaultStyle)) {
			$strToReturn .= sprintf("display:%s;", $this->strDisplayStyle);
		}
		if ($this->strForeColor) {
			$strToReturn .= sprintf("color:%s;", $this->strForeColor);
		}
		if ($this->strBackColor) {
			$strToReturn .= sprintf("background-color:%s;", $this->strBackColor);
		}
		if ($this->strBorderColor) {
			$strToReturn .= sprintf("border-color:%s;", $this->strBorderColor);
		}
		if (strlen(trim($this->strBorderWidth)) > 0) {
			$strBorderWidth = null;
			$strBorderWidth = $this->strBorderWidth;
			if (is_null($strBorderWidth)) {
				$strToReturn .= sprintf('border-width:%s;', $this->strBorderWidth);
			} else {
				$strToReturn .= sprintf('border-width:%spx;', $this->strBorderWidth);
			}
			if ((!$this->strBorderStyle) || ($this->strBorderStyle == BorderStyle::DefaultStyle)) {
				$strToReturn .= "border-style:solid;";
			}
		}
		if (($this->strBorderStyle) && ($this->strBorderStyle != BorderStyle::DefaultStyle)) {
			$strToReturn .= sprintf("border-style:%s;", $this->strBorderStyle);
		}
		if ($this->strFontNames) {
			$strToReturn .= sprintf("font-family:%s;", $this->strFontNames);
		}
		if ($this->strFontSize) {
			if (is_numeric($this->strFontSize)) {
				$strToReturn .= sprintf("font-size:%spx;", $this->strFontSize);
			} else {
				$strToReturn .= sprintf("font-size:%s;", $this->strFontSize);
			}
		}
		if ($this->blnFontBold) {
			$strToReturn .= "font-weight:bold;";
		}
		if ($this->blnFontItalic) {
			$strToReturn .= "font-style:italic;";
		}
		if ($this->blnFontUnderline) {
			$strTextDecoration .= "underline ";
		}
		if ($this->blnFontOverline) {
			$strTextDecoration .= "overline ";
		}
		if ($this->blnFontStrikeout) {
			$strTextDecoration .= "line-through ";
		}
		if ($strTextDecoration) {
			$strTextDecoration = trim($strTextDecoration);
			$strToReturn .= sprintf("text-decoration:%s;", $strTextDecoration);
		}
		if (($this->strCursor) && ($this->strCursor != Cursor::DefaultStyle)) {
			$strToReturn .= sprintf("cursor:%s;", $this->strCursor);
		}
		if (($this->strOverflow) && ($this->strOverflow != Overflow::DefaultStyle)) {
			$strToReturn .= sprintf("overflow:%s;", $this->strOverflow);
		}
		if (!is_null($this->intOpacity)) {
			if (Application::IsBrowser(BrowserType::InternetExplorer)) {
				$strToReturn .= sprintf('filter:alpha(opacity=%s);', $this->intOpacity);
			} else {
				$strToReturn .= sprintf('opacity:%s;', $this->intOpacity / 100.0);
			}
		}
		if ($this->arrCustomStyles) foreach ($this->arrCustomStyles as $strKey => $strValue) {
			$strToReturn .= sprintf('%s:%s;', $strKey, $strValue);
		}

		return $strToReturn;
	}
	
	protected function GetEndHtml() {}

	protected function GetCustomAttribute($strName) {
		if ((is_array($this->arrCustomAttributes)) && (array_key_exists($strName, $this->arrCustomAttributes)))
			return $this->arrCustomAttributes[$strName];
		else
			throw new Exception(sprintf("Custom Attribute does not exist in Control '%s': %s", $this->strControlId, $strName));
	}

	protected function GetCustomStyle($strName) {
		if ((is_array($this->arrCustomStyles)) && (array_key_exists($strName, $this->arrCustomStyles)))
			return $this->arrCustomStyles[$strName];
		else
			throw new Exception(sprintf("Custom Style does not exist in Control '%s': %s", $this->strControlId, $strName));
	}

	protected function GetChildControl($strControlId) {}

	protected function GetChildControls($blnUseNumericIndexes = true) {}

	protected function SetCustomStyle($strName, $strValue) {
		if (!is_null($strValue))
			$this->arrCustomStyles[$strName] = $strValue;
		else {
			$this->arrCustomStyles[$strName] = null;
			unset($this->arrCustomStyles[$strName]);
		}

		return $this;
	}

	protected function SetCustomAttribute($strName, $strValue) {
		if (!is_null($strValue))
			$this->arrCustomAttributes[$strName] = $strValue;
		else {
			$this->arrCustomAttributes[$strName] = null;
			unset($this->arrCustomAttributes[$strName]);
		}

		return $this;
	}

	public function SetBackColor($mixValue) {
		$this->strBackColor = $mixValue;
		return $this;
	}

	public function SetBorderColor($mixValue) {
		$this->strBorderColor = $mixValue;
		return $this;
	}

	public function SetBorderStyle($mixValue) {
		$this->strBorderStyle = $mixValue;
		return $this;
	}

	public function SetBorderWidth($mixValue) {
		$this->strBorderWidth = $mixValue;
		return $this;
	}

	public function SetCssClass($mixValue) {
		$this->strCssClass = $mixValue;
		return $this;
	}

	public function SetDisplay($mixValue) {
		$this->blnDisplay = $mixValue;
		return $this;
	}

	public function SetDisplayStyle() {
		$this->strDisplayStyle = $mixValue;
		return $this;
	}

	public function SetFontBold($mixValue) {
		$this->blnFontBold = $mixValue;
		return $this;
	}

	public function SetFontItalic($mixValue) {
		$this->blnFontItalic = $mixValue;
		return $this;
	}

	public function SetFontNames($mixValue) {
		$this->strFontNames = $mixValue;
		return $this;
	}

	public function SetFontOverline($mixValue) {
		$this->blnFontOverline = $mixValue;
		return $this;
	}

	public function SetFontSize($mixValue) {
		$this->strFontSize = $mixValue;
		return $this;
	}

	public function SetFontStrikeout($mixValue) {
		$this->blnFontStrikeout = $mixValue;
		return $this;
	}

	public function SetFontUnderline($mixValue) {
		$this->blnFontUnderline = $mixValue;
		return $this;
	}

	public function SetForeColor($mixValue) {
		$this->strForeColor = $mixValue;
		return $this;
	}

	public function SetOpacity($mixValue) {
		$this->intOpacity = $mixValue;
		if (($this->intOpacity < 0) || ($this->intOpacity > 100)) {
			throw new Exception('Opacity must be an integer value between 0 and 100');
		}
		return $this;
	}

	public function SetAccessKey($mixValue) {
		$this->strAccessKey = $mixValue;
		return $this;
	}

	public function SetCausesValidation($mixValue) {
		$this->mixCausesValidation = $mixValue;
		return $this;
	}

	public function SetCursor($mixValue) {
		$this->strCursor = $mixValue;
		return $this;
	}

	public function SetDisabled($mixValue) {
		$this->blnDisabled = $mixValue;
		return $this;
	}

	public function SetRequired($mixValue) {
		$this->blnRequired = $mixValue;
		return $this;
	}

	public function SetTabIndex($mixValue) {
		$this->intTabIndex = $mixValue;
		return $this;
	}

	public function SetToolTip($mixValue) {
		$this->strToolTip = $mixValue;
		return $this;
	}

	public function SetVisible($mixValue) {
		$this->blnVisible = $mixValue;
		return $this;
	}

	public function SetWidth($mixValue) {
		$this->strWidth = $mixValue;
		return $this;
	}

	public function SetHeight($mixValue) {
		$this->strHeight = $mixValue;
		return $this;
	}

	public function SetHtmlBefore($mixValue) {
		$this->strHtmlBefore = $mixValue;
		return $this;
	}

	public function SetHtmlAfter($mixValue) {
		$this->strHtmlAfter = $mixValue;
		return $this;
	}

	public function SetInstructions($mixValue) {
		$this->strInstructions = $mixValue;
		return $this;
	}

	public function SetOverflow($mixValue) {
		$this->strOverflow = $mixValue;
		return $this;
	}

	public function SetPosition($mixValue) {
		$this->strPosition = $mixValue;
		return $this;
	}

	public function SetTop($mixValue) {
		$this->strTop = $mixValue;
		return $this;
	}

	public function SetLeft($mixValue) {
		$this->strLeft = $mixValue;
		return $this;
	}

	public function SetError($mixValue) {
		$this->strError = $mixValue;
		return $this;
	}

	public function __get($strName) {
		switch ($strName) {
			case "ControlId": return $this->strControlId;
			case "ParentControl": return $this->objParentControl;
			case "BackColor": return $this->strBackColor;
			case "BorderColor": return $this->strBorderColor;
			case "BorderStyle": return $this->strBorderStyle;
			case "BorderWidth": return $this->strBorderWidth;
			case "CssClass": return $this->strCssClass;
			case "Display": return $this->blnDisplay;
			case "DisplayStyle": return $this->strDisplayStyle;
			case "FontBold": return $this->blnFontBold;
			case "FontItalic": return $this->blnFontItalic;
			case "FontNames": return $this->strFontNames;
			case "FontOverline": return $this->blnFontOverline;
			case "FontSize": return $this->strFontSize;
			case "FontStrikeout": return $this->blnFontStrikeout;
			case "FontUnderline": return $this->blnFontUnderline;
			case "ForeColor": return $this->strForeColor;
			case "Opacity": return $this->intOpacity;
			case "AccessKey": return $this->strAccessKey;
			case "CausesValidation": return $this->mixCausesValidation;
			case "Cursor": return $this->strCursor;
			case "Disabled": return $this->blnDisabled;
			case "Required": return $this->blnRequired;
			case "TabIndex": return $this->intTabIndex;
			case "ToolTip": return $this->strToolTip;
			case "Visible": return $this->blnVisible;
			case "Height": return $this->strHeight;
			case "Width": return $this->strWidth;
			case "HtmlBefore": return $this->strHtmlBefore;
			case "HtmlAfter": return $this->strHtmlAfter;
			case "Instructions": return $this->strInstructions;
			case "Warning": return $this->strWarning;
			case "Overflow": return $this->strOverflow;
			case "Position": return $this->strPosition;
			case "Top": return $this->strTop;
			case "Left": return $this->strLeft;
			case "ReturnFalse": return $this->blnReturnFalse;
			case "Error": return $this->strError;

			default:
				try {
					throw new CustomException(Exceptions::ERROR, sprintf("FormControl Property '%s' does not exist", $strName));
				} catch(CustomException $e) {
					print $e;
					exit;
				}
		}
	}

	public function __set($strName, $mixValue) {
		switch ($strName) {
			case "BackColor": 
				$this->strBackColor = $mixValue;
				break;
			case "BorderColor":
				$this->strBorderColor = $mixValue;
				break;
			case "BorderStyle":
				$this->strBorderStyle = $mixValue;
				break;
			case "BorderWidth":
				$this->strBorderWidth = $mixValue;
				break;
			case "CssClass":
				$this->strCssClass = $mixValue;
				break;
			case "Display":
				$this->blnDisplay = $mixValue;
				break;
			case "DisplayStyle":
				$this->strDisplayStyle = $mixValue;
				break;
			case "FontBold":
				$this->blnFontBold = $mixValue;
				break;
			case "FontItalic":
				$this->blnFontItalic = $mixValue;
				break;
			case "FontNames":
				$this->strFontNames = $mixValue;
				break;
			case "FontOverline":
				$this->blnFontOverline = $mixValue;
				break;
			case "FontSize":
				$this->strFontSize = $mixValue;
				break;
			case "FontStrikeout":
				$this->blnFontStrikeout = $mixValue;
				break;
			case "FontUnderline":
				$this->blnFontUnderline = $mixValue;
				break;
			case "ForeColor":
				$this->strForeColor = $mixValue;
				break;
			case "Opacity":
				$this->intOpacity = $mixValue;
				if (($this->intOpacity < 0) || ($this->intOpacity > 100)) {
					try {
						throw new CustomException(Exceptions::ERROR, 'Opacity must be an integer value between 0 and 100');
					} catch(CustomException $e) {
						print $e;
						exit;
					}
				}
				break;
			case "AccessKey":
				$this->strAccessKey = $mixValue;
				break;
			case "CausesValidation":
				$this->mixCausesValidation = $mixValue;
				break;
			case "Cursor":
				$this->strCursor = $mixValue;
				break;
			case "Disabled":
				$this->blnDisabled = $mixValue;
				break;
			case "Required":
				$this->blnRequired = $mixValue;
				break;
			case "TabIndex":
				$this->intTabIndex = $mixValue;
				break;
			case "ToolTip":
				$this->strToolTip = $mixValue;
				break;
			case "Visible":
				$this->blnVisible = $mixValue;
				break;
			case "Height":
				$this->strHeight = $mixValue;
				break;
			case "Width":
				$this->strWidth = $mixValue;
				break;
			case "HtmlBefore":
				$this->strHtmlBefore = $mixValue;
				break;
			case "HtmlAfter":
				$this->strHtmlAfter = $mixValue;
				break;
			case "Instructions":
				$this->strInstructions = $mixValue;
				break;
			case "Warning":
				$this->strWarning = $mixValue;
				break;
			case "Overflow":
				$this->strOverflow = $mixValue;
				break;
			case "Position":
				$this->strPosition = $mixValue;
				break;
			case "Top":
				$this->strTop = $mixValue;
				break;
			case "Left":
				$this->strLeft = $mixValue;
				break;
			case "Error":
				$this->strError = $mixValue;
				break;

			default:
				try {
					throw new CustomException(Exceptions::ERROR, sprintf("FormControl Property '%s' does not exist", $strName));
				} catch(CustomException $e) {
					print $e;
					exit;
				}
		}
	}
}
?>
