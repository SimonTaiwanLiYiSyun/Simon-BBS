<?php
  require_once 'functions.php';

  if (isset($_POST['r_user']))
  {
    $r_user   = santizeString($_POST['r_user']);
    $result = queryMysql("SELECT * FROM user WHERE username='$r_user'");

    if ($result->num_rows)
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "The username '$r_user' is taken</span>";
    else
      echo "<style type='text/css'>.available{color: #4bb544; margin-top: 0.5rem; font-size: 0.85rem;}</style>
          <span class='available'>&nbsp;&#x2714; " .
           "The username '$r_user' is available</span>";
  }

  unset($result);
?>
