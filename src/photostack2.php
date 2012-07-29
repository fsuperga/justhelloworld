<?php

require 'src/facebook.php';

if ($facebook->getSession()) {
?><a href=”<?php echo $facebook->getLogoutUrl(); ?>”>Logout</a><?php
$user = $facebook->api('/me');
}
else {
?><a href=”<?php echo $facebook->getLoginUrl(); ?>”>Login</a><?php
}

//$location 	= 'albums';
$userid         = $_GET['userid'];
$param          = '/me/mutualfriends/'.$userid ;
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
?>