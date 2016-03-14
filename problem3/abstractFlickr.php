<?php
/**
* Flickr Abstract class
* 
* This is the parent abstract class for Flickr class 
* 
* @author Satheesh Narayanan <nsatheesh87@gmail.com>
*
**/
abstract class abstractFlickr 
{
	/**
	* Declare the flickr endpoint
	*
	* @var string
	*
	**/
	protected $endpoint = 'https://api.flickr.com/services/rest/?';

	/**
	* Set the page limit value
	*
	* @var integer
	*
	**/
	protected $pageLimit = 5;
 
	/**
	* Default configuration parameter values
	*
	* @var array
	*
	**/
	protected $params = array(
							"api_key"=>"e23355c7e231f3d5919b2c06abbc0862",
							 "method"=>"flickr.photos.getRecent",
							 "format" => "json"
							);

	/**
	* Fetch the filck end point from endpoint variable
	*
	* @return string
	*
	**/
	public function getEndPoint() {
		return $this->endpoint;
	}

	/**
	* Fetch all the default paramerts from $param array
	*
	* @return array
	*
	**/
	public function getConfigParams() {
		return $this->params;
	}

	/**
	* Build the flickr URL from endpoint value and configuration values
	*
	* @param $keywords
	* @param @page
	*
	* @return string
	*
	**/
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

	/**
	* Fetch the flickr response using built URL
	*
	* @param $keywords
	* @param @page
	*
	* @return JSON Response
	*
	**/
	public function fetch($keywords, $page) {
		$url = $this->buildUrl($keywords, $page);
		//echo $url; exit;
		return file_get_contents($url);
    }
}