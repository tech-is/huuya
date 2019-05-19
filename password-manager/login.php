<?php
session_start();
if(isset($_SESSION["pwmuser"])){
  header('Location: index.php');
}

include_once("core/functions.php");

//MYSQLに接続する
$mysqli = connect_db($host,$username,$password,$dbname);

if(!$mysqli->query('SELECT 1 FROM user LIMIT 1')){
  header('Location: sign-up.php');
}

$page_name = "ログイン";

if(isset($_POST['username'])){
  $username = $mysqli->real_escape_string($_POST['username']);
  $password = $mysqli->real_escape_string($_POST['password']);

  $query = "SELECT * FROM user WHERE username='$username'";
  $result = $mysqli->query($query);

  if(!$result){
    $mysqli->close();
    exit();
  }

  while($row = $result->fetch_assoc()){
    $db_username = $row['username'];
    $db_password = $row['password'];
  }

  $result->close();

  if($username == $db_username && password_verify($password,$db_password)){
    $_SESSION["pwmuser"] = $username;
    $_SESSION["login"] = true;
    header("Location: index.php");
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <?php include("inc/head.php"); ?>
  </head>
  <body class="be-splash-screen">
    <div class="be-wrapper be-login">
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="splash-container">
            <div class="card card-border-color card-border-color-primary">
              <div class="card-header">
                <h2>PWM</h2>
              </div>
              <div class="card-body">
                <form method="post" action="">
                  <span class="splash-title pb-4">ログイン</span>
                  <div class="form-group">
                    <input class="form-control" id="username" name="username" type="text" placeholder="ユーザー名">
                  </div>
                  <div class="form-group">
                    <input class="form-control" id="password" name="password" type="password" placeholder="パスワード">
                  </div>
                  <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary btn-xl" type="submit">ログイン</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="splash-footer">
              <span>
                アカウントを持っていないですか? <a href="sign-up.php">新規登録</a>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include("inc/footer-script.php"); ?>
  </body>
</html>