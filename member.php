<?php

  require_once 'header.php';

  if (!$loggedin) die("</body></html>");

  $query = "SELECT * FROM profiles where department='$department'";
  $result_5 = queryMysql($query);

  echo <<<_MEMBERSTART
    <h2>User List</h2>
    <table class="main">
      <tbody>
  _MEMBERSTART;

  while($userProfile = $result_5->fetch_array(MYSQLI_ASSOC))
  {
    $member_ID = $userProfile['user_ID'];
    $query = "SELECT * FROM user where user_ID='$member_ID'";
	  $result_6 = queryMysql($query);
    $memberData = $result_6->fetch_array(MYSQLI_ASSOC);
    $memberName = $memberData['username'];
    $registerTime = $memberData['registeration_time'];
    
    echo <<<_POST
          <tr>
            <td>$memberName</td>
            <td>$registerTime</td>
          </tr>
    _POST;
  }

  echo <<<_MEMBEREND
      </tbody>
    </table>
  </body></html>
  _MEMBEREND;

  unset($result_5, $result_6);
?>