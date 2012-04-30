<?php
/**
 * File: QueryBuilder.class.php
 * Created on: Thu Apr 23 02:04 CST 2009
 *
 * @author Ian
 *
 * @copyright  2009 Ian Atkin
 * @license    http://www.ianatkin.info/
 * 
 * @package sugarfish_core
 * 
 * @deprecated to be removed
 */

class QueryBuilder {
	protected $strColumns;
	protected $strCriteria;
	protected $intPage;
	protected $intItemsPerPage;
	protected $strJoin;
	protected $strConditions;
	protected $strOrderByClause;
	protected $strLimitClause;
	protected $strNumRowsQuery;
	protected $strQuery;
	protected $objDataModel;

	public function __construct($strCriteria, $intPage = 1, $intItemsPerPage = 25, $objDataModel) {
		$this->strCriteria = $strCriteria;
		$this->intPage = $intPage;
		$this->intItemsPerPage = $intItemsPerPage;
		$this->objDataModel = $objDataModel;

		$this->ConstructLimitClause();
	}

	public function ConstructJobListingFilter() {
		$strNow = date(DateFormats::DATETIME);
		$this->strColumns = "tblRequisitions.requisition_id AS requisition_id,\n\ttblRequisitions.city AS city,\n\ttblRequisitions.fips_state AS fips_state,\n\ttblRequisitions.zipcode AS zipcode,\n\ttblRequisitions.country_id AS country_id,\n\ttblRequisitions.hide_location AS hide_location,\n\ttblRequisitions.no_fixed_location AS no_fixed_location,\n\ttblRequisitions.job_title AS job_title,\n\ttblRequisitions.company AS company,\n\ttblRequisitions.description AS description,\n\ttblRequisitions.post_date AS post_date";
		$this->strOrderByClause = "ORDER BY tblRequisitions.post_date DESC";

		/**
		 * criteria string consists of these 5 elements:
		 * 0: keywords
		 * 1: placename
		 * 2: state
		 * 3: radius
		 * 4: country
		 */

		$arrCriteria = explode('|', $this->strCriteria);

		// KEYWORDS
		/**
		 * Removing punctuation first and then spacing so that removed
		 * characters don't leave 2 or more spaces in sequence.
		 */

		// convert keywords into an array of distinct elements
		$arrKeywords = explode(chr(32), $arrCriteria[0]);

		// create WHERE clause elements
		// append the keywords to a set of OR'd IN clauses
		$arrColumns = array("job_title", "company", "description");

		$this->strConditions .= "(\n\t";
		$i = 0;
		foreach ($arrColumns as $strColumn) {
			foreach ($arrKeywords as $strKeyword) {
				if (strlen($strKeyword) > 0) {
					$this->strConditions .= sprintf("tblRequisitions.%s LIKE %s", $strColumn, chr(39) . chr(37) . $strKeyword . chr(37) . chr(39));
				} else {
					$this->strConditions .= sprintf("tblRequisitions.%s LIKE %s", $strColumn, chr(39) . chr(37) . chr(39));
				}
				if ($i < (count($arrColumns) * count($arrKeywords))-1) {
					$this->strConditions .= "\n\tOR ";
				}
				$i++;
			}
		}
		$this->strConditions .= "\n) ";

		// PLACENAME / STATE / RADIUS
		if ($arrCriteria[4] == 233) {
			// U.S.A.
			if (strlen($arrCriteria[1]) > 0) {
				$arrReturn = $this->objDataModel->getPlacenamesWithinRadiusOfPlacename($arrCriteria[1], $arrCriteria[2], $arrCriteria[3]);

				if (count($arrReturn[0]) > 0) {
					$this->strConditions .= "AND (\n\t";

					foreach ($arrReturn[0] as $arrPlacename) {
						$this->strConditions .=  sprintf("(tblRequisitions.city = '%s' AND tblRequisitions.fips_state = '%s')", $arrPlacename['placename'], $arrPlacename['fips_state']);
						$this->strConditions .= "\n\tOR ";
					}

					$i = 0;
					foreach ($arrReturn[1] as $strZipcode) {
						$this->strConditions .=  sprintf("tblRequisitions.zipcode = '%s'", $strZipcode);
						if ($i < count($arrReturn[1])-1) {
							$this->strConditions .= "\n\tOR ";
						}
						$i++;
					}
					$this->strConditions .= "\n)";
				}
			}
		}

		// COUNTRY
		if ($arrCriteria[4] != 0) {
			$this->strConditions .=  sprintf("\n\tAND tblRequisitions.country_id = %s", $arrCriteria[4]);
		}

		// append the rest of our conditions
		$this->strConditions .= sprintf("\n\tAND tblRequisitions.paid = 1\n\tAND tblRequisitions.active = 1\n\tAND '%s' BETWEEN tblRequisitions.post_date AND tblRequisitions.end_date", $strNow);

		$this->strNumRowsQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblRequisitions\nWHERE\n%s\n%s;", $this->strColumns, $this->strConditions, $this->strOrderByClause);
		$this->strQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblRequisitions\nWHERE\n%s\n%s\n%s;", $this->strColumns, $this->strConditions, $this->strOrderByClause, $this->strLimitClause);
	}

