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

  if(isset($_POST['content']))
  {
    $post_name = santizeString($_POST['title']);
    $content = santizeString($_POST['content']);

    if($content != "")
    {
      $now = date('Y-m-d H:i:s', time());

      $query = "INSERT INTO post(user_ID, department, post_name, create_time, last_update, content) 
                VALUES('$user_ID', '$department', '$post_name', '$now', '$now', '$content')";
      queryMysql($query);
    }
  }

  echo <<<_END
      <form method='post' action='post.php'>
        <fieldset data-role="controlgroup" data-type="horizontal">
          <legend>Create Post</legend>
          <label>Post title:</label> <input type="text" name="title"><br>
          <label>Your Content:</label> <input type="text" name="content"><br>
        </fieldset>
      </form><br>
    </body>
  </html>
  _END;
?>