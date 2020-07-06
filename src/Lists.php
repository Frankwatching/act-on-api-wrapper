<?php

namespace Frankwatching\ActOn;

class Lists extends ActOn {
	public function createList( $listname ) {
		return $this->getClient()->post( 'api/1/list', [
			'listname' => $listname
		]);
	}
}