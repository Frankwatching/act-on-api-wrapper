<?php

namespace Frankwatching\ActOn;

class Contact extends ActOn {
	public static function add( array $contact, $listId ) {
		return self::$client->post( "/list/$listId/record", $contact );
	}

	public static function get( $listId, $recordId ) {
		return self::$client->get( "/list/$listId/record/$recordId" );
	}

	public static function updateByEmail( $emailAddress, $listId, $contact ) {
		return self::$client->put( "/list/$listId/record?email=$emailAddress", $contact );
	}
}