<?php

namespace Frankwatching\ActOn;

use Frankwatching\ActOn\Client;

class EmailCampaign {
	public static function send(
		$sender_email,
		$sender_name,
		$send_to_ids,
		$when = 0,
		$subject,
		$text_body,
		$html_body,
		$is_custom = 'Y'
	) {
		return Client::post( '/message/custom/send', [
			'senderemail' => 'nieuwsbrief@frankwatching.com',
			'sendername' => 'Frankwatching NieuwsAlert',
			'sendtoids' => 'q-002d',
			'when' => $when,
			'subject' => 'Frankwatching Nieuwsalert',
			'textbody' => 'Dit is de body text',
			'htmlbody' => '<span>Dit is de HTML text</span>',
			'iscustom' => 'Y',
			'headerid' => 1,
			'footerid' => 1
		], [
			'Content-Type' => 'application/x-www-form-urlencoded',
		], false, true );
	}
}