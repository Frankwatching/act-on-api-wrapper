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

	public $client;
	public $guzzle;

	public function init( $client_id, $client_secret ) {

		$this->client_id     = $client_id;
		$this->client_secret = $client_secret;
//		$this->username      = $username;
//		$this->password      = $password;

		$this->contact = new \Frankwatching\ActOn\Contact();
		$this->client = new \Frankwatching\ActOn\Client();

		$this->guzzle = new GuzzleClient( [
			'base_uri' => 'https://restapi.actonsoftware.com'
		] );
	}

	public function getClient() {
		return $this->guzzle;
	}
}