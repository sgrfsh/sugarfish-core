<?php
class UserFunctions {

	/**
	* This faux constructor method throws a caller exception.
	* The Functions object should never be instantiated!!!
	*
	* @return void
	*/
	public final function __construct() {
		try {
			$strMessage = "UserFunctions should never be instantiated. All methods and variables are publically statically accessible";
			throw new CustomException(Exceptions::STATIC_CLASS_INSTANTIATION, $strMessage);
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

    public static function _stripFromEnd($strValue, $intChars) {
        return substr($strValue, 0, strlen($strValue) - $intChars);
    }
}
?>
