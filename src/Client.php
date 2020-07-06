<?php

namespace Frankwatching\ActOn;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Frankwatching\ActOn\ActOn;

class Client extends ActOn {
	public function __construct( $client_id, $client_secret, $username, $password ) {
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->username = $username;
		$this->password = $password;
	}

	public function fetchTokens() {

		$body = [
			'grant_type'    => 'password',
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'username'      => $this->username,
			'password'      => $this->password,
		];

		$response = $this->getClient()->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $response->getBody()->getContents() );

		$this->setClientHeaders( 'Authorization', 'Bearer: ' . $tokens->access_token );

		return $tokens;
	}

	public function refreshTokens( $refreshToken ) {
		$body = [
			'grant_type'    => 'refresh_token',
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'refresh_token' => $refreshToken,
		];

		$response = $this->getClient()->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $response->getBody()->getContents() );

		$this->setClientHeaders( 'Authorization', 'Bearer: ' . $tokens->access_token );

		return $tokens;
	}

	public function post( $endpoint, $body ) {
		try {
			$response = $this->getClient()->request( 'POST', $endpoint, [
				'form_params' => $body
			], [
				'headers' => $this->getClientHeaders()
			] );
		} catch ( RequestException $e ) {
			var_dump( $e );
		}

		return json_decode( $response->getBody()->getContents() );
	}

	public function get( $endpoint ) {
		try {
			$response = $this->getClient()->get( $endpoint );
		} catch ( RequestException $e ) {
			var_dump( $e );
		}

		return json_decode( $response->getBody()->getContents() );
	}

	public function put( $endpoint, $body ) {
		try {
			$response = $this->getClient()->put( $endpoint, [
				'body' => $body
			] );
		} catch ( RequestException $e ) {
			var_dump( $e );
		}

		return json_decode( $response->getBody()->getContents() );
	}
}