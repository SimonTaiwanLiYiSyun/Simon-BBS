<!DOCTYPE html>
<html>
<meta charset="utf-8">
  <head>
    <title>Setting Up BBS database.</title>
  </head>

  <body>
    <h3>
      Setting Up Simon BBS...
    </h3>
    <?php
      require_once 'functions.php';

      createTable('user', 
                  'user_ID INT NOT NULL AUTO_INCREMENT, 
                  username VARCHAR(16) NOT NULL, 
                  password VARCHAR(16) NOT NULL, 
                  default_permission TINYINT NOT NULL, 
                  registeration_time DATETIME NOT NULL, 

                  UNIQUE(username), 
                  PRIMARY KEY (user_ID), 
                  UNIQUE INDEX (username, password)');
                  /*
                  * +--------------------+-------------+------+-----+---------+----------------+
                  * | Field              | Type        | Null | Key | Default | Extra          |
                  * +--------------------+-------------+------+-----+---------+----------------+
                  * | user_ID            | int         | NO   | PRI | NULL    | auto_increment |
                  * | username           | varchar(16) | NO   | UNI | NULL    |                |
                  * | password           | varchar(16) | NO   |     | NULL    |                |
                  * | default_permission | tinyint     | NO   |     | NULL    |                |
                  * | registeration_time | datetime    | NO   |     | NULL    |                |
                  * +--------------------+-------------+------+-----+---------+----------------+
                  */
      createTable('board', 
                  'board_ID TINYINT NOT NULL AUTO_INCREMENT, 
                  board_name VARCHAR(16) NOT NULL, 
                  
                  PRIMARY KEY (board_ID), 
                  UNIQUE(board_name)');
                  /*
                  * +------------+-------------+------+-----+---------+----------------+
                  * | Field      | Type        | Null | Key | Default | Extra          |
                  * +------------+-------------+------+-----+---------+----------------+
                  * | board_ID   | tinyint     | NO   | PRI | NULL    | auto_increment |
                  * | board_name | varchar(16) | NO   | UNI | NULL    |                |
                  * +------------+-------------+------+-----+---------+----------------+
                  */
      createTable('post', 
                  'post_ID INT NOT NULL AUTO_INCREMENT, 
                  user_ID INT NOT NULL, 
                  board_ID TINYINT NOT NULL, 
                  post_name VARCHAR(50), 
                  create_time DATETIME NOT NULL, 
                  last_update DATETIME NOT NULL, 
                  content TEXT NOT NULL, 
                  
                  PRIMARY KEY (post_ID), 
                  FOREIGN KEY (user_ID) REFERENCES user(user_ID),
                  FOREIGN KEY (board_ID) REFERENCES board(board_ID)');
                  /*
                  * +-------------+-------------+------+-----+---------+----------------+
                  * | Field       | Type        | Null | Key | Default | Extra          |
                  * +-------------+-------------+------+-----+---------+----------------+
                  * | post_ID     | int         | NO   | PRI | NULL    | auto_increment |
                  * | user_ID     | int         | NO   | MUL | NULL    |                |
                  * | board_ID    | tinyint     | NO   | MUL | NULL    |                |
                  * | post_name   | varchar(50) | YES  |     | NULL    |                |
                  * | create_time | datetime    | NO   |     | NULL    |                |
                  * | last_update | datetime    | NO   |     | NULL    |                |
                  * | content     | text        | NO   |     | NULL    |                |
                  * +-------------+-------------+------+-----+---------+----------------+
                  */
      createTable('profiles', 
                  'user_ID INT NOT NULL, 
                  department VARCHAR(16) NOT NULL, 
                  mail VARCHAR(64), 
                  text VARCHAR(2048), 
                  
                  PRIMARY KEY (user_ID), 
                  FOREIGN KEY (user_ID) REFERENCES user(user_ID), 
                  UNIQUE (mail), 
                  INDEX (department)');
                  /*
                  * +------------+---------------+------+-----+---------+-------+
                  * | Field      | Type          | Null | Key | Default | Extra |
                  * +------------+---------------+------+-----+---------+-------+
                  * | user_ID    | int           | NO   | PRI | NULL    |       |
                  * | department | varchar(16)   | NO   | MUL | NULL    |       |
                  * | mail       | varchar(64)   | YES  | UNI | NULL    |       |
                  * | text       | varchar(2048) | YES  |     | NULL    |       |
                  * +------------+---------------+------+-----+---------+-------+
                  */
      createTable('rule', 
                  'user_ID INT NOT NULL, 
                  board_ID TINYINT NOT NULL, 
                  department VARCHAR(16) NOT NULL,
                  permission TINYINT NOT NULL, 
                  
                  PRIMARY KEY (user_ID, board_ID), 
                  INDEX (department), 
                  FOREIGN KEY (user_ID) REFERENCES user(user_ID), 
                  FOREIGN KEY (department) REFERENCES profiles(department), 
                  FOREIGN KEY (board_ID) REFERENCES board(board_ID)');
                  /*
                  * +------------+-------------+------+-----+---------+-------+
                  * | Field      | Type        | Null | Key | Default | Extra |
                  * +------------+-------------+------+-----+---------+-------+
                  * | user_ID    | int         | NO   | PRI | NULL    |       |
                  * | board_ID   | tinyint     | NO   | PRI | NULL    |       |
                  * | department | varchar(16) | NO   | MUL | NULL    |       |
                  * | permission | tinyint     | NO   |     | NULL    |       |
                  * +------------+-------------+------+-----+---------+-------+
                  */
    ?>
    <br><br>
    <br>...done.
    <?php
      header("Location: ./index.php");
    ?>
  </body>
</html>