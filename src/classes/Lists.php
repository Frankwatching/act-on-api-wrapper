<?php

namespace Frankwatching\ActOn;

use Exception;

use Frankwatching\ActOn\Client;

class Lists {
	private static $lists = null;

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

		if ( null === self::$lists ) {
			try {

				self::$lists = Client::get( '/list?listingtype=CONTACT_LIST' );
			} catch( Exception $e ) {
				return [];
			}
		}

		return self::$lists['result'];
	}

	public static function getListByName( $name ) {
		$lists = self::getListsOfAssets();

		$lists = array_filter( $lists, function( $list ) use ( $name ) {
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

			return $list['headers'];
		} catch( Exception $e ) {
			return [
				'Could not download list.'
			];
		}
	}
}