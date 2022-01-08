<?php
  require_once 'header.php';

  if (!$loggedin) die("</body></html>");

  echo "<h2>Your Profile</h2>";

  $query = "SELECT * FROM profiles WHERE user_ID='$user_ID'";
  $result_5 = queryMysql($query);
  if (isset($_POST['mail']))
  {
    $mail = santizeString($_POST['mail']);
    if(!valid_email('$mail')){
      echo "Invalid email address.";
    }

    if ($result_5->num_rows)
         queryMysql("UPDATE profiles SET mail='$mail' where user_ID='$user_ID'");
    else queryMysql("INSERT INTO profiles VALUES('$user_ID', '$mail')");
  }
  else
  {
    if ($result_5->num_rows)
    {
      $row  = $result_5->fetch_array(MYSQLI_ASSOC);
      // $mail = stripslashes($row['mail']);
      $mail = $row['mail'];
    }
    else $mail = "";
  }

  if (isset($_POST['text']))
  {
    $text = santizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);

    if ($result_5->num_rows)
         queryMysql("UPDATE profiles SET text='$text' where user_ID='$user_ID'");
    else queryMysql("INSERT INTO profiles VALUES('$user_ID', '$text')");
  }
  else
  {
    if ($row['text'] == null)
    {
      $text = "";
    }
    else $text = stripslashes($row['text']);
  }

  $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

  if (isset($_POST['new_password']))
  {
    
    $new_password = santizeString($_POST['new_password']);
    if($new_password != '')
    {
      $query = "UPDATE user SET password = '$new_password' WHERE user_ID = '$user_ID'";
      queryMysql($query);

      $_SESSION['pass'] = $new_password;

      echo <<<_EOT
        <script>
          alert("Done.");
          window.history.go(-1);
        </script>		
      _EOT;
    }
    else
    {
      echo <<<_EOT
        <script>
          window.history.go(-1);
        </script>		
      _EOT;
    }
  }

  if (isset($_FILES['image']['name']))
  {
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  // Both regular and progressive jpegs
      case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }

    if ($typeok)
    {
      list($w, $h) = getimagesize($saveto);

      $max = 100;
      $tw  = $w;
      $th  = $h;

      if ($w > $h && $max < $w)
      {
        $th = $max / $w * $h;
        $tw = $max;
      }
      elseif ($h > $w && $max < $h)
      {
        $tw = $max / $h * $w;
        $th = $max;
      }
      elseif ($max < $w)
      {
        $tw = $th = $max;
      }

      $tmp = imagecreatetruecolor($tw, $th);
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
      imageconvolution($tmp, array(array(-1, -1, -1),
        array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
      imagejpeg($tmp, $saveto);
      imagedestroy($tmp);
      imagedestroy($src);
    }
  }

  showProfile($user_ID, $user);

  echo <<<_END
        <script>
          function checkPassword(password)
          {
            $.post
            (
              'checkpassword.php',
              { password : password.value },
              function(data)
              {
                $('#used').html(data)
              }
            )
          }
        </script> 
        

        <form data-ajax='false' method='post'
          action='profile.php?r=$randstr' enctype='multipart/form-data' class="main">
          <h3>Enter or edit your email, details and/or upload an image</h3>
          Email: <br><textarea name='mail'>$mail</textarea><br>
          Image: <br><input type='file' name='image' size='14'><br>
          Details: <br><textarea name='text'>$text</textarea><br>
          Change Password: <br>
          <div>
            <input type="password" class="form__input" placeholder="Old Password" name="old_password" onBlur="checkPassword(this)">
            <div class="form__input-error-message" id="used"></div>
          </div>
          <div class="form__input-group">
            <input type="password" id="newPassword" class="form__input" placeholder="Password" name="new_password">
            <!--<div class="form__input-error-message"></div>-->
          </div>
          <div class="form__input-group">
            <input type="password" id="confirmPassword" class="form__input" placeholder="Confirm Password">
            <div class="form__input-error-message"></div>
          </div>
        <input type='submit' value='Save Profile'><br>
        </form>
      </div><br>
      <script src="src/profile.js"></script>
    </body>
  </html>
  _END;

  unset($result_5);
?>
