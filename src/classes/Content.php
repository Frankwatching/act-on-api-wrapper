<?php

namespace Frankwatching\ActOn;

use Frankwatching\ActOn\Client;

class Content {
	public static function getHeaderList() {
		return Client::get( '/header' );
	}

	public static function getFooterList() {
		return Client::get( '/footer' );
	}
}