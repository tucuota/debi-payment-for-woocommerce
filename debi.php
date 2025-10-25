<?php

// use GuzzleHttp\Client;
// use GuzzleHttp\Exception\RequestException;

class debiException extends \Exception {

}

/**
 * debi
 *
 * @package default
 * @author
 **/
class debi {
	protected $token;
	protected $sandbox;
	protected $version;
	protected $client;

	public function __construct($token, $sandbox = true, $version = 'v1') {
		$this->token = $token;
		$this->sandbox = $sandbox;
		$this->version = $version;

		// dd($request);
		$this->client = new WP_Http([
			'headers' => [
				"Authorization" => "Bearer $this->token",
				"Api-Version" => "$this->version",
				//'Content-Type' => 'application/json',
				//'Accept' => 'application/json',
			],
			'base_uri' => $this->sandbox ? 'https://debi-test.pro/' : 'https://api.debi.pro/',
		]);
	}

	/**
	 * request
	 *
	 * @return array
	 * @author
	 **/
	public function request($uri, $data = []) {

		try {
			$response = $this->client->request($uri, $data);
			// 	$uri,
			// 	$data,
			// 	[
			// 		'form_params' => $data,
			// 	]
			// )

			$response = json_decode($response->getBody(), true);

			// $this->request = $response->getRequest();

			// $this->errors = ;

			// dd($response);
			return $response;

		} catch (RequestException $e) {

			// $this->response = $response->getStatusCode();
			$this->status = $e->getResponse()->getStatusCode();

			$this->response = json_decode($e->getResponse()->getBody()->getContents(), true);
			// return ;

			throw new debiException($e->getMessage(), $this->status);

		}

	}

}