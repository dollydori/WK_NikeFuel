<?php
$zonelist = array(
	'Kwajalein' => -12.00,
	'Pacific/Midway' => -11.00,
	'Pacific/Honolulu' => -10.00,
	'America/Anchorage' => -9.00,
	'America/Los_Angeles' => -8.00,
	'America/Denver' => -7.00,
	'America/Tegucigalpa' => -6.00,
	'America/New_York' => -5.00,
	'America/Caracas' => -4.30,
	'America/Halifax' => -4.00,
	'America/St_Johns' => -3.30,
	'America/Argentina/Buenos_Aires' => -3.00,
	'America/Sao_Paulo' => -3.00,
	'Atlantic/South_Georgia' => -2.00,
	'Atlantic/Azores' => -1.00,
	'Europe/Dublin' => 0,
	'Europe/Belgrade' => 1.00,
	'Europe/Minsk' => 2.00,
	'Asia/Kuwait' => 3.00,
	'Asia/Tehran' => 3.30,
	'Asia/Muscat' => 4.00,
	'Asia/Yekaterinburg' => 5.00,
	'Asia/Kolkata' => 5.30,
	'Asia/Katmandu' => 5.45,
	'Asia/Dhaka' => 6.00,
	'Asia/Rangoon' => 6.30,
	'Asia/Krasnoyarsk' => 7.00,
	'Asia/Brunei' => 8.00,
	'Asia/Seoul' => 9.00,
	'Australia/Darwin' => 9.30,
	'Australia/Canberra' => 10.00,
	'Asia/Magadan' => 11.00,
	'Pacific/Fiji' => 12.00,
	'Pacific/Tongatapu' => 13.00
);

// Default timezone
date_default_timezone_set('Asia/Shanghai');
$default_TZOffset = 8.00;

$access_token = '';
$device_id = '';
$url = makeUrl( $access_token, $device_id );

$access_token2='';
$device_id2='';
$url2 = makeUrl( $access_token2, $device_id2 );

// Configuring curl options
$options = array(
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_HTTPHEADER => array('Content-type: application/json', 'appid: fuelband', 'Accept: application/json')
);

function makeUrl( $_access_token, $_device_id ) {
	$date_string = date("dmy");
	return 'https://api.nike.com/v1.0/me/activities/summary/' . $date_string . '?deviceId=' . $_device_id . '&access_token=' . $_access_token . '&endDate=' . $date_string . '&fidelity=96';
}

function getJson( $_url ) {
	// Initializing curl
	$ch = curl_init( $_url );

	// Setting curl options
	curl_setopt_array( $ch, $GLOBALS['options'] );

	// Getting results
	$result = curl_exec($ch);

	// Parse json
	return json_decode($result);
}

/*
	return true if default timezone is changed
 */
function chToUserTZ( $_json_data ) {
	$ch_flag = false;
	$user_TZOffset = (int)($_json_data->daily[0]->summary->mostRecentTZOffset);
	if($GLOBALS['user_TZOffset'] != $GLOBALS['default_TZOffset']) {
		$index = array_keys($GLOBALS['zonelist'], $user_TZOffset);
		if(sizeof($index) == 1) {
			date_default_timezone_set($index[0]);
			$GLOBALS['default_TZOffset'] = $user_TZOffset;
			$ch_flag = true;
		}
	}

	return $ch_flag;
}
?>
