<?php

namespace Frankwatching\ActOn;

class Contact {
	public static function add( array $contact, $listId ) {
		return Client::post( "/list/$listId/record", $contact );
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
		return Client::get( "/list/lookup/$listId?email=$emailAddress" );
	}
}