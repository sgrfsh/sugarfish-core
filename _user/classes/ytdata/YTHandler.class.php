<?php
/**
 * File:		YTHandler.class.php
 * Created on:	Mon Jul 12 22:22 CST 2010
 *
 * @name 		YTHandler
 * @author 		Ian
 *
 * @copyright 	2010 Ian Atkin
 * @license		http://www.ianatkin.info/
 */

include "YTEntity.class.php";
include "YTVideo.class.php";
include "YTVideoArray.class.php";
include "YTChannel.class.php";
include "YTChannelArray.class.php";

class YTHandler {

	private $objEntity;

	public function __construct($mixInput = null) {
		if (!empty($mixInput)) {
			$this->CreateEntity($mixInput);
		}
	}

	/*
	 * @param mixed
	 */
	private function CreateEntity($mixInput) {
		/*
		 * make an object based on the entity type
		 * and pass in the parse output (array)
		 */
		if (is_array($mixInput)) {
			if (strlen($mixInput[0]) == 11) {
				$intInputType = 1;
			} elseif (strpos($mixInput[0], 'http') !== false) {
				$intInputType = 2;
			}
		} else {
			if (strlen($mixInput) == 11) {
				$intInputType = 3;
			} elseif (strpos($mixInput, 'http') !== false) {
				$intInputType = 4;
			}
		}

		/*
		 * 1. video array; 2. channel array; 3. video id; 4. channel array
		 */
		switch ($intInputType) {
			case 1:
				$this->objEntity = new YTVideoArray($this->ParseVideoArray($mixInput));
				break;
			case 2:
				$this->objEntity = new YTChannelArray($this->ParseChannelArray($mixInput));
				break;
			case 3:
				$this->objEntity = new YTVideo($this->ParseVideo($mixInput));
				break;
			case 4:
				$this->objEntity = new YTChannel($this->ParseChannel($mixInput));
				break;
			default:
				throw new Exception('Cannot parse input');
		}
	}

	/*
	 * @param string
	 * @return array
	 */
	private function ParseVideo($strVideoId) {
		return $this->ParseEntity($objEntry = simplexml_load_file('http://gdata.youtube.com/feeds/api/videos/' . $strVideoId));
	}

	/*
	 * @param array
	 * @return array
	 */
	private function ParseVideoArray($arrVideoIds){
		$arrVideos = array();
		foreach ($arrVideoIds as $strVideoId) {
			array_push($arrVideos, $this->ParseEntity($objEntry = simplexml_load_file('http://gdata.youtube.com/feeds/api/videos/' . $strVideoId)));
		}
		return $arrVideos;
	}

	/*
	 * @param string
	 * @return array
	 */
	private function ParseChannel($strChannel) {
		$arrVideos = array();
		$objSimpeXml = simplexml_load_file($strChannel);
		foreach ($objSimpeXml->entry as $objEntry) {
			array_push($arrVideos, $this->ParseEntity($objEntry));
		}
		return $arrVideos;
	}

	/*
	 * @param array
	 * @return array
	 */
	private function ParseChannelArray($arrChannels) {
		$arrVideos = array();
		foreach ($arrChannels as $strChannel) {
			$objSimpeXml = simplexml_load_file($strChannel);
			foreach ($objSimpeXml->entry as $objEntry) {
				array_push($arrVideos, $this->ParseEntity($objEntry));
			}
		}
		return $arrVideos;
	}

	/*
	 * @param object
	 * @return array
	 */
	private function ParseEntity($objEntry) {
		$objMedia = $objEntry->children('http://search.yahoo.com/mrss/');

		$objAttrs = $objMedia->group->player->attributes();
		$strWatch = $objAttrs['url'];
		$strWatch = str_replace('http://www.youtube.com/watch?v=', '', $strWatch);
		$strWatch = str_replace('&feature=youtube_gdata', '', $strWatch);
		$arrVideo['watch'] = $strWatch;

		$objYt = $objEntry->children('http://gdata.youtube.com/schemas/2007');

		$objAttrs = $objYt->statistics->attributes();
		@$arrVideo['views'] = $objAttrs['viewCount'];
		$objYt = $objMedia->children('http://gdata.youtube.com/schemas/2007');
		$objAttrs = $objYt->duration->attributes();
		$arrVideo['length'] = $objAttrs['seconds'];
		$objAttrs = $objMedia->group->thumbnail[0]->attributes();
		$arrVideo['thumbnail'] = $objAttrs['url'];

		$objGd = $objEntry->children('http://schemas.google.com/g/2005');
		if ($objGd->rating) {
			$objAttrs = $objGd->rating->attributes();
			$arrVideo['rating'] = $objAttrs['average'];
		} else {
			$arrVideo['rating'] = 0;
		}

		$arrVideo['title'] = $objMedia->group->title;
		$arrVideo['title'] = str_replace(chr(34), '\&quot;', $arrVideo['title']);
		$arrVideo['title'] = str_replace(chr(39), '\&#039;', $arrVideo['title']);
		$arrVideo['description'] = $objMedia->group->description;

		return $arrVideo;
	}

	/*
	 * @param mixed
	 */
	public function SetEntity($mixInput = null) {
		if (empty($mixInput)) {
			throw new Exception('Null input exception');
		}
		$this->CreateEntity($mixInput);
	}

	/*
	 * @param string
	 */
	public function __get($strName) {
		if (!is_null($this->objEntity)) {
			switch ($strName) {
				case 'Entity':
					return $this->objEntity->VideoArray;
					break;
				case 'EntityType':
					return get_class($this->objEntity);
					break;
				case 'Count':
					switch (get_class($this->objEntity)) {
						case 'YTVideo':
							return 1;
							break;
						default:
							return count($this->objEntity->VideoArray);
					}
					break;
				case 'PrintSummary':
					switch (get_class($this->objEntity)) {
						case 'YTVideo':
							print $this->objEntity->VideoArray['title'];
							break;
						default:
							$i = 1;
							foreach ($this->objEntity->VideoArray as $arrVideo) {
								printf('%s. %s<br />', $i, stripslashes($arrVideo['title']));
								$i++;
							}
					}
			}
		}
	}
}
?>
