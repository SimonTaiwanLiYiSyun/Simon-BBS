<?php
  $dbhost = 'localhost';
  $dbname = 'simonbbs';
  $dbuser = 'simon';
  $dbpass = 'yilan12th';

  /*
  * function mysql_fatal_error() {
  *   echo <<<_END
  *   We are sorry, but it was not possible to complete the 
  *   requested task. The error message we got was:
  *   <p>Fatal Error</p>
  *   Please click the back button on your browser and try again.
  *   If you are still have problems, please <a href="mailto:simontw110309@gmail.com">email
  *   our administrator</a>. Thank you.
  * _END;
  }

  set_error_handler("mysql_fatal_error");   // 設定自定義錯誤處理函式。
  */

  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if($connection->connect_error) die("Fatal Error");
  
  function createTable($name, $column)
  {
    $query = "CREATE TABLE IF NOT EXISTS $name($column)";
    queryMysql($query);
    echo "Table '$name' created or already exits.<br>";
  }

  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    // if(!$result) die("Fatal Error");
    if(!$result) die("Query Error");
    return $result;
  }

  function destorySession()
  {
    $_SESSION = array();        // unset all session variables.

    setcookie(session_name(), '', time() - 2592000, '/');

    session_destroy();
  }

  function santizeString($var)
  {
    global $connection;
    $var = strip_tags($var);    // Strip HTML and PHP tags from a string. 去除標籤
    $var = htmlentities($var);  // 去除所有html元素

    if(get_magic_quotes_gpc()) {
      $var = stripslashes($var);
    }
    return $connection->real_escape_string($var);
  }

  function showProfile($user_ID, $user)
  {
    global $connection;

    if (file_exists("$user.jpg"))
      echo "<img src='$user.jpg' style='float:left; margin-left: 196px;'>";

    $result = $connection->query("SELECT * FROM profiles WHERE user_ID='$user_ID'");
    $userData = $result->fetch_array(MYSQLI_ASSOC);

    if($userData['text'] == NULL || $userData['text'] == '')
    {
      echo "<p style='margin-left: 196px; display: block;'>Nothing to see here, yet</p>";
    }
    else
    {
      while ($row = $result->num_rows)
      {
        // die(stripslashes($userData['text']) . "<br style='clear:left;'><br>");
        echo stripslashes($userData['text']) . "<br style='clear:left;'><br>";
        break;
      }
    }
  }

  function valid_email($str) {
    return (!preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/", $str)) ? FALSE : TRUE;
  }

?>