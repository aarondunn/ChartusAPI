<?php
namespace chartus\api;

require_once(dirname(__FILE__) . '/ApiException.php');
require_once(dirname(__FILE__) . '/ApiInterface.php');
/**
 * Api - Chartus API Client example.
 *
 * @author f0t0n
 */
class Api {
	
	const API_URL = 'https://chartus.org/api';
	const POST_AUTH_TOKEN_KEY = 'auth_token';
	const POST_ACTION_KEY = 'action';
	const AUTH_TOKEN_RESPONSE_KEY = 'auth_token';
	const CURL_ERROR = 'CURL error.';
	const API_CONNECTION_TIMEOUT = 5;
	const API_CALL_TIMEOUT = 30;
	
	/** @var string */
	protected $login;
	/** @var string */
	protected $password;
	/** @var string */
	protected $authToken;
	/** @var array */
	protected $curlOptions;
	/** @var array */
	protected $lastError;
	/** @var array */
	protected $lastResponse;
	
	public function __construct($login, $password) {
		$this->login = $login;
		$this->password = $password;
		$this->errors = array();
		$this->initCurlOptions();
	}
	
	/**
	 * Authenticates the user
	 * and initializing the $authToken property on success.
	 * @return boolean True if the authentication was successful,
	 * false otherwise.
	 */
	public function authenticate() {
		$response = $this->call(
			\chartus\api\ApiInterface::METHOD_AUTHENTICATE,
			array(
				'login'=>$this->login,
				'password'=>$this->password,
			)
		);
		if($response === false) {
			return false;
		}
		$this->authToken = $response[self::AUTH_TOKEN_RESPONSE_KEY];
		return true;
	}
	
	/**
	 * Call any API action using this method.
	 * Note: you need to perform a successful authentication before.
	 * @see Api::authenticate method.
	 * @param string $action
	 * @param array $params 
	 * @throws chartus\api\ApiException If the API answered with error message.
	 */
	public function call($action, array $params = array()) {
		$response = $this->curlCall($this->generatePostData($action, $params));
		if($response === false) {
			throw new \chartus\api\ApiException(self::CURL_ERROR);
		}
		$response = json_decode($response, true);
		$this->checkApiResponse($response);
		return $this->lastResponse = $response;
	}
	
	/**
	 *
	 * @return string Last curl error message.
	 */
	public function getLastError() {
		return $this->lastError;
	}
	
	/**
	 *
	 * @return array last response after the API request via curl.
	 */
	public function getLastResponse() {
		return $this->lastResponse;
	}
	
	protected function generatePostData($action, array $params = array()) {
		$postData = array_merge($params, array(
			self::POST_ACTION_KEY => $action,
			self::POST_AUTH_TOKEN_KEY => $this->authToken,
		));
		$postDataArgs = array();
		foreach($postData as $k => $v) {
			$postDataArgs[] = $k . '=' . $v;
		}
		return implode('&', $postDataArgs);
	}
	
	/**
	 * @param array $response The decoded JSON-response as array.
	 * @return boolean True if the data retrieved successfully.
	 * @throws chartus\api\ApiException If the API answered with error message.
	 */
	protected function checkApiResponse($response) {
		if(!empty($response['Error'])) {
			throw new \chartus\api\ApiException($response['Message']);
		}
		return true;
	}
	
	protected function initCurlOptions() {
		$this->curlOptions = array(
			CURLOPT_URL => self::API_URL,
			CURLOPT_TIMEOUT => self::API_CALL_TIMEOUT,
			CURLOPT_CONNECTTIMEOUT => self::API_CONNECTION_TIMEOUT,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
		);
	}
	
	protected function curlCall($params) {
		$ch = curl_init();
		curl_setopt_array($ch, $this->curlOptions);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		$result = curl_exec($ch);
		if($result === false) {
			$this->lastError = array(
				'errno' => curl_errno($ch),
				'error' => curl_error($ch),
				'time' => microtime(true),
			);
		}
		curl_close($ch);
		return $result;
	}
}