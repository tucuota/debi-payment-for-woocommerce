<?php
/**
 * The API client class for Debi payment gateway.
 *
 * @package    WooCommerce_Debi
 * @author     Fernando del Peral <support@debi.pro>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Custom exception class for Debi API errors
 *
 * @package    WooCommerce_Debi
 */
class debiException extends \Exception {

}

/**
 * Debi API Client Class
 *
 * Handles API communication with the Debi payment gateway.
 *
 * @package    WooCommerce_Debi
 */
class debi {
	/**
	 * API token for authentication
	 *
	 * @var string
	 */
	protected $token;
	
	/**
	 * Whether to use sandbox environment
	 *
	 * @var bool
	 */
	protected $sandbox;
	
	/**
	 * API version
	 *
	 * @var string
	 */
	protected $version;
	
	/**
	 * HTTP client (not currently used, using wp_remote_request instead)
	 *
	 * @var mixed
	 */
	protected $client;

	/**
	 * Constructor
	 *
	 * @param string $token   API token
	 * @param bool   $sandbox Whether to use sandbox
	 * @param string $version API version
	 */
	public function __construct($token, $sandbox = true, $version = 'v1') {
		$this->token = $token;
		$this->sandbox = $sandbox;
		$this->version = $version;
	}

	/**
	 * Make a request to the Debi API
	 *
	 * @param string $uri  API endpoint
	 * @param array  $data Request data including method and body
	 * @return array Decoded JSON response
	 * @throws debiException If the request fails
	 **/
	public function request($uri, $data = []) {
		try {
			// Construir URL completa
			$base_url = $this->sandbox ? 'https://api.debi-test.pro/v1/' : 'https://api.debi.pro/v1/';
			$url = $base_url . $uri;
			
			// Preparar headers
			$headers = [
				"Authorization" => "Bearer $this->token",
				"Api-Version" => "$this->version",
				'Content-Type' => 'application/json',
			];
			
			// Preparar el array de args para wp_remote_request
			$args = [
				'method' => $data['method'] ?? 'GET',
				'headers' => $headers,
				'body' => isset($data['body']) ? json_encode($data['body']) : '',
				'timeout' => 30,
			];
			
			// Hacer el request
			$response = wp_remote_request($url, $args);
			
			// Check if the request was successful
			if (is_wp_error($response)) {
				throw new debiException($response->get_error_message(), 0);
			}
			
			// Get response code
			$response_code = wp_remote_retrieve_response_code($response);
			
			// Check if response code indicates success (200-299)
			if ($response_code < 200 || $response_code >= 300) {
				$error_message = wp_remote_retrieve_response_message($response);
				$body = wp_remote_retrieve_body($response);
				throw new debiException($error_message . ' - ' . $body, $response_code);
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