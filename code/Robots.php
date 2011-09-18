<?php
/**
 * Provides robots.txt functionality
 */
class Robots extends Controller {
	/**
	 * @var boolean
	 */
	public static $enabled = true;
	
	/**
	 * @var boolean
	 */
	public static $block_entire_site = false;
	
	public function index($url) {
		if (self::$enabled) {
			$text = "";
			$blockedUrls = $this->blockedUrls();
			if (count($blockedUrls) > 0) {
				$text = "User-agent: *\n";
				foreach ($this->blockedUrls() as $url) {
					$text .= "Disallow: $url\n";
				}
			}
			$response = new SS_HTTPResponse($text, 200);
			$response->addHeader("Content-Type", "text/plain; charset=\"utf-8\"");
			return $response;
		} else {
			return new SS_HTTPResponse('Not allowed', 405);
		}
	}
	
	/**
	 * Gets all the urls that are blocked
	 */
	public function blockedUrls() {
		if (self::$block_entire_site) {
			return array('/' => '/');
		} else {
			$bt = defined('DB::USE_ANSI_SQL') ? "\"" : "`";
			$filter = "{$bt}BlockFromSearchEngines{$bt} = 1";
			
			$itemSet = new DataObjectSet();
			$itemSet->merge(Versioned::get_by_stage('SiteTree', 'Live', $filter));
			$itemSet->merge(DataObject::get('Folder', $filter));
			
			$items = array();
			foreach ($itemSet as $item) {
				$items[$item->Link()] = $item->Link();
			}
			return $items;
		}
	}
}