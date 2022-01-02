<?php
  require_once 'functions.php';

  if (isset($_POST['changepwd']))
  {
    
    $user = $_SESSION['user'];
    $new_password = santizeString($_POST['new_password']);
    $query = "UPDATE user SET password = '$new_password' WHERE username = '$user'";
    mysql_query($query);

    $_SESSION['pass'] = $new_password;
    
    echo <<< EOT
      <script>
        alert("Done.");
        window.history.go(-1);
      </script>		
    EOT;
  }
  else
	{
    exit('Illegal call to this page.');
  }
?>