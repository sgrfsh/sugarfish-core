<?php
/**
 * File: ModelBase.class.php
 * Created on: Mon Oct 11 23:19 CST 2010
 *
 * @author Ian
 *
 * @copyright  2010 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * @name ModelBase
 */

class ModelBase extends MySQLi {

	private static $objDb = null;

    private function __construct($strServer, $strUsername, $strPassword, $strDatabase) {
        try {
            parent::__construct($strServer, $strUsername, $strPassword, $strDatabase);

            if (mysqli_connect_errno()) {
                throw new Exception(mysqli_connect_error(), mysqli_connect_errno());
            }
        } catch (CustomException $e) {
            print $e;
            exit;
        }
    }

    public static function getInstance($strServer = __DB_SERVER__, $strUsername = __DB_USERNAME__, $strPassword = __DB_PASSWORD__, $strDatabase = __DB__) {
        if (!self::$objDb) {
            self::$objDb = new ModelBase($strServer, $strUsername, $strPassword, $strDatabase);
        }

        return self::$objDb;
    }
}
?>
