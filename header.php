<?php
  session_start();
  require_once 'functions.php';

  echo <<<_INIT
  <!DOCTYPE html> 
  <html>
    <head>
      <meta charset='utf-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1'> 
      <link rel='stylesheet' href='jquery.mobile-1.4.5.min.css'>
      <link rel="stylesheet" type="text/css" href="src/header.css">
      <script src='javascript.js'></script>
      <script src='jquery-2.2.4.min.js'></script>
      <script src='jquery.mobile-1.4.5.min.js'></script>
      <script src="https://code.jquery.com/jquery-3.5.0.js"></script>

  _INIT;
  
  $randstr = substr(md5(rand()), 0, 7);

  if(isset($_SESSION['user']))
  {
    $user = $_SESSION['user'];
    $loggedin = TRUE;
  }
  else {
    $loggedin = FALSE;
  }
  
  $result = queryMysql("SELECT * FROM user WHERE username='$user'");

  $userData = $result->fetch_array(MYSQLI_ASSOC);
  $user_ID = $userData['user_ID'];
  $permission = $userData['default_permission'];

  if($loggedin)
  {
    echo <<<_MAIN
        <title>Logged In</title>
      </head>

      <!-- https://www.w3schools.com/howto/howto_js_dropdown.asp -->

      <body>
      <div class="navbar">
        <a href="board.php">Simon-BBS</a>
        <div class="dropdown">
          <button class="dropbtn" onclick="myFunction()">Menu
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content" id="myDropdown">
            <a href="profile.php">Setting</a>
            <a href="logout.php">Logout</a>
          </div>
        </div> 
      </div>
        <script src="src/header.js"></script> 
    _MAIN;
    if($permission > 0)
    {
      echo <<<_ADMIN
            </head>
              <div class="navleft">
                <a href="./post.php">Create Post</a>
                <a href="./rule.php">Show Permission</a>
                <a href="./member.php">Show Teammate</a>
              </div>
      _ADMIN;
    }
    else
    {
      echo <<<_WORKER
            </head>
              <div class="navleft">
                <a href="./member.php">Show Teammate</a>
              </div>
      _WORKER;
    }
  }
  else
  {
    echo '<script>
      alert("You have not log in."); 
      setTimeout(() => {}, 5000); 
      window.location.href="./index.php";
    </script>';
  }

  $result_2 = queryMysql("SELECT * FROM profiles WHERE user_ID='$user_ID'");
  
  $userProfile = $result_2->fetch_array(MYSQLI_ASSOC);
  $department = $userProfile['department'];
  unset($result, $result_2);
?>