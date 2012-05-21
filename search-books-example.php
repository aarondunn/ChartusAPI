<?php
header('Content-Type: text/html; charset=UTF-8');
require_once(dirname(__FILE__) . '/chartus/api/Api.php');

$login = '<CHARTUS_LOGIN>';
$password = '<CHARTUS_PASSWORD>';
$api = new \chartus\api\Api($login, $password);
try {
	$api->authenticate();
    $searchRequest = 'test';

    $resultsCount = $api->call(\chartus\api\ApiInterface::ACTION_SEARCH_BOOKS_COUNT,
        array(
            'search_request'=>$searchRequest
      )
    );

    $results = $api->call(\chartus\api\ApiInterface::ACTION_SEARCH_BOOKS,
        array(
            'limit'=>5,
            'offset'=>0,
            'search_request'=>$searchRequest
        )
    );

    echo 'Total Found: '. $resultsCount;

	echo '<br/>Search Results:<br/><pre>';
	print_r($results);
	echo '</pre>';
	
} catch(\chartus\api\ApiException $ex) {
	echo 'An error occurred: ', $ex->getMessage();
}