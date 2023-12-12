<?php

namespace Frankwatching\ActOn;

use Exception;

use Frankwatching\ActOn\Client;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;

class Lists {
	private static $lists = null;

	public static function createList( $listname, $uploadspecs = [], $quotecharacter = 'SINGLE_QUOTE', $foldername = '', $headings = 'Y', $fieldseperator = 'COMMA' ) {
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api-eu.actonsoftware.com/api/1/list",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => [
				'listname' => $listname,
				'quotecharacter' => 'SINGLE_QUOTE',
				'uploadspecs' => json_encode( $uploadspecs )
			],
			CURLOPT_HTTPHEADER => [
				'Authorization: Bearer ' . \Frankwatching\ActOn\Client::getClientToken()
			],
		));

		$response = curl_exec($curl);

		curl_close($curl);

		return $response;
	}

	public static function getListsOfAssets() {

		if ( null === self::$lists ) {
			try {

				self::$lists = Client::get( '/list?listingtype=CONTACT_LIST' );
			} catch ( Exception $e ) {
				return [];
			}
		}

		if ( ! is_array( self::$lists ) ) {
			return false;
		}

		return self::$lists['result'];
	}

	public static function getListByName( $name ) {
		$lists = self::getListsOfAssets();

		$lists = array_filter( $lists, function ( $list ) use ( $name ) {
			return $list['name'] === $name;
		} );

		if ( ! empty( $lists ) ) {
			$lists = reset( $lists );

			return $lists;
		}

		return false;
	}

	public static function download( $listId ) {
		try {
			$list = Client::get( "/list/$listId" );
		} catch ( Exception $e ) {
			return [];
		}

		if ( ! is_array( $list ) ) {
			return false;
		}

		return $list;
	}
}