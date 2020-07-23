<?php

namespace Frankwatching\ActOn;

use Exception;

use Frankwatching\ActOn\Client;

class Lists {
	public static function createList( $listname, $uploadspecs = [], $quotecharacter = 'NONE', $foldername = '', $headings = 'Y', $fieldseperator = 'COMMA' ) {
		try {
			$data = [
				[
					'name' => 'listname',
					'contents' => $listname,
				],
				[
					'name' => 'uploadspecs',
					'contents' => json_encode( $uploadspecs ),
				],
				[
					'name' => 'quotecharacter',
					'contents' => $quotecharacter,
				],
				[
					'name' => 'headings',
					'contents' => $headings,
				],
				[
					'name' => 'fieldseperator',
					'contents' => $fieldseperator
				]
//				'listname'       => $listname,
//				'uploadspecs'    => json_encode( $uploadspecs ),
//				'quotecharacter' => $quotecharacter,
//				'foldername'     => $foldername,
//				'headings'       => $headings,
//				'fieldseperator' => $fieldseperator,
			];

			$response = Client::post( '/list', $data, [
				'Content-Type' => 'multipart/form-data'
			], true );

			return $response;
		} catch ( Exception $e ) {
			return false;
		}
	}

	public static function getListsOfAssets() {
		try {
			$response = Client::get( '/list?listingtype=CONTACT_LIST' );

			return $response;
		} catch( Exception $e ) {
			return false;
		}
	}
}