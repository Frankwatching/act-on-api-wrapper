<?php

namespace Frankwatching\ActOn;

use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;

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

	public static function send(
		$template_id,
		$to_address,
		$transactional = true,
		$personalization = [],
		$from_address = '',
		$from_display_name = '',
		$cc_address_list = [],
		$reply_to_address = '',
		$tag_list = [],
		$external_id = 0,
		$track_opens = true,
		$track_clicks = true,
		$delivery_when_delayed = false
	) {

		$json = [
			'envelope' => [
				'toAddress'       => $to_address,
				'fromAddress'     => $from_address,
				'fromDisplayName' => $from_display_name,
				'replyToAddress'  => $reply_to_address,
			],
			'content'  => [
				'personalizationDataMap' => $personalization
			],
			'metadata' => [
				'transactional' => $transactional
			],
			'actions'  => []
		];

		if ( ! empty( $cc_address_list ) ) {
			$json['envelope']['ccAddressList'] = $cc_address_list;
		}

		if ( ! empty( $from_address ) ) {
			$json['envelope']['fromAddress'] = $from_address;
		}

		if ( ! empty( $cc_address_list ) ) {
			$json['envelope']['fromDisplayName'] = $from_display_name;
		}

		if ( ! empty( $cc_address_list ) ) {
			$json['envelope']['replyToAddress'] = $reply_to_address;
		}

		if ( ! empty( $tag_list ) ) {
			$json['metadata']['tagList'] = $tag_list;
		}

		if ( ! empty( $external_id ) ) {
			$json['metadata']['externalId'] = $external_id;
		}

		if ( $track_opens ) {
			$json['actions']['trackOpens'] = $track_opens;
		}

		if ( $track_clicks ) {
			$json['actions']['trackClicks'] = $track_clicks;
		}

		if ( $delivery_when_delayed ) {
			$json['actions']['deliveryWhenDelayed'] = $delivery_when_delayed;
		}

		try {
			$request = self::$client->post( '/ete/v1/email/' . self::$account_id . '/' . $template_id, [
				'headers' => self::$headers,
				'json'    => $json
			] );

			return json_decode( $request->getBody()->getContents(), true );
		}
		catch ( ServerException $e ) {
			return json_decode( $e->getResponse()->getBody() );
		}
		catch ( ClientException $e ) {
			return json_decode( $e->getResponse()->getBody() );
		}
	}


	public static function setClient( $access_token ) {
		self::$headers = [
			'Authorization' => 'Bearer ' . self::$access_token,
			'Content-Type'  => 'application/json',
			'debug'         => true
		];

		if ( null === self::$client ) {
			self::$client = new \GuzzleHttp\Client( [
				'base_uri' => 'https://api-eu.actonsoftware.com',
			] );
		}
	}
}