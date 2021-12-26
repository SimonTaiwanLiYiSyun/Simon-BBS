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
      <link rel='stylesheet' href='styles.css' type='text/css'>
      <script src='javascript.js'></script>
      <script src='jquery-2.2.4.min.js'></script>
      <script src='jquery.mobile-1.4.5.min.js'></script>

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

  if($loggedin)
  {
    echo <<<_MAIN   
        <title>Logged In</title>
      </head>

      <!-- https://www.w3schools.com/howto/howto_js_dropdown.asp -->

      <div class="navbar">
        <a href="#home">Home</a>
        <a href="#news">News</a>
        <div class="dropdown">
          <button class="dropbtn">Dropdown 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
          </div>
        </div> 
      </div>

    _MAIN;
  }
  else
  {
    echo '<script>
      alert("You have not log in."); 
      setTimeout(() => {}, 5000); 
      window.location.href="./index.php";
    </script>';
  }
?>