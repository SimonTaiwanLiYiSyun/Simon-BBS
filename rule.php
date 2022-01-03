<?php
  require_once 'header.php';

  if($permission < 1) 
  {
    echo '
    </body></html>
    <script>
      alert("Permission deny."); 
      setTimeout(() => {}, 5000); 
      window.location.href="./board.php";
    </script>';
  }

  $query = "SELECT * FROM profiles where department='$department'";
  $result_5 = queryMysql($query);

  echo <<<_MEMBERSTART
    <table class='member'>
      <thead>
        <tr>
          <td>Username</td>
          <td>Permission</td>
          <td>Register Time</td>
        </tr>
      </thead>
      <tbody>
  _MEMBERSTART;

  while($userProfile = $result_5->fetch_array(MYSQLI_ASSOC))
  {
    $member_ID = $userProfile['user_ID'];
    $query = "SELECT * FROM user where user_ID='$member_ID'";
	  $result_6 = queryMysql($query);
    $memberData = $result_6->fetch_array(MYSQLI_ASSOC);
    $memberName = $memberData['username'];
    $memberPermission = $memberData['default_permission'];
    $registerTime = $memberData['registeration_time'];
    
    echo <<<_POST
          <tr>
            <td>$memberName</td>
            <td>$memberPermission</td>
            <td>$registerTime</td>
          </tr>
    _POST;
  }

  echo <<<_MEMBEREND
      </tbody>
    </table>
  </body></html>
  _MEMBEREND;
?>