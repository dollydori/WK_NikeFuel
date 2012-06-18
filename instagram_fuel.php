<?php
include_once( 'nikeplus_advance.php' );
session_start();

$access_id_for_instagram_account = '179725199.f59def8.110f604ab853449e86d1e6f21e2fb063';

if(isset($_GET[hub_challenge])) echo $_GET[hub_challenge];

$php_input = file_get_contents('php://input');

$insta_url = 'https://api.instagram.com/v1/tags/instafuel/media/recent?access_token=' . $access_id_for_instagram_account . '&count=20';
$insta_json_data = json_decode( file_get_contents($insta_url) );
$data = $insta_json_data->data;

$POST = '';

foreach($data as $data) {
	// check
	$done = false;
	foreach($data->comments->data as $comment) {
		preg_match($pattern, $comment->text, $matches);
		if( $comment->from->username == 'instafuel' ) {
			$done = true;
			break;
		}
	}


	// post comment: @dbdbking now has xxxx fuel points.
	if( !$done ) {
		if( array_key_exists($data->user->username, $data_array) ) {
			// get user's fuel point
			$_user_data = $data_array[$data->user->username];
			$json_data = getJson( makeUrl($_user_data['access_token'], $_user_data['device_id']) );
			if( chToUserTZ($json_data) ) $json_data = getJson( makeUrl($_user_data['access_token'], $_user_data['device_id']) );

			$_fuel = (int)($json_data->daily[0]->summary->totalFuel);
			$_goal = (int)($json_data->daily[0]->summary->lastKnownDailyGoal);
			if( $_fuel >= $_goal ) {
				$_comment = '[ ' . $_fuel . ' FUEL ] GOAL!!';
			} else {
				$_comment = '[ ' . $_fuel . '/' . $_goal . ' FUEL ]';
			}

			// post comment
			$POST = ' {comment to ' . $data->user->username . ': ' . $_comment . '}';
			$post_url = 'https://api.instagram.com/v1/media/' . $data->id . '/comments';
			$ch = curl_init( $post_url );
			$post_options = array(
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => 'access_token=' . $access_id_for_instagram_account . '&text=' . $_comment
			);
			curl_setopt_array( $ch, $post_options );
			curl_exec($ch);
		} else {
			//$_comment = "Sorry, instaFUEL is now only for beta users!";  // updated by Francis to disable this feature...
		}
	}
}

$ALL = date("F.j.Y, g:i:s a")." ".$php_input." [from ".$_SERVER['REMOTE_ADDR']."]".$POST."\r\n";
file_put_contents('log/instagram.fuel.activity.log', $ALL, FILE_APPEND);
?>
