<?php
  require_once 'header.php';

  if(isset($_GET['post_ID']))
  {
    $post_ID = santizeString($_GET['post_ID']);

    $query = "SELECT * FROM post WHERE post_ID=$post_ID";
    $result = queryMysql($query);

    $postData = $result->fetch_array(MYSQLI_ASSOC);
    $postName = $postData['post_name'];
    $postContent = $postData['content'];
  }

  echo <<<_END
      <div class="main">
        <article>
          <h3>Title: $postName</h3>
          Content:<br>
          <p>$postContent</p>
        </article>
      </div>
    </body></html>
  _END;

  unset($result);
?>