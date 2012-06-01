<html>
<head>
	<style type="text/css">
		body {
			font-family: sans-serif;
			color: black;
		}

		.fuel {
			color: #C33;
		}

		.note {
			margin-top: 10px;
			color: #EEE;
		}
	</style>
</head>
<body>
	<?php
	// Default timezone
	date_default_timezone_set('Asia/Shanghai');
	$default_TZOffset = 8.00;

	$access_token = 'f3010061e36ba14faedc9a3912a53162';
	//$device_id = 'e5fccd81-4fcc-42c1-9122-51cd5e4358e6';
	$device_id = '3bcc52ce-d277-4ef3-b06f-4d4d832330a4';
	$date_string = date("dmy");
	$url = 'https://api.nike.com/v1.0/me/activities/summary/' . $date_string . '?deviceId=' . $device_id . '&access_token=' . $access_token . '&endDate=' . $date_string . '&fidelity=96';

	// Initializing curl
	$ch = curl_init( $url );

	// Configuring curl options
	$options = array(
		CURLOPT_RETURNTRANSFER => true,
		//CURLOPT_USERPWD => $username . ":" . $password,   // authentication
		CURLOPT_HTTPHEADER => array('Content-type: application/json', 'appid: fuelband', 'Accept: application/json')
		//CURLOPT_POSTFIELDS => $json_string
	);

	// Setting curl options
	curl_setopt_array( $ch, $options );

	// Getting results
	$result = curl_exec($ch);

	// Parse json
	$json_data = json_decode($result);

	// Check timezone
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
	$user_TZOffset = (int)($json_data->daily[0]->summary->mostRecentTZOffset);
	if($user_TZOffset != $default_TZOffset) {
		$index = array_keys($zonelist, $user_TZOffset);
		if(sizeof($index) == 1) {
			date_default_timezone_set($index[0]);
			$date_string = date("dmy");
			$url = 'https://api.nike.com/v1.0/me/activities/summary/' . $date_string . '?deviceId=' . $device_id . '&access_token=' . $access_token . '&endDate=' . $date_string . '&fidelity=96';
			$ch = curl_init( $url );
			curl_setopt_array( $ch, $options );
			$result = curl_exec($ch);
			$json_data = json_decode($result);
		}
	}

	echo '!!!!!!!!!!!!!!!!!!!!!!!!! Francis\'s daily total fuel up to ';
	echo date("F.j, Y, g:i:sa");
	echo ' is ';
	echo '<span class="fuel">' . $json_data->daily[0]->summary->totalFuel . '</span>';
	echo '.';

	echo '<div class="note">';
	echo $result;
	echo '</div>';
	?>
</body>
</html>
