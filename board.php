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

  $result_3 = queryMysql("SELECT * FROM post WHERE department='$department' ORDER BY post_ID LIMIT $start_from, $limit");
  
  echo <<<_TABLESTART
        <table>
          <tbody>
  _TABLESTART;

  while($postData = $result_3->fetch_array(MYSQLI_ASSOC))
  {
    $post_name = $postData['post_name'];
	  $post_ID = $postData['post_ID'];
	  $post_link = "<a href='post.php?post_ID=$post_ID'>$post_name</a>";
    
    echo <<<_POST
          <tr>
            <td>$post_link</td>
          </tr>
    _POST;
  }

  echo <<<_TABLEEND
    </table>
      </tbody>
  _TABLEEND;

  // simple post pagination

  // advance post pagination https://www.geeksforgeeks.org/php-pagination-set-3/?ref=lbp

  $result_4 = queryMysql("SELECT * FROM post WHERE department='$department' ORDER BY post_ID");
  $rows = $result->num_rows; 
  $total_pages = ceil($rows / $limit);   // 無條件進位

  echo <<<_PAGINATIONSTART
        <ul class="pagination">
  _PAGINATIONSTART;

  $pageLink = "";

  for($i=1; $i<=$total_pages; $i++)
  {
    if($i == $pn)   // current page
    {
      $pageLink .= "<li class='active'><a href='board.php?page=" . $i ."'>".$i."</a></li>";
    }
    else
    {
      $pageLink .= "<li><a href='board.php?page=" . $i ."'>".$i."</a></li>";
    }
  }

  echo $pageLink;

  echo <<<_PAGINATIONEND
        </ul>
  _PAGINATIONEND;

  echo <<<_END
          </body>
        </html>
  _END;
?>