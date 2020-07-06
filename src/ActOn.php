<?php

namespace Frankwatching\ActOn;

use GuzzleHttp\Client as GuzzleClient;

class ActOn {

	protected $client_id = '';
	protected $client_secret = '';
	protected $username;
	protected $password;
	protected $contact;
	protected $headers = [];
	protected $access_token;

	public $client;
	public $lists;
	public $guzzle;

	public function init( $client_id, $client_secret, $username, $password ) {

		$this->client_id     = $client_id;
		$this->client_secret = $client_secret;

		$this->client  = new Client( $client_id, $client_secret, $username, $password );
		$this->contact = new Contact();
		$this->lists = new Lists();
	}

	public function getClient() {

		if ( null === $this->guzzle ) {
			$this->guzzle = new GuzzleClient( [
				'base_uri' => 'https://restapi.actonsoftware.com/api'
			] );
		}

		return $this->guzzle;
	}

	public function setAccessToken( $access_token ) {
		$this->access_token = $access_token;

		$this->setClientHeaders( 'Authorization', 'Bearer: ' . $access_token );
	}

	public function setClientHeaders( $header, $value ) {
		$this->headers[ $header ] = $value;
	}

	public function getClientHeaders() {
		return $this->headers;
	}
}