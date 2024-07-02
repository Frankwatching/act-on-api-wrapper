<?php

namespace Frankwatching\ActOn;

use Exception;
use Frankwatching\ActOn\Client;

class Account
{

	public static function get()
	{
		try {

			$account = Client::get('/account');

			var_dump($account);
			exit;
		} catch (Exception $e) {
			return [];
		}
	}
}

