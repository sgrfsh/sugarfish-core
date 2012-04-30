<?php
/**
 * @deprecated replaced with the new MySQLi class implementation
 */
class DataModel {
	/**
	 * This faux constructor method throws a caller exception.
	 * The DataModel object should never be instantiated!!!
	 *
	 * @return void
	 */
	public final function __construct() {
		try {
			$strMessage = "DataModel should never be instantiated. All methods and variables are publically statically accessible";
		throw new CustomException(Exceptions::STATIC_CLASS_INSTANTIATION, $strMessage);
		} catch (CustomException $e) {
			print $e;
			exit;
		}
	}

	/**
	 * Return a 'page' based on the given title
	 * @deprecated 
	 */
	public static function getPage($strTitle) {
		$strQuery = sprintf("
			SELECT
				cd.content_title AS title,
				cd.date_created AS date_created,
				c.content
			FROM
				tblContentDetail AS cd
			JOIN
				tblContent AS c
			ON
				cd.content_id = c.content_id
			WHERE
				cd.content_clean_title = '%s';
			",
			$strTitle
		);

		$arrPage = array();
		$objResult = MySqlDb::Query($strQuery);
		if ($objRow = MySqlDb::FetchAssoc($objResult)) {
			$arrPage['title'] = strtolower($objRow['title']);
			$arrPage['date_created'] = $objRow['date_created'];
			$arrPage['content'] = $objRow['content'];
		}

		return $arrPage;
	}

	/**
	 * Return array of all pages
	 */
	public static function getPages() {
		if ($intLimit > 0) {
			$strLimit = sprintf(' LIMIT 0, %s', $intLimit);
		}
		$strQuery = "
			SELECT
				cd.content_title AS title,
				cd.content_clean_title AS url
			FROM
				tblContentDetail AS cd
			WHERE
				cd.disabled IS NULL AND (cd.page IS NULL OR cd.page = 1)
			ORDER BY date_created DESC;
		";
		$arrPages = array();
		$objResult = MySqlDb::Query($strQuery);
		while ($objRow = MySqlDb::FetchAssoc($objResult)) {
			$arrPage = array();
			$arrPage['title'] = strtolower($objRow['title']);
			$arrPage['url'] = $objRow['url'];
			array_push($arrPages, $arrPage);
			unset($arrPage);
		}

		return $arrPages;
	}

	/**
	 * Return latest page snippets
	 */
	public static function getPageSnippets() {
		$strLimit = ' LIMIT 0, 3';
		$strQuery = "
			SELECT
				cd.content_title AS title,
				cd.content_clean_title AS url,
				c.content as content
			FROM
				tblContentDetail AS cd
			JOIN
				tblContent AS c ON c.content_id = cd.content_id
			WHERE
				cd.disabled IS NULL AND (cd.page IS NULL OR cd.page = 1)
			ORDER BY cd.date_created DESC$strLimit;
		";
		$arrPages = array();
		$objResult = MySqlDb::Query($strQuery);
		while ($objRow = MySqlDb::FetchAssoc($objResult)) {
			$arrPage = array();
			$arrPage['title'] = strtolower($objRow['title']);
			$arrPage['url'] = $objRow['url'];
			$arrPage['snippet'] = String::Truncate(strtolower(strip_tags($objRow['content'])), 75, ' &hellip;');
			array_push($arrPages, $arrPage);
			unset($arrPage);
		}

		return $arrPages;
	}

	public static function getContentTest() {
		$objDb = new MySQLI(__DB_SERVER__, __DB_USERNAME__, __DB_PASSWORD__, __DB__);
		$objResult = $objDb->query("CALL spGetContent();");

		$arrContent = array();
		$i = 0;
		while ($objRow = $objResult->fetch_assoc()) {
			$arrContent[$i]['title'] = $objRow['content_title'];
			$arrContent[$i]['content'] = strip_tags($objRow['content']);
			$i++;
		}
		$objResult->free();

		return $arrContent;
	}
}
?>
