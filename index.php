<?php
header('Content-Type: text/plain; charset=UTF-8');
require_once(dirname(__FILE__) . '/chartus/api/Api.php');

$login = '<CHARTUS_LOGIN>';
$password = '<CHARTUS_PASSWORD>';
$api = new \chartus\api\Api($login, $password);
try {
	$api->authenticate();
	$response = $api->call(\chartus\api\ApiInterface::ACTION_TEST, array(
		'name'=>'Jimmy',
		'surname'=>'Winter',
		'nickname'=>'jinteR',
	));
	echo $response['Hello from ChartusApi'];
} catch(\chartus\api\ApiException $ex) {
	echo 'An error occured: ', $ex->getMessage();
}