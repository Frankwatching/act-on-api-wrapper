<?php

namespace Frankwatching\ActOn;

use Frankwatching\ActOn\Client;

class EmailCampaign {
	public static function send(
		$sender_email,
		$sender_name,
		$send_to_ids,
		$subject,
		$text_body,
		$html_body,
		$header = 0,
		$footer = 0,
		$is_custom = 'Y',
		$when = 0
	) {
		return Client::post( '/message/custom/send', [
			'id'          => 'custom',
			'senderemail' => $sender_email,
			'sendername'  => $sender_name,
			'sendtoids'   => $send_to_ids,
			'when'        => $when,
			'subject'     => $subject,
			'textbody'    => $text_body,
			'htmlbody'    => $html_body,
			'iscustom'    => $is_custom,
			'headerid'    => $header,
			'footerid'    => $footer
		], [
			'Content-Type' => 'application/x-www-form-urlencoded',
			'Accept'       => 'application/json',
		], false, true );
	}
}


