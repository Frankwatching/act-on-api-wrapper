<?php

namespace Frankwatching\ActOn;

use Namshi\Cuzzle\Formatter\CurlFormatter;

class Contact {
	public static function add( array $contact, $listId, $returnContact = 'N' ) {
		try {
			return Client::post( "/list/$listId/record?returncontact=$returnContact", $contact );
		} catch ( \Exception $e ) {
			return false;
		}

	}

	public static function get( $listId, $recordId ) {
		return Client::get( "/list/$listId/record/$recordId" );
	}

	public static function updateById( $contactId, $listId, $contact ) {
		return Client::put( "/list/$listId/record/$contactId", $contact );
	}

	public static function updateByEmail( $emailAddress, $listId, $contact ) {
		$emailAddress = rawurlencode( $emailAddress );

		try {
			$result = Client::put( "/list/$listId/record?email=$emailAddress", $contact );
		} catch( \Exception $e ) {
			return $e;
		}

		return $result;
	}

	public static function getByEmail( $emailAddress, $listId ) {
		$emailAddress = rawurlencode( $emailAddress );

		try {
			$contact = Client::get( "/list/lookup/$listId?email=$emailAddress" );

			if ( is_object( $contact ) && property_exists( $contact, 'errorCode' ) && 10162 === $contact->errorCode ) {
				return false;
			}

		} catch( \Exception $e ) {
			return false;
		}

		return $contact;
	}

	public static function optOut( $emailAddress ) {
		$client = Client::getClient();

		$array = [
			'danny@frankwatching.com'
		];

//		header('Content-Type: text/csv; charset=utf-8');
//		header('Content-Disposition: attachment; filename=data.csv');
//
		$output = fopen('./optout.csv', 'w');

		fputcsv($output, [ $emailAddress ] );

		$metaDatas = stream_get_meta_data($output);



		$options = [
			'multipart' => [
				[
					'name'     => 'file',
					'contents' => './optout.csv',
//					'filename' => 'optout.csv',
				],
			],
			'headers' => [
				'Authorization' => 'Bearer ' . Client::getClientToken()
			]
		];

		$request = $client->request( 'PUT', 'api/1/list/optout', $options );

		$result = json_decode( $request->getBody()->getContents() );

		var_dump( $result );
		exit;
//
//		fclose($output);
//
//		var_dump( $output );
//		exit;
//
//		exit;
//
//		$temp = tmpfile();
//		fwrite($temp, "writing to tempfile");
//		fseek($temp, 0);
//
//		$metaDatas = stream_get_meta_data($temp);
//
//		var_dump( $metaDatas );
//		exit;
//
//		echo fread($temp, 1024);
//		fclose($temp); // this removes the file
//
//		var_dump( $client );
	}
}