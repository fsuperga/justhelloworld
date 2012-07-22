<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require 'src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '265860710193836',
  'secret' => '49646f8a9fb162a5eaceb3b006ea54c8',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>*** Mutual Friends ***</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <h1>*** My Friends ***</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <?php if ($user): ?>
      <h3>You are logged in as: <?php echo $user_profile['name']; ?></h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture"/>
      <table border="1">
          <tr><th>My Friends</th><th>Common Friends</th></tr>

        <?php
          $friends     =   $facebook->api('/me/friends');
          //print_r($friends);

          foreach ($friends['data'] as $key=>$friendList)
          {
              $param = '/me/mutualfriends/'.$friendList['id'];
              $mutual_friends     =   $facebook->api($param);

              echo "<tr><td colspan = '2' bgcolor = '#111111'><img src='https://graph.facebook.com/".$friendList['id']."/picture' width='50' height='50' title='".$friendList['name']."' />".$friendList['name']."</td>";

              foreach ($mutual_friends['data'] as $key2=>$mutualFriendList)
              {
                  if ($key2 ==1)
                  {
                      echo "<td><img src='https://graph.facebook.com/".$mutualFriendList['id']."/picture' width='50' height='50' title='".$mutualFriendList['name']."' />".$mutualFriendList['name']."</td></tr>";
                  }
                  else
                  {
                      echo "<tr><td></td><td><img src='https://graph.facebook.com/".$mutualFriendList['id']."/picture' width='50' height='50' title='".$mutualFriendList['name']."' />".$mutualFriendList['name']."</td></tr>";

                  }

              }
          }
        ?>
      </table>
      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>

    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

  </body>
</html>
