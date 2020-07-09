<?php

namespace Frankwatching\ActOn;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\BadResponseException;

use Exception;

use Frankwatching\ActOn;

class Client {

	protected static $client;

	static $lists;
	private static $access_token;
	static $headers = [];

	public function __construct( $client_id, $client_secret, $username, $password ) {
		$this->client_id     = $client_id;
		$this->client_secret = $client_secret;
		$this->username      = $username;
		$this->password      = $password;

		self::$client = new \GuzzleHttp\Client( [
			'base_uri' => 'https://restapi.actonsoftware.com/api/1',
		] );
	}

	public function setClient( $access_token ) {
		self::$access_token = $access_token;

		self::$headers = [
			'Authorization' => 'Bearer ' . $access_token,
			'Content-Type' => 'application/json'
		];

		if ( null === self::$client ) {
			self::$client = new \GuzzleHttp\Client( [
				'base_uri' => 'https://restapi.actonsoftware.com/api/1',
			] );
		}
	}


	/**
	 * @return mixed
	 */
	public function fetchTokens() {

		$body = [
			'grant_type'    => 'password',
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'username'      => $this->username,
			'password'      => $this->password,
		];

		$response = self::$client->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $response->getBody()->getContents() );

		return $tokens;
	}

	/**
	 * @param $refreshToken
	 *
	 * @return mixed
	 */
	public function refreshTokens( $refreshToken ) {
		$body = [
			'grant_type'    => 'refresh_token',
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'refresh_token' => $refreshToken,
		];

		$response = self::$client->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $response->getBody()->getContents() );

		return $tokens;
	}

	/**
	 * @param $endpoint
	 * @param $body
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public static function post( $endpoint, $body, $headers = [] ) {

		$data = [
			'form_params' => $body,
			'headers' => array_merge( self::$headers, $headers ),
			'debug' => true
		];

		try {

			$response = self::$client->request( 'POST', $endpoint, $data );

			return json_decode( $response->getBody()->getContents() );
		} catch ( BadResponseException $e ) {
			var_dump( $e->getResponse()->getBody()->getContents() );

			throw new Exception( $e->getResponse()->getBody()->getContents() );
		}
	}

	/**
	 * @param $endpoint
	 *
	 * @return mixed
	 */
	public static function get( $endpoint ) {
		try {
			$response = self::$client->request( 'GET', $endpoint );
		} catch ( RequestException $e ) {
			var_dump( $e );
		}

		return json_decode( $response->getBody()->getContents() );
	}

	/**
	 * @param $endpoint
	 * @param $body
	 *
	 * @return mixed
	 */
	public static function put( $endpoint, $body ) {
		try {
			$response = self::$client->request( 'PUT', $endpoint, [
				'body' => $body
			] );
		} catch ( RequestException $e ) {
			var_dump( $e );
		}

		return json_decode( $response->getBody()->getContents() );
	}
}