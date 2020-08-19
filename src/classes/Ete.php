<?php

namespace Frankwatching\ActOn;

use GuzzleHttp\Exception\ServerException;

class Ete {
	public static $client = null;
	public static $headers;
	public static $access_token;
	public static $account_id;

	public function __construct( $access_token, $account_id ) {
		self::$access_token = $access_token;
		self::$account_id   = $account_id;

		self::setClient( $access_token );
	}

	public static function send() {

//		var_dump( Account::get() );

		var_dump( '/ete/v1/email/' . self::$account_id . '/t-0003' );
		exit;

//		try {
			$result = self::$client->request( 'POST', '/ete/v1/email/' . self::$account_id . '/t-0003', [
				'headers' => self::$headers,
				'json'    => [
					'EmailDetails' => [
						'envelope' => [
							'toAddress'       => 'danny@frankwatching.com',
							'ccAddressList'   => [],
							'fromAddress'     => 'dx@frankwatching.com',
							'fromDisplayName' => 'Frankwatching',
							'replyToAddress'  => 'noreply@frankwatching.com'
						],
						'content'  => [
							'personalizationDataMap' => [
								'Account.COMPANY'     => 'Frankwatching',
								'Account.BIZ_ADDRESS' => 'Test',
								'Voornaam'            => 'Danny'
							],
						],
						'metadata' => [
							'transactional' => true,
							'tagList'       => [],
							'externalId'    => '123213jlcdajlfcjdks'
						],
						'actions'  => [
							'trackOpens'          => true,
							'trackClicks'         => true,
							'deliveryWhenDelayed' => 'FALSE'
						]
					]
				]
			] );

			var_dump( $result->getHeaders() );
			exit;

			var_dump( $result );
			exit;
//		}
//		catch ( ServerException $e ) {
//			var_dump( $e );
//			exit;
//		}
	}


	public static function setClient( $access_token ) {
		self::$headers = [
			'Authorization' => 'Bearer ' . self::$access_token,
			'Content-Type'  => 'application/json'
		];

		if ( null === self::$client ) {
			self::$client = new \GuzzleHttp\Client( [
				'base_uri' => 'https://restapi.actonsoftware.com',
			] );
		}
	}
}