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
			color: #999;
		}
	</style>
</head>
<body>
	<?php
	//date_default_timezone_set('Asia/Shanghai');
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
	echo 'Francis\'s daily total fuel up to ';
	echo date("F.j.Y, g:i:s a");
	echo ' is ';
	echo '<span class="fuel">' . $json_data->daily[0]->summary->totalFuel . '</span>';
	echo '.';

	echo '<div class="note">';
	echo $result;
	echo '</div>';
	?>
</body>
</html>
