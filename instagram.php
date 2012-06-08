<?php
include_once( 'nikeplus.php' );
session_start();

if(isset($_GET[hub_challenge])) echo $_GET[hub_challenge];

$php_input = file_get_contents('php://input');
date_default_timezone_set('Asia/Shanghai');
$ALL = date("F.j.Y, g:i:s a")." ".$php_input." [from ".$_SERVER['REMOTE_ADDR']."]\r\n";
file_put_contents('log/instagram.activity.log', $ALL, FILE_APPEND);

$insta_url = "https://api.instagram.com/v1/tags/fuelnow/media/recent?access_token=6879280.f59def8.ef48ee03319c4fac8605b38d2436d7db&count=20";
$insta_json_data = json_decode( file_get_contents($insta_url) );
$data = $insta_json_data->data;

$json_data = getJson( $url );

foreach($data as $data) {
	// check
	$done = false;
	$pattern = '/@dbdbking now has [0-9,]* fuel points\./';
	foreach($data->comments->data as $comment) {
		//preg_match($pattern, '@dbdbking now has 1,222 fuel points.', $matches);
		//echo count($matches). ' ';
		preg_match($pattern, $comment->text, $matches);
		if( count($matches) > 0 ) {
			$done = true;
			break;
		}
	}

	// post comment: @dbdbking now has xxxx fuel points.
	if(!$done && ($data->user->username == 'dollydori' || $data->user->username == 'dbdbking')) {
		// get dbdbking's fuel point
		$_comment =  '@dbdbking+now+has+' . $json_data->daily[0]->summary->totalFuel . '+fuel+points.';

		// post comment
		$post_url = 'https://api.instagram.com/v1/media/' . $data->id . '/comments';
//https://api.instagram.com/v1/media/201816754157184555_6879280/comments?access_token=6879280.f59def8.ef48ee03319c4fac8605b38d2436d7db&text=a+test
		$ch = curl_init( $post_url );
		$post_options = array(
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => 'access_token=6879280.f59def8.ef48ee03319c4fac8605b38d2436d7db&text=' . $_comment
		);
		curl_setopt_array( $ch, $post_options );
		curl_exec($ch);
	}
/*
	if($data->user->username)
	define(UNIX_TIMESTAMP, date('U'));

	$target = 'upload_img/' . md5(UNIX_TIMESTAMP) . '_' . rand(0, 9999) . '.jpg';
	save_image($data->images->standard_resolution->url, $target);

	$sql="INSERT INTO wkshdisplay (name, content, time, platform, pic, instagram) VALUES ('" .
		addslashes($data->user->full_name) . "', '" .
		addslashes($data->caption->text) . "', " . UNIX_TIMESTAMP . ", 'instagram', '" .
		addslashes($target) . "', '" .
		$data->id . "')";
*/
	echo '-<br>';
}
?>
