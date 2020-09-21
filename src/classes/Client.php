<?php

namespace Frankwatching\ActOn;

ini_set( 'error_reporting', E_ALL );

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

	private static $base_path = '/api/1';

	public function __construct( $client_id, $client_secret, $username, $password, $base_path = null ) {
		$this->client_id     = $client_id;
		$this->client_secret = $client_secret;
		$this->username      = $username;
		$this->password      = $password;

		if ( null !== $base_path ) {
			self::$base_path = $base_path;
		}

		self::$client = new \GuzzleHttp\Client( [
			'base_uri' => 'https://restapi.actonsoftware.com'
		] );
	}

	public function setClient( $access_token ) {
		self::$access_token = $access_token;

		self::$headers = [
			'Authorization' => 'Bearer ' . $access_token,
			'Content-Type'  => 'application/json'
		];

		if ( null === self::$client ) {
			self::$client = new \GuzzleHttp\Client( [
				'base_uri' => 'https://restapi.actonsoftware.com',
			] );
		}
	}

	public static function getClientToken() {
		return self::$access_token;
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

		$request = self::$client->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $request->getBody()->getContents() );

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

		$request = self::$client->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $request->getBody()->getContents() );

		return $tokens;
	}

	/**
	 * @param $endpoint
	 * @param $body
	 *
	 * @return mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public static function post( $endpoint, $body, $headers = [], $multipart = false ) {
		$options = [
			'headers' => array_merge( self::$headers, $headers ),
		];

		if ( $multipart ) {
			$options['multipart'] = $body;
		} else {
			$options['json'] = $body;
		}

//		var_dump( $options );
//		exit;

//		var_dump( $body );
//		exit;

//		var_dump( $options );
//		exit;

//		var_dump( $options );
//		exit;

		try {
			$request = self::$client->request( 'POST', self::$base_path . $endpoint, $options );

			return json_decode( $request->getBody()->getContents(), true );
		} catch ( RequestException $e ) {
			return json_decode( $e->getResponse()->getBody() );
		}
	}

	/**
	 * @param $endpoint
	 *
	 * @return mixed
	 */
	public static function get( $endpoint ) {

		$options = [
			'headers' => self::$headers,
		];

		try {
			$request = self::$client->request( 'GET', self::$base_path . $endpoint, $options );
		} catch ( BadResponseException $e ) {
			return json_decode( $e->getResponse()->getBody() );
		}

		return json_decode( $request->getBody()->getContents(), true );
	}

	/**
	 * @param $endpoint
	 * @param $body
	 *
	 * @return mixed
	 */
	public static function put( $endpoint, $body, $headers = [] ) {

		$options = [
			'headers' => array_merge( self::$headers, $headers ),
			'json'    => $body,
		];

		try {
			$request = self::$client->request( 'PUT', self::$base_path . $endpoint, $options );
		} catch ( BadResponseException $e ) {
			throw new Exception( $e->getCode() );
		}

		return json_decode( $request->getBody()->getContents() );
	}

	public static function getClient() {
		return self::$client;
	}
}