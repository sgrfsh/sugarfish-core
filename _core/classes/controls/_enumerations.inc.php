<?php
/**
 * File: _enumerations.inc.php
 * Created on: Mon Sep 6 16:15 CST 2010
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 */

/**
  * @package sugarfish_core
  * @name BorderCollapse
  */
abstract class BorderCollapse {
	const DefaultStyle = 'default';
	const Separate = 'Separate';
	const Collapse = 'Collapse';
}

/**
  * @package sugarfish_core
  * @name BorderStyle
  */
abstract class BorderStyle {
	const DefaultStyle = 'default';
	const None = 'none';
	const Dotted = 'dotted';
	const Dashed = 'dashed';
	const Solid = 'solid';
	const Double = 'double';
	const Groove = 'groove';
	const Ridge = 'ridge';
	const Inset = 'inset';
	const Outset = 'outset';
}

/**
  * @package sugarfish_core
  * @name Cursor
  */
abstract class Cursor {
	const DefaultStyle = 'default';
	const Auto = 'auto';
	const CrossHair = 'crosshair';
	const Pointer = 'pointer';
	const Move = 'move';
	const EResize = 'e-resize';
	const NEResize = 'ne-resize';
	const NWResize = 'nw-resize';
	const NResize = 'n-resize';
	const SEResize = 'se-resize';
	const SWResize = 'sw-resize';
	const SResize = 's-resize';
	const WResize = 'w-resize';
	const Text = 'text';
	const Wait = 'wait';
	const Help = 'help';
	const Progress = 'progress';
}

/**
  * @package sugarfish_core
  * @name DisplayStyle
  */
abstract class DisplayStyle {
	const None = 'none';
	const Block = 'block';
	const Inline = 'inline';
	const DefaultStyle = 'default';
}

/**
  * @package sugarfish_core
  * @name GridLines
  */
abstract class GridLines {
	const None = 'none';
	const Horizontal = 'horizontal';
	const Vertical = 'vertical';
	const Both = 'both';
}

/**
  * @package sugarfish_core
  * @name HorizontalAlign
  */
abstract class HorizontalAlign {
	const DefaultStyle = 'default';
	const Left = 'left';
	const Center = 'center';
	const Right = 'right';
	const Justify = 'justify';
}

/**
  * @package sugarfish_core
  * @name Overflow
  */
abstract class Overflow {
	const DefaultStyle = 'default';
	const Auto = 'auto';
	const Hidden = 'hidden';
	const Scroll = 'scroll';
	const Visible = 'visible';
}

/**
  * @package sugarfish_core
  * @name Position
  */
abstract class Position {
	const Relative = 'relative';
	const Absolute = 'absolute';
	const Fixed = 'fixed';
	const DefaultStyle = 'default';
}

/**
  * @package sugarfish_core
  * @name SelectionMode
  */
abstract class SelectionMode {
	const Single = 'Single';
	const Multiple = 'Multiple';
	const None = 'None';
}

/**
  * @package sugarfish_core
  * @name TextAlign
  */
abstract class TextAlign {
	const Left = 'left';
	const Right = 'right';
}

/**
  * @package sugarfish_core
  * @name TextMode
  */
abstract class TextMode {
	const SingleLine = 'SingleLine';
	const MultiLine = 'MultiLine';
	const Password = 'Password';
}

/**
  * @package sugarfish_core
  * @name RepeatDirection
  */
abstract class RepeatDirection {
	const Horizontal = 'Horizontal';
	const Vertical = 'Vertical';
}

/**
  * @package sugarfish_core
  * @name VerticalAlign
  */
abstract class VerticalAlign {
	const DefaultStyle = 'default';
	const Top = 'top';
	const Middle = 'middle';
	const Bottom = 'bottom';
}
?>
