<?php
include_once( 'nikeplus.php' );

$json_data = getJson( $url );
$json_data2 = getJson( $url2 );

// Check timezone
if( chToUserTZ($json_data) ) {
	$url = makeUrl( $access_token, $device_id );
	$json_data = getJson( $url );
}

if( chToUserTZ($json_data2) ) {
	$url2 = makeUrl( $access_token2, $device_id2 );
	$json_data2 = getJson( $url2 );
}

header('Content-type: application/json');

$data_ret = array(
	array(
		'name' => 'francis',
		'fuel' => $json_data->daily[0]->summary->totalFuel,
		'goal' => $json_data->daily[0]->summary->lastKnownDailyGoal
	),
	array(
		'name' => 'nacoki',
		'fuel' => $json_data2->daily[0]->summary->totalFuel,
		'goal' => $json_data2->daily[0]->summary->lastKnownDailyGoal
	)
);

echo json_encode($data_ret);
?>
