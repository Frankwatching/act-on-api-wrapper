<?php

namespace Frankwatching\ActOn;

class Client extends ActOn {
	public function __construct( $client_id, $client_secret, $username, $password ) {
		parent::__construct( $client_id, $client_secret, $username, $password );
	}

	protected static function get() {

	}

	public function fetchTokens() {

		$body = [
			'grant_type'    => 'password',
			'client_id'     => $this->client_id,
			'client_secret' => $this->client_secret,
			'username'      => $this->username,
			'password'      => $this->password,
		];

		$response = $this->guzzle->post( '/token', [
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
}