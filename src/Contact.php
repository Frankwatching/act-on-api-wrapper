<?php

namespace Frankwatching\ActOn;

class Contact extends ActOn {
	public function add( array $contact, $listId ) {
		return $this->client->post( "/list/$listId/record", $contact );
	}

	public function get( $listId, $recordId ) {
		return $this->client->get( "/list/$listId/record/$recordId" );
	}

	public function updateByEmail( $emailAddress, $listId, $contact ) {
		return $this->client->put( "/list/$listId/record?email=$emailAddress", $contact );
	}
}