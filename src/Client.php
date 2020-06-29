<?php

namespace Frankwatching\ActOn;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Client extends ActOn {
	public function fetchTokens( $username, $password) {
		$body = [
			'grant_type'    => 'password',
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'username'      => $username,
			'password'      => $password,
		];

		$response = $this->getClient()->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $response->getBody()->getContents() );

		return $tokens;
	}

	public function refreshTokens( $refreshToken ) {
		$body = [
			'grant_type'    => 'refresh_token',
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'refresh_token' => $refreshToken,
		];

		$response = $this->guzzle->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $response->getBody()->getContents() );

		return $tokens;
	}

	public function post( $endpoint, $body ) {
		try {
			$response = $this->guzzle->post( $endpoint, [
				'form_params' => $body
			] );
		} catch ( RequestException $e ) {
			var_dump( $e );
		}

		return json_decode( $response->getBody()->getContents() );
	}

	public function get( $endpoint ) {
		try {
			$response = $this->guzzle->get( $endpoint );
		} catch ( RequestException $e ) {
			var_dump( $e );
		}

		return json_decode( $response->getBody()->getContents() );
	}

	public function put( $endpoint, $body ) {
		try {
			$response = $this->guzzle->put( $endpoint, [
				'body' => $body
			] );
		} catch ( RequestException $e ) {
			var_dump( $e );
		}

		return json_decode( $response->getBody()->getContents() );
	}
}