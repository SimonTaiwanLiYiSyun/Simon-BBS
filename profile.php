<?php
  require_once 'header.php';

  if (!$loggedin) die("</body></html>");

  echo "<h3>Your Profile</h3>";

  $query = "SELECT * FROM profiles WHERE user='$user'";
  $result_5 = queryMysql($query);
  if (isset($_POST['mail']))
  {
    $mail = santizeString($_POST['mail']);
    if(!valid_email('$mail')){
      echo "Invalid email address.";
    }

    if ($result_5->num_rows)
         queryMysql("UPDATE profiles SET mail='$mail' where user_ID='$user_ID'");
    else queryMysql("INSERT INTO profiles VALUES('$user', '$mail')");
  }
  else
  {
    if ($result_5->num_rows)
    {
      $row  = $result->fetch_array(MYSQLI_ASSOC);
      // $mail = stripslashes($row['mail']);
      $mail = $row['mail'];
    }
    else $mail = "";
  }

  // $mail = stripslashes(preg_replace('/\s\s+/', ' ', $mail));

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

  showProfile($user);

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
        action='profile.php?r=$randstr' enctype='multipart/form-data'>
        <h3>Enter or edit your details and/or upload an image</h3>
        <textarea name='mail'>$mail</textarea><br>
        Image: <input type='file' name='image' size='14'>
        <div>
          <input type="password" class="form__input" placeholder="Old Password" name="old_password" onBlur="checkPassword(this)">
          <div class="form__input-error-message" id="used"></div>
        </div>
        <div class="form__input-group">
          <input type="password" class="form__input" placeholder="Password" name="new_password">
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
?>