<?php

namespace Frankwatching\ActOn;

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
		} catch( \Exception $e ) {
			return false;
		}

		return $contact;
	}
}