<?php
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

              echo "<tr><td colspan = '2' bgcolor = '#CCFFFF'><img src='https://graph.facebook.com/".$friendList['id']."/picture' width='50' height='50' title='".$friendList['name']."' />".$friendList['name']."</td></tr>";

              foreach ($mutual_friends['data'] as $key2=>$mutualFriendList)
              {
                  echo "<tr><td></td><td>".$key2."<img src='https://graph.facebook.com/".$mutualFriendList['id']."/picture' width='50' height='50' title='".$mutualFriendList['name']."' />".$mutualFriendList['name']."</td></tr>";
              }
          }
        ?>
      </table>
      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>

    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

?>
