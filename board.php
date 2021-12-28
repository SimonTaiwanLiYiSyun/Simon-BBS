<?php
  require_once 'header.php';

  if (!$loggedin) die("</body></html>");

  $result_3 = queryMysql("SELECT * FROM post WHERE department='$department' ORDER BY post_ID");

  $rows = $postData->num_rows;
  if($rows % 10 != 0) ? $pages = ($rows/10) + 1 : $pages = $rows/10;

  while($rows)
  {
    $postData = $result_3->fetch_array(MYSQLI_ASSOC);

    $post_name = $postData['post_name'];
	  $author_ID = $postData['user_ID'];
	  $post_link = "<a href='post.php?post_ID=$post_ID'>$post_name</a>";
    
    echo <<<_POST
      <table>
        <tbody>
          <tr>
            <td>$post_link</td>
          </tr>
        </tbody>
      </table>
    
      Pagination()??????

    _POST;
  }
?>