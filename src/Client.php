<?php

namespace Frankwatching\ActOn;

use GuzzleHttp\Client as GuzzleClient;

class Client extends ActOn {
	public function __construct( $client_id, $client_secret, $username, $password ) {
		parent::__construct( $client_id, $client_secret, $username, $password );
	}

	public function fetchTokens( $username, $password) {

		$client = new GuzzleClient();

		$body = [
			'grant_type'    => 'password',
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'username'      => $username,
			'password'      => $password,
		];

		$response = $client->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $response->getBody()->getContents() );

		return $tokens;
	}

	public function refreshTokens( $refreshToken ) {

		$client = new GuzzleClient();

		$body = [
			'grant_type'    => 'refresh_token',
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'refresh_token' => $refreshToken,
		];

		$response = $client->post( '/token', [
			'form_params' => $body
		] );

		$tokens = json_decode( $response->getBody()->getContents() );

		return $tokens;
	}

	public function post( $endpoint, $body ) {
		$response = $this->client->post( $endpoint, [
			'form_params' => $body
		] );

		return json_decode( $response->getBody()->getContents() );
	}

	public function get( $endpoint ) {
		$response = $this->client->get( $endpoint );

		return json_decode( $response->getBody()->getContents() );
	}

	public function put( $endpoint, $body ) {
		$response = $this->client->put( $endpoint, [
			'body' => $body
		] );

		return json_decode( $response->getBody()->getContents() );
	}
}