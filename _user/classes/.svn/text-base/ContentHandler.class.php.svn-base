<?php
class ContentHandler implements TemplateManager {
	const __PAGES__ = 'pages';
	
	private $objContentModel;
	private $strCleanTitle;
	private $arrContent;

	private $strDateModified;
	private $strCacheCallerResult;
	const __CONTENT_NOT_FOUND__ = 'content not found';
	const __CONTENT_DISABLED__ = 'content disabled';

	public function __construct($strCleanTitle = null) {
		$this->objContentModel = new ContentModel;

		if ($strCleanTitle != null) {
			$this->strCleanTitle = $strCleanTitle;
		} else {
			return false;
		}

		if (!$this->GetContentFromCache()) {
			switch ($this->strCacheCallerResult) {
				case self::__CONTENT_NOT_FOUND__:
				case self::__CONTENT_DISABLED__:
					return false;
				default:
					// content isn't cached; try to get it from the db
					if (!$this->GetContentFromDb()) {
						// content does not exist
						return false;
					}
			}
		}
	}

	private function GetContentFromCache() {
		$arrResult = $this->objContentModel->getPageFromCache($this->strCleanTitle, Application::Request('page'));

		if ($arrResult['num_rows'] == 1) {
			if ($arrResult['disabled'] == 1) {
				$this->strCacheCallerResult = self::__CONTENT_DISABLED__;
				return false;
			}
			$intContentId = $arrResult['id'];
			$this->arrContent['title'] = $arrResult['title'];
			$this->arrContent['date_created'] = new DateTime($arrResult['date_created']);
			$this->strDateModified = $arrResult['date_modified'];

			if (!$this->ReadCache(sprintf('%s/%s/%s', __DOCROOT__, self::__PAGES__, $intContentId))) {
				return false;
			}
		} else {
			$this->strCacheCallerResult = self::__CONTENT_NOT_FOUND__;
			return false;
		}

		return true;
	}

	private function GetContentFromDb() {
		$arrResult = $this->objContentModel->getPageFromDb($this->strCleanTitle, Application::Request('page'));

		if ($arrResult['num_rows'] == 1) {
			$intContentId = $arrResult['id'];
			$strContentId = sprintf('%s%s', substr('0000000', 0, 7-strlen($intContentId)), $intContentId);
			$intPage = intval($arrResult['page']);

			if ($intPage > 0) {
				$strUrl = sprintf('/page/index/article/title/%s/page/', $this->strCleanTitle);
				$objPageNavigator = new PageNavigator($strUrl, $intPage, $arrResult['page_count'], 1);
				$strPagination = $objPageNavigator->Pagination;
				Application::Log('Url: ' . $strUrl);
				Application::Log('Page: ' . $intPage);
				Application::Log('Count: ' . $arrResult['page_count']);
			}
			$this->arrContent['title'] = $arrResult['title'];
			$this->arrContent['date_created'] = new DateTime($arrResult['date_created']);

			if (is_null($strPagination)) {
				$this->arrContent['content'] = Functions::CleanRenderedText(stripslashes($arrResult['content']));
			} else {
				$this->arrContent['content'] = sprintf('%s%s', Functions::CleanRenderedText(stripslashes($arrResult['content'])), $strPagination);
			}

			$this->WriteCache(sprintf('%s/%s/%s', __DOCROOT__, self::__PAGES__, $strContentId));

			return true;
		} else {
			return false;
		}
	}

	/*
	 * @param string
	 */
	private function ReadCache($strFilename) {
		if (file_exists($strFilename)) {
			// read the file from the cache
			// is the cache older than the db?
			//printf('%s : %s (%s)', strtotime($this->arrContent['date_modified']), filemtime($strFilename), (strtotime($this->arrContent['date_modified']) > filemtime($strFilename))?'yes':'no');
			if (strtotime($this->strDateModified) > filemtime($strFilename)) {
				return false;
			}
			$this->arrContent['content'] = file_get_contents($strFilename);

			return true;
		} else {
			return false;
		}
	}

	/*
	 * @param string
	 */
	private function WriteCache($strFilename) {
		$hdlFile = fopen($strFilename, "w");
		fwrite($hdlFile, $this->arrContent['content']);
		fclose($hdlFile);
		chmod($strFilename, 0666);
	}

	public function Render() {
		_p($this->arrContent['content'], false);
	}

	public function GetContent() {
		return $this->arrContent;
	}

	/*
	 * @param string
	 */
	public function __get($strName) {
		switch ($strName) {
			case 'Title':
				return $this->arrContent['title'];
				break;
			case 'DateCreated':
				$strDateCreated = $this->arrContent['date_created'];
				if (empty($strDateCreated)) {
					$objDT = new DateTime($this->arrContent['date_created']);
					return $objDT->format("m-d-Y h:i:sa");
				}
				break;
			case 'Content':
				return $this->arrContent['content'];
				break;
			case 'ContentNotFound':
				return empty($this->arrContent);
		}
	}
}
?>