	public function ConstructCurrentJobListing() {
		$strNow = date(DateFormats::DATETIME);
		$this->strColumns = "tblRequisitions.requisition_id AS requisition_id,\n\ttblRequisitions.city AS city,\n\ttblRequisitions.fips_state AS fips_state,\n\ttblRequisitions.zipcode AS zipcode,\n\ttblRequisitions.country_id AS country_id,\n\ttblRequisitions.hide_location AS hide_location,\n\ttblRequisitions.no_fixed_location AS no_fixed_location,\n\ttblRequisitions.job_title AS job_title,\n\ttblRequisitions.company AS company,\n\ttblRequisitions.description AS description,\n\ttblRequisitions.active AS active,\n\ttblRequisitions.post_date AS post_date,\n\ttblRequisitions.end_date AS end_date";
		$this->strOrderByClause = "ORDER BY tblRequisitions.post_date DESC";

		// create WHERE clause element
		$this->strConditions = sprintf("\ttblRequisitions.client_id = %s\n", $this->strCriteria);

		// append the rest of our conditions
		$this->strConditions .= sprintf("\n\tAND tblRequisitions.paid = 1\n\tAND '%s' BETWEEN tblRequisitions.post_date AND tblRequisitions.end_date", $strNow);

		$this->strNumRowsQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblRequisitions\nWHERE\n%s\n%s;", $this->strColumns, $this->strConditions, $this->strOrderByClause);
		$this->strQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblRequisitions\nWHERE\n%s\n%s\n%s;", $this->strColumns, $this->strConditions, $this->strOrderByClause, $this->strLimitClause);
	}

	public function ConstructExpiredJobListing() {
		$strNow = date(DateFormats::DATETIME);
		$this->strColumns = "tblRequisitions.requisition_id AS requisition_id,\n\ttblRequisitions.city AS city,\n\ttblRequisitions.fips_state AS fips_state,\n\ttblRequisitions.zipcode AS zipcode,\n\ttblRequisitions.country_id AS country_id,\n\ttblRequisitions.hide_location AS hide_location,\n\ttblRequisitions.no_fixed_location AS no_fixed_location,\n\ttblRequisitions.job_title AS job_title,\n\ttblRequisitions.company AS company,\n\ttblRequisitions.description AS description,\n\ttblRequisitions.active AS active,\n\ttblRequisitions.post_date AS post_date";
		$this->strOrderByClause = "ORDER BY tblRequisitions.post_date DESC";

		// create WHERE clause element
		$this->strConditions = sprintf("\ttblRequisitions.client_id = %s\n", $this->strCriteria);

		// append the rest of our conditions
		$this->strConditions .= sprintf("\n\tAND tblRequisitions.paid = 1\n\tAND  '%s' > tblRequisitions.end_date", $strNow);

		$this->strNumRowsQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblRequisitions\nWHERE\n%s\n%s;", $this->strColumns, $this->strConditions, $this->strOrderByClause);
		$this->strQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblRequisitions\nWHERE\n%s\n%s\n%s;", $this->strColumns, $this->strConditions, $this->strOrderByClause, $this->strLimitClause);
	}

	public function ConstructDraftJobListing() {
		$this->strColumns = "tblRequisitions.requisition_id AS requisition_id,\n\ttblRequisitions.city AS city,\n\ttblRequisitions.fips_state AS fips_state,\n\ttblRequisitions.zipcode AS zipcode,\n\ttblRequisitions.country_id AS country_id,\n\ttblRequisitions.hide_location AS hide_location,\n\ttblRequisitions.no_fixed_location AS no_fixed_location,\n\ttblRequisitions.job_title AS job_title,\n\ttblRequisitions.company AS company,\n\ttblRequisitions.description AS description,\n\ttblRequisitions.active AS active,\n\ttblRequisitions.post_date AS post_date";
		$this->strOrderByClause = "ORDER BY tblRequisitions.post_date DESC";

		// create WHERE clause element
		$this->strConditions = sprintf("\ttblRequisitions.client_id = %s\n", $this->strCriteria);

		// append the rest of our conditions
		$this->strConditions .= "\n\tAND tblRequisitions.paid = 0";

		$this->strNumRowsQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblRequisitions\nWHERE\n%s\n%s;", $this->strColumns, $this->strConditions, $this->strOrderByClause);
		$this->strQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblRequisitions\nWHERE\n%s\n%s\n%s;", $this->strColumns, $this->strConditions, $this->strOrderByClause, $this->strLimitClause);
	}

