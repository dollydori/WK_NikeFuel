<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];

if( isset($uid) && isset($_GET['text']) ) {
	$c->update($_GET['text']);
	echo 'the fuel point has posted to your weibo successfully';
} else {
	echo 'something went wrong...';
}
?>
