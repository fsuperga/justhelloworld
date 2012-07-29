<?php
//$location 	= 'albums';
$userid         = $_GET['userid'];
$param          = '/me/mutualfriends/'.$friendList['id'];
$mutual_friends = $facebook->api($param);
$images         = array();
foreach ($mutual_friends['data'] as $key=>$mutualFriendList)
{
    $images[] = "https://graph.facebook.com/".$mutualFriendList['id']."/picture";
}
//$files 		= glob($location . '/' . $album_name . '/*.{jpg,gif,png}', GLOB_BRACE);
//$encoded 	= json_encode($files);
$encoded 	= json_encode($images);
echo $encoded;
unset($encoded);