	public function ConstructJobseekerListingFilter() {
		$strNow = date(DateFormats::DATETIME);
		$this->strColumns = "tblJobseekers.jobseeker_id AS jobseeker_id,\n\ttblJobseekers.fname AS fname,\n\ttblJobseekers.summary AS summary,\n\ttblJobseekers.experience AS experience,\n\ttblJobseekers.lname AS lname,\n\ttblJobseekers.city AS city,\n\ttblJobseekers.fips_state AS fips_state,\n\ttblJobseekers.zipcode AS zipcode,\n\ttblJobseekers.country_id AS country_id";
		$this->strOrderByClause = "ORDER BY tblMembers.date_registered DESC";

		/**
		 * criteria string consists of these 5 elements:
		 * 0: keywords
		 * 1: placename
		 * 2: state
		 * 3: radius
		 * 4: country
		 */

		$arrCriteria = explode('|', $this->strCriteria);

		// KEYWORDS
		/**
		 * Removing punctuation first and then spacing so that removed
		 * characters don't leave 2 or more spaces in sequence.
		 */

		// convert keywords into an array of distinct elements
		$arrKeywords = explode(chr(32), $arrCriteria[0]);

		// JOIN clause
		$this->strJoin = "JOIN tblMembers ON tblJobseekers.jobseeker_id = tblMembers.member_id\nJOIN tblResumes ON tblJobseekers.jobseeker_id = tblResumes.jobseeker_id";

		// create WHERE clause elements
		// append the keywords to a set of OR'd IN clauses
		$arrColumns = array("tblJobseekers.experience", "tblResumes.raw_text");

		$this->strConditions .= "(\n\t";
		$i = 0;
		foreach ($arrColumns as $strColumn) {
			foreach ($arrKeywords as $strKeyword) {
				if (strlen($strKeyword) > 0) {
					$this->strConditions .= sprintf("%s LIKE %s", $strColumn, chr(39) . chr(37) . $strKeyword . chr(37) . chr(39));
				} else {
					$this->strConditions .= sprintf("%s LIKE %s", $strColumn, chr(39) . chr(37) . chr(39));
				}
				if ($i < (count($arrColumns) * count($arrKeywords))-1) {
					$this->strConditions .= "\n\tOR ";
				}
				$i++;
			}
		}
		$this->strConditions .= "\n) ";

		// PLACENAME / STATE / RADIUS
		if ($arrCriteria[4] == 233) {
			// U.S.A.
			if (strlen($arrCriteria[1]) > 0) {
				$arrReturn = $this->objDataModel->getPlacenamesWithinRadiusOfPlacename($arrCriteria[1], $arrCriteria[2], $arrCriteria[3]);

				if (count($arrReturn[0]) > 0) {
					$this->strConditions .= "AND (\n\t";

					foreach ($arrReturn[0] as $arrPlacename) {
						$this->strConditions .=  sprintf("(tblJobseekers.city = '%s' AND tblJobseekers.fips_state = '%s')", $arrPlacename['placename'], $arrPlacename['fips_state']);
						$this->strConditions .= "\n\tOR ";
					}

					$i = 0;
					foreach ($arrReturn[1] as $strZipcode) {
						$this->strConditions .=  sprintf("tblJobseekers.zipcode = '%s'", $strZipcode);
						if ($i < count($arrReturn[1])-1) {
							$this->strConditions .= "\n\tOR ";
						}
						$i++;
					}
					$this->strConditions .= "\n)";
				}
			}
		}

		// COUNTRY
		if ($arrCriteria[4] != 0) {
			$this->strConditions .=  sprintf("\n\tAND tblJobseekers.country_id = %s", $arrCriteria[4]);
		}

		// append the rest of our conditions
		$this->strConditions .= "\n\tAND tblJobseekers.search_preference = 1\n\tAND tblMembers.verified = 1\n\tAND tblMembers.disabled = 0";

		$this->strNumRowsQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblJobseekers\n%s\nWHERE\n%s\n%s;", $this->strColumns, $this->strJoin, $this->strConditions, $this->strOrderByClause);
		$this->strQuery = sprintf("SELECT\n\t%s\nFROM\n\ttblJobseekers\n%s\nWHERE\n%s\n%s\n%s;", $this->strColumns, $this->strJoin, $this->strConditions, $this->strOrderByClause, $this->strLimitClause);
	}

	private function ConstructLimitClause() {
		// limit 0, 25
		$intStart = ($this->intItemsPerPage * $this->intPage) - ($this->intItemsPerPage);
		$this->strLimitClause = sprintf("LIMIT %s, %s", $intStart, $this->intItemsPerPage);
	}

	public function __set($strName, $mixValue) {
		switch ($strName) {
			case 'Criteria':
				$this->strCriteria = $mixValue;
				break;
		}
	}

	public function __get($strName) {
		switch ($strName) {
			case 'NumRowsQuery':
				return $this->strNumRowsQuery;
				break;
			case 'Query':
				return $this->strQuery;
				break;
		}
	}
}
?>