<?php

namespace Frankwatching\ActOn;

use Exception;

use Frankwatching\ActOn\Client;

class Lists {
	public static function createList( $listname, array $uploadspecs = [], $quotecharacter = 'NONE', $foldername = '', $headings = '', $fieldseparator = '' ) {
		try {
			$data = [
				'listname'       => $listname,
				'uploadspecs'    => $uploadspecs,
				'quotecharacter' => $quotecharacter,
				'foldername'     => $foldername,
				'headings'       => $headings,
				'fieldseparator' => $fieldseparator,
			];

			$response = Client::post( '/1/list', $data );

			return $response;

		} catch ( Exception $e ) {

			var_dump( $e );
			exit;

			return false;
		}
	}
}