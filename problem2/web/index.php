<?php
use \Guzzle\Http\Client as Gclient;
// web/index.php
date_default_timezone_set('UTC');
require_once '../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->get('/', function() use($app) {
    return 'Try /hello/:name';
});

$app->get('/hello/{name}', function($name) use($app) {
    return 'Hello ' . $app->escape($name);
});

$app->get('/histogram/{username}', function($username) use($app) {

/* 	$twitter_client = new Gclient('https://api.twitter.com/{version}', array(
        'version' => '1.1'
    )); */

    $twitter_client = new Gclient('https://api.twitter.com/{version}', array(
        'version' => '1.1'
    ));


    $twitter_client->addSubscriber(new \Guzzle\Plugin\Oauth\OauthPlugin(array(
        'consumer_key'  => 'eOkqyFnzENaOwZvOW4UYvBAAc',
        'consumer_secret' => '8hqtSlFsEZDKMmYfV2HZqw3pYkDBDLZQdXelJFnLv9dCrhpyfR',
        'token'       => '21214801-5njAdReR2YEpVWR2HFxg2WUobgAlvBKrMsEvpxLAK',
        'token_secret'  => 'fxHZkrMseHzmpiTvoluHgsC5EeKlmMRLqz4F4J9y70gFg'
    )));

    $request = $twitter_client->get('statuses/user_timeline.json');
    $request->getQuery()->set('screen_name', $app->escape($username));


    try {
	    $response = $request->send();
	    
	    $tweets = json_decode($response->getBody());

		$format = array();
		$i =0;
		foreach($tweets as $tweet) {
			$format[date("Y-m-d", strtotime($tweet->created_at))][$i] = date("H", strtotime($tweet->created_at));
			$i++;
		}
	    
	    // Release the twitter response from memory
		unset($tweets);
		$finalResponse = array();
		foreach($format as $formatted => $fCount) {
			$counted = array_count_values($fCount);
			foreach($counted as $hour => $hourlyTweets) {
				$maxHour = $hour+1;
				$hourlyRange = $hour.":00-".$maxHour.":00";
				$finalResponse[$formatted][$hourlyRange] = $hourlyTweets;
			}
		}
		return $app->json($finalResponse);
		} catch (ClientErrorResponseException $exception) {
		    $responseBody = $exception->getResponse()->getBody(true);
		    return $app->json($responseBody);
		}

	//var_dump($format);
		//return $app->escape($username);

});

$app->run();