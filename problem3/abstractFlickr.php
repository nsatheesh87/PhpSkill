<?php

abstract class abstractFlickr 
{
	protected $endpoint = 'https://api.flickr.com/services/rest/?';

	protected $pageLimit = 5;
 
	protected $params = array(
							"api_key"=>"e23355c7e231f3d5919b2c06abbc0862",
							 "method"=>"flickr.photos.getRecent",
							 "format" => "json"
							);



	public function getEndPoint() {
		return $this->endpoint;
	}

	public function getConfigParams() {
		return $this->params;
	}

	protected function buildUrl($keywords = '', $page) {
		$url  = $this->getEndPoint();
		$postParams  = array('tags' => $keywords, 'per_page' => $this->pageLimit,
		 'page' => $page, 'content_type' => 1);

		//$postParams = array();
		$params = array_merge($this->getConfigParams(), $postParams);
		$encoded_params = array();
		foreach ($params as $k => $v){
			$encoded_params[] = urlencode($k).'='.urlencode($v);
		}
		$url = $url.implode('&', $encoded_params);
		return $url;
	}

	public function fetch($keywords, $page) {
		$url = $this->buildUrl($keywords, $page);
		//echo $url; exit;
		return file_get_contents($url);
    }
}