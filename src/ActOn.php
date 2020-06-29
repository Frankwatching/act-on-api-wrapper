<?php

namespace Frankwatching\ActOn;

use GuzzleHttp\Client;
use Frankwatching\ActOn\Client as ActOnClient;
use Frankwatching\ActOn\Contact;

class ActOn {

	protected $client_id = '';
	protected $client_secret = '';
	protected $username;
	protected $password;
	protected $guzzle;
	protected $contact;

	protected static $client;

	public function init( $client_id, $client_secret ) {

		$this->client_id     = $client_id;
		$this->client_secret = $client_secret;
//		$this->username      = $username;
//		$this->password      = $password;

		$this->contact = new \Frankwatching\ActOn\Contact();

		self::$client = new Client( [
			'base_uri' => 'https://restapi.actonsoftware.com'
		] );
	}
}