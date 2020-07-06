<?php

namespace Frankwatching\ActOn;

use GuzzleHttp\Client as GuzzleClient;
use Frankwatching\ActOn\Client;
use Frankwatching\ActOn\Contact;

class ActOn {

	protected $client_id = '';
	protected $client_secret = '';
	protected $username;
	protected $password;
	protected $contact;
	protected $headers = [];

	public $client;
	public $guzzle;

	public function init( $client_id, $client_secret, $acton_username, $acton_password ) {

		$this->client_id     = $client_id;
		$this->client_secret = $client_secret;

		$this->client  = new \Frankwatching\ActOn\Client( $client_id, $client_secret, $acton_username, $acton_password );
		$this->contact = new \Frankwatching\ActOn\Contact();
//
//		$this->guzzle = new GuzzleClient( [
//			'base_uri' => 'https://restapi.actonsoftware.com'
//		] );
	}

	public function getClient() {

		if ( null === $this->guzzle ) {
			$this->guzzle = new GuzzleClient( [
				'base_uri' => 'https://restapi.actonsoftware.com'
			] );
		}

		return $this->guzzle;
	}

	public function setClientHeaders( $header, $value ) {
		$this->headers[ $header ] = $value;
	}

	public function getClientHeaders() {
		return $this->headers;
	}
}