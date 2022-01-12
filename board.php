<?php
  require_once 'header.php';

  if (!$loggedin) die("</body></html>");

  $limit = 10;

  if (isset($_GET["page"])) { 
    $pn  = $_GET["page"]; 
  } 
  else { 
    $pn=1; 
  }; 

  $start_from = ($pn-1) * $limit;  

  $result_3 = queryMysql("SELECT * FROM post WHERE department='$department' ORDER BY post_ID DESC LIMIT $start_from, $limit");
  
  echo <<<_TABLESTART
        <h2>Post</h2>
        <table class="main">
          <tbody>
  _TABLESTART;

  while($postData = $result_3->fetch_array(MYSQLI_ASSOC))
  {
    $post_name = $postData['post_name'];
	  $post_ID = $postData['post_ID'];
	  $post_link = "<a href='show_post.php?post_ID=$post_ID'>$post_name</a>";
    
    echo <<<_POST
          <tr>
            <td>$post_link</td>
          </tr>
    _POST;
  }

  echo <<<_TABLEEND
      </tbody>
    </table>
  _TABLEEND;

  // simple post pagination

  // advance post pagination https://www.geeksforgeeks.org/php-pagination-set-3/?ref=lbp

  $result_4 = queryMysql("SELECT * FROM post WHERE department='$department' ORDER BY post_ID");
  $rows = $result_4->num_rows; 
  $total_pages = ceil($rows / $limit);   // 無條件進位

  echo <<<_PAGINATIONSTART
        <div class="pagination">
  _PAGINATIONSTART;

  $pageLink = "";

  for($i=1; $i<=$total_pages; $i++)
  {
    if($i == $pn)   // current page
    {
      $pageLink .= "<a class='active' href='board.php?page=" . $i ."'>".$i."</a>";
    }
    else
    {
      $pageLink .= "<a href='board.php?page=" . $i ."'>".$i."</a>";
    }
  }

  echo $pageLink;

  echo <<<_PAGINATIONEND
        </div>
  _PAGINATIONEND;

  echo <<<_END
          </body>
        </html>
  _END;

  unset($result_6, $result_4);
?>