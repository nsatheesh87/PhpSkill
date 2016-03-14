<?php
require_once('abstractFlickr.php');
/**
* Flickr Abstract class
* 
* This is the parent abstract class for Flickr class 
* 
* @author Satheesh Narayanan <nsatheesh87@gmail.com>
*
**/
class flickr extends abstractFlickr
{

	/**
	* Call the abstract class method to fetch the json 
	*
	* @param $keywords
	* @param @page
	*
	* @return string
	*
	**/
	public function getResponse($keywords = 'butterfly', $currentPage = 1) {

		$reponseData = $this->fetch($keywords, $currentPage);
		$data = str_replace( 'jsonFlickrApi(', '', $reponseData );
		$data = substr( $data, 0, strlen( $data ) - 1 ); //strip out last paren

		return json_decode( $data );
		//return json_decode($reponseData);

	}

}
