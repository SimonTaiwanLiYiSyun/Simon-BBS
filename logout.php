<?php // Example 12: logout.php
  require_once 'header.php';

  if (isset($_SESSION['user']))
  {
    destorySession();

    echo '<script>
      alert("Logging out...."); 
      setTimeout(() => {}, 5000); 
      window.location.href="./index.php";
    </script>';
  }
  else echo '<script>
        alert("You cannot log out because
                you are not logged in"); 
        setTimeout(() => {}, 5000); 
        window.location.href="./index.php";
      </script>
      </div>
  </body>
</html>';
  echo "<div class='center'>You cannot log out because
             you are not logged in</div>
          </div>
          </body>
        </html>";
?>
    
