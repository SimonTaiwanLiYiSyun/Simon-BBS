<?php
  require_once 'functions.php';

  if (isset($_POST['password']))
  {
    $password   = santizeString($_POST['password']);
    $result = queryMysql("SELECT * FROM user WHERE password='$password'");

    if (!$result->num_rows)
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "The password is incorrect.</span>";
  }
?>
