<?php
class SessionModel extends ModelBase {

    private $objDb;

    public function __construct() {
        $this->objDb = ModelBase::getInstance();
    }

	public function GetUser($strUsername) {
		$objStmt = $this->objDb->prepare("
			SELECT
				tblAdmin.user_id,
				tblAdmin.password
			FROM
				tblAdmin
			WHERE
				tblAdmin.username = ?;
		");
		$objStmt->bind_param('s', $strUsername);
		$objStmt->execute();
		$objStmt->bind_result($intUserId, $strPassword);

		$arrResult = array();
		if ($objStmt->fetch()) {
			$arrResult['user_id'] = $intUserId;
			$arrResult['password'] = $strPassword;
		}

		return $arrResult;
	}

	public function GetUserFromCookie() {
		$objStmt = $this->objDb->prepare(
			sprintf("
				SELECT
					tblAdmin.username
				FROM
					tblAdmin
				WHERE
					tblAdmin.login_cookie = ?;
			")
		);
		$objStmt->bind_param('s', $_COOKIE[Auth::COOKIE_KEY]);
		$objStmt->bind_result($strUsername);
		$objStmt->execute();

		if ($objStmt->fetch()) {
			$strUsername = $strUsername;
		}

		return $strUsername;
	}

	public function LogOut($intUserId) {
		$objStmt = $this->objDb->prepare("
			UPDATE
				tblAdmin
			SET
				tblAdmin.login_cookie = NULL
			WHERE
				tblAdmin.user_id = ?;
		");
		$objStmt->bind_param('i', $intUserId);
		$objStmt->execute();

		return true;
	}

	public function UpdateCookie($intUserId, $strLoginCookie) {
		$objStmt = $this->objDb->prepare(
			sprintf("
				UPDATE
					tblAdmin
				SET
					tblAdmin.login_cookie = ?,
					tblAdmin.last_active = ?,
					tblAdmin.ip_address = ?
				WHERE
					tblAdmin.user_id = ?;
			")
		);
		$objStmt->bind_param('sssi',
			$strLoginCookie,
			date(DateFormats::DATETIME),
			Application::$RemoteAddress,
			$intUserId
		);
		$objStmt->execute();

		return true;
	}
}
?>
