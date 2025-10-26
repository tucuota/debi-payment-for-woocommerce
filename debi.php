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
				'Content-Type' => 'application/json',
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
			
			// Check if the request was successful
			if (is_wp_error($response)) {
				throw new debiException($response->get_error_message(), 0);
			}
			
			// Get response code
			$response_code = wp_remote_retrieve_response_code($response);
			
			// Check if response code indicates success (200-299)
			if ($response_code < 200 || $response_code >= 300) {
				$error_message = wp_remote_retrieve_response_message($response);
				throw new debiException($error_message, $response_code);
			}
			
			// Get response body
			$response_body = wp_remote_retrieve_body($response);
			
			// Decode JSON response
			$decoded_response = json_decode($response_body, true);
			
			// Check if JSON decoding was successful
			if (json_last_error() !== JSON_ERROR_NONE) {
				throw new debiException('Invalid JSON response from API', $response_code);
			}
			
			return $decoded_response;

		} catch (debiException $e) {
			// Re-throw our custom exceptions
			throw $e;
		} catch (Exception $e) {
			// Handle any other exceptions
			throw new debiException($e->getMessage(), 0);
		}

	}

}