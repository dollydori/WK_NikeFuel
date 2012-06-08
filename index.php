<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		body {
			font-family: sans-serif;
			font-size: 16px;
			color: black;
			margin: 0;
			padding: 0;
		}

		.fg {
			position: absolute;
		}

		.fuel {
			color: #C33;
			font-size:50px;
			margin-bottom: 30px;
		}

		.note {
			position: absolute;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: hidden;
			color: #EEE;
			margin: 0;
			padding: 0;
		}

		.share_btn {
			color: white;
			background-color: #666;
			border: 3px solid #CCC;
			padding: 5px;
			font-size: 16px;
			margin-left: 20px;
			cursor: pointer;
		}

		#mask {
			position: absolute;
			top: 0;
			width: 100%;
			height: 100%;
			overflow: hidden;
			background-color: rgba(0, 0, 0, 0.5);
			display: none;
		}

		.msg_box {
			width: 400px;
			height: 200px;
			background-color: white;
			border: 5px solid #CCC;
			margin: 20px auto;
		}

		.msg {
			color: black;
			text-align: center;
			width: 100%;
			margin-top: 35px;
		}

		.btn {
			width: 120px;
			height: 35px;
			background-color: #666;
			border: 3px solid #CCC;
			margin-top: 35px;
			text-align: center;
			vertical-align: middle;
			line-height: 35px;
			cursor: pointer;
			color: white;
		}

		#ok_btn {
			float: right;
			margin-right: 60px;
			background-color: #C33;
			border: 3px solid #FCC;
		}

		#cancel_btn {
			float: left;
			margin-left: 60px;
		}
	</style>
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript">
		var text = "";

		$(document).ready(function() {
			$('.share_btn').click(function()  {
				text = $(this).attr('title');

				$('#mask').fadeIn(200);
				$('#mask .btn:hidden').show(0);
				$('#mask .msg').html('You want to share the post<br />" ' + text + ' "<br />on your weibao?');
			});

			$('#cancel_btn').click(function() {
				$('#mask').fadeOut(200);
			});
			$('#ok_btn').click(function() {
				$('#mask .btn').hide(0);
				$('#mask .msg').html('Please wait while the message is being posted...');

				$.ajax({
					type:	'GET',
					url:	'weiboshare.php',
					data:	{text: text},
					success:
						function(data) {
							$('#mask .msg').html('Done!');
							setTimeout(function() {
								$('#mask').fadeOut(200);
							}, 500);
						}
				});
			});
		});
	</script>
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




	$token2='414673250f7201d16c47ba3396f4c5ed';
	$device2='05596a33-b0db-49bd-9e9c-9870ebd4f770';
	$url2 = 'https://api.nike.com/v1.0/me/activities/summary/' . $date_string . '?deviceId=' . $device2 . '&access_token=' . $token2 . '&endDate=' . $date_string . '&fidelity=96';

	



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
	
	
	
	$ch2=curl_init($url2);
		// Configuring curl options
	$options2 = array(
			CURLOPT_RETURNTRANSFER => true,
			//CURLOPT_USERPWD => $username . ":" . $password,   // authentication
			CURLOPT_HTTPHEADER => array('Content-type: application/json', 'appid: fuelband', 'Accept: application/json')
			//CURLOPT_POSTFIELDS => $json_string
		);

		// Setting curl options
		curl_setopt_array( $ch2, $options2 );

		// Getting results
		$result2 = curl_exec($ch2);

		// Parse json
		$json_data2 = json_decode($result2);

	
	
	

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



	echo '<div class="note">';
	echo $result;
	echo '</div>';

	echo '<div class="fg">';

	echo '<div>';
	echo '<h1>FUEL POINT SHARER</h1>';

	echo '	<div class="owner">Francis\' Fuel now:</div>';
	echo '	<div class="fuel">' . $json_data->daily[0]->summary->totalFuel . '/'.$json_data->daily[0]->summary->lastKnownDailyGoal;
	if(isset($uid)) echo '<span class="share_btn" title="Francis\' current fuel point = ' . $json_data->daily[0]->summary->totalFuel . '">share to weibo</span>';
	echo '	</div>';
	echo '</div>';

	echo '<div>';
	echo '	<div class="owner">Nacoki\'s Fuel now:</div>';
	echo '	<div class="fuel">' . $json_data2->daily[0]->summary->totalFuel. '/'.$json_data2->daily[0]->summary->lastKnownDailyGoal;
	if(isset($uid)) echo '<span class="share_btn" title="Nacoki\'s current fuel point = ' . $json_data2->daily[0]->summary->totalFuel . '">share to weibo</span>';
	echo '	</div>';
	echo '</div>';

	if(!isset($uid)) echo '<p><a href="' . $code_url . '"><img src="weibo_login.png" title="weibo login" alt="weibo login" border="0" /></a></p>';

	echo '</div>';

	echo '<div id="mask">';
	echo '	<div class="msg_box">';
	echo '		<div class="msg"></div>';
	echo '		<div class="btn" id="cancel_btn">Cancel</div>';
	echo '		<div class="btn" id="ok_btn">Yes</div>';
	echo '	</div>';
	echo '</div>';


	?>



</body>
</html>
