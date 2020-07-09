<?php

namespace Frankwatching\ActOn;

use Exception;

use Frankwatching\ActOn\Client;

class Lists {
	public static function createList( $listname, $uploadspecs = [], $quotecharacter = 'NONE', $foldername = '', $headings = 'Y', $fieldseparator = 'COMMA' ) {
		try {
			$data = [
				'listname'       => $listname,
				'uploadspecs'    => $uploadspecs,
				'quotecharacter' => $quotecharacter,
				'foldername'     => $foldername,
				'headings'       => $headings,
				'fieldseparator' => $fieldseparator,
			];

			$response = Client::post( '/list', $data, [
				'Content-Type' => 'multipart/form-data'
			] );

			return $response;

		} catch ( Exception $e ) {

			return false;
		}
	}
}