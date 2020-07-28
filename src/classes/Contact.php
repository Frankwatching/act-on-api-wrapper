<?php

namespace Frankwatching\ActOn;

class Contact {
	public static function add( array $contact, $listId, $returnContact ) {
		return Client::post( "/list/$listId/record?returncontact=$returnContact", $contact );
	}

	public static function get( $listId, $recordId ) {
		return Client::get( "/list/$listId/record/$recordId" );
	}

	public static function updateByEmail( $emailAddress, $listId, $contact ) {

		var_dump( "/list/$listId/record?email=$emailAddress" );
		exit;

		return Client::put( "/list/$listId/record?email=$emailAddress", $contact );
	}

	public static function getByEmail( $emailAddress, $listId ) {
		try {
			$contact = Client::get( "/list/lookup/$listId?email=$emailAddress" );
		} catch( \Exception $e ) {
			return $e->getCode();
		}

		return $contact;
	}
}