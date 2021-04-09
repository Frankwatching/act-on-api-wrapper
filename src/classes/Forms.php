<?php

namespace Frankwatching\ActOn;

class Forms {
	public static function get() {
		return Client::get( '/form' );
	}
}