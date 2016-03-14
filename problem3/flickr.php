<?php
require_once('abstractFlickr.php');
class flickr extends abstractFlickr
{
	protected $response;

	public function getResponse($keywords = 'butterfly', $currentPage = 1) {

		$reponseData = $this->fetch($keywords, $currentPage);
		$data = str_replace( 'jsonFlickrApi(', '', $reponseData );
		$data = substr( $data, 0, strlen( $data ) - 1 ); //strip out last paren

		return json_decode( $data );
		//return json_decode($reponseData);

	}

}
