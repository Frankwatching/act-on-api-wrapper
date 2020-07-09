<?php

namespace Frankwatching\ActOn;

class Contact {
	public function add( array $contact, $listId ) {
		return Client::post( "/list/$listId/record", $contact );
	}

	public function get( $listId, $recordId ) {
		return Client::get( "/list/$listId/record/$recordId" );
	}

	public function updateByEmail( $emailAddress, $listId, $contact ) {
		return Client::put( "/list/$listId/record?email=$emailAddress", $contact );
	}
}