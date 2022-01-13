<?php

    require_once 'functions.php';
    session_start();
    $error = $user = $pass = '';

    if(isset($_POST['user']))
    {
        $user = santizeString($_POST['user']);
        $pass = santizeString($_POST['pass']);

        if($user == '' || $pass == '')
        {
            $error = 'Not all fields were entered';
            // echo "Not all fields were entered";
        }
        else
        {
            $result = queryMysql("SELECT username,password FROM user
                Where username='$user' AND password='$pass'");

            if($result->num_rows == 0)
            {
                $error = "Invalid login attempt";
            }
            else
            {
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                header("Location: ./board.php");
            }
        }
    }
    elseif(isset($_POST['r_user']))
    {
        $r_user = santizeString($_POST['r_user']);
        $r_pass = santizeString($_POST['r_pass']);
        $now = date('Y-m-d H:i:s', time());

        $result = queryMysql("SELECT * FROM user WHERE username='$r_user'");

        if($result->num_rows)
        {
            $error = "The username '$r_user' is already exists.";
        }
        else
        {
            $query = "INSERT INTO user(username, password, default_permission, registeration_time)
                        VALUES ('$r_user', '$r_pass', '0', '$now')";
            queryMysql($query);
            echo '<script>
                alert("Signup success."); 
                setTimeout(() => {}, 5000); 
                window.location.href="./index.php";
            </script>';
        }
    }

echo <<<_END
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1">
        <meta charset="utf-8">
        <title>Login / Sign Up</title>
        <link rel="stylesheet" type="text/css" href="src/index.css">
        <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    </head>

    <script>
    function checkUser(user)
    {
      $.post
      (
        'checkuser.php',
        { r_user : user.value },
        function(data)
        {
          $('#used').html(data)
        }
      )
    }
  </script> 

    <body>
        <div class="container">
            <!--Register form.-->
            <form class="form" id="login" method="POST" action="index.php">
                <h1 class="form__title">Login</h1>
                <div class="form__message form__message--error" id="inputError">$error</div>
                <div class="form__input-group">
                    <input type="text" autofocus class="form__input" placeholder="Username or Email" name="user">
                    <div class="form__input-error-message"></div>
                </div>
                <div class="form__input-group">
                    <input type="password" autofocus class="form__input" placeholder="Password" name="pass">
                    <div class="form__input-error-message"></div>
                </div>
                <button class="form__button" type="submit">Continue</button>
                <p class="form__text">
                    <a href="#" class="form__link">Forgot your password?</a>
                </p>
                <p class="form__text">
                    <a id="linkCreateAccount" href="./" class="form__link">Don't have an account? Create an account.</a>
                </p>
            </form>
            <!--Sign up form.-->
            <form class="form form--hidden" id="createAccount" method="POST" action="index.php">
                <h1 class="form__title">Create Account</h1>
                <div class="form__message form__message--error"></div>
                <div class="form__input-group">
                    <input type="text" id="signupUsername" autofocus class="form__input" placeholder="Username" name="r_user" value='$user' onBlur="checkUser(this)">
                    <div class="form__input-error-message" id="used"></div>
                </div>
                <div class="form__input-group">
                    <input type="mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" autofocus class="form__input" placeholder="Email Address" name="r_mail">
                    <div class="form__input-error-message"></div>
                </div>
                <div class="form__input-group">
                    <input type="password" id="signupPassword" autofocus class="form__input" placeholder="Password" name="r_pass">
                    <!--<div class="form__input-error-message"></div>-->
                </div>
                <div class="form__input-group">
                    <input type="password" id="confirmPassword" autofocus class="form__input" placeholder="Confirm Password">
                    <div class="form__input-error-message"></div>
                </div>
                <button class="form__button" type="submit">Continue</button>
                <p class="form__text">
                    <a id="linkLogin" href="./" class="form__link">Already have an account? Sign in.</a>
                </p>
            </form>
        </div>
        <script src="src/index.js"></script>
    </body>
</html>
_END;

unset($result);
?>