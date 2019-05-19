<?php
session_start();
if(isset($_SESSION["pwmuser"])){
  header('Location: index.php');
}

include_once("core/functions.php");

//MYSQLに接続する
$mysqli = connect_db($host,$username,$password,$dbname);

$page_name = "新規登録";

if(isset($_POST['name'])){
  $name = $mysqli->real_escape_string($_POST['name']);
  $pass1 = $mysqli->real_escape_string($_POST['pass1']);
  $pass2 = $mysqli->real_escape_string($_POST['pass2']);
  $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPUQRSTUVWXYZ';
  $key = substr(str_shuffle($str),0,25);
  if($pass1 == $pass2){
    $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
    if($mysqli->query('SELECT 1 FROM user LIMIT 1')){
      if($mysqli->query('SELECT COUNT(*) FROM user WHERE username="'.$name.'"')->fetch_assoc()["COUNT(*)"] == "0"){
        insert_register(["username","password","decrypt_key"],[$name,$pass1,$key],$mysqli);
      }
    }else{
      $query = "create table user(username varchar(255),password varchar(100),decrypt_key varchar(200))";
      $mysqli->query($query);
      $query = "create table register_user(id mediumint not null auto_increment,username varchar(50),name varchar(50),url varchar(50),login_id varchar(100),password varchar(100),primary key(id))";
      $mysqli->query($query);
      $query = "create table login_history(username varchar(50),date varchar(20),time varchar(20),platform varchar(20),browser_name varchar(20),browser_version int(20))";
      $mysqli->query($query);
      insert_register(["username","password","decrypt_key"],[$name,$pass1,$key],$mysqli);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <?php include("inc/head.php"); ?>
  </head>
  <body class="be-splash-screen">
    <div class="be-wrapper be-login be-signup">
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="splash-container sign-up">
            <div class="card card-border-color card-border-color-primary">
              <div class="card-header">
                <h2>PWM</h2>
              </div>
              <div class="card-body">
                <form method="post" action="">
                  <span class="splash-title pb-4">新規登録</span>
                  <div class="form-group">
                    <input class="form-control" type="text" name="name" required="" placeholder="ユーザー名" autocomplete="off" pattern="^[0-9a-z]+$">
                  </div>
                  <div class="form-group row signup-password">
                    <div class="col-6">
                      <input class="form-control" id="pass1" name="pass1" type="password" required="" placeholder="パスワード">
                    </div>
                    <div class="col-6">
                      <input class="form-control" id="pass2" name="pass2" type="password" required="" placeholder="パスワードの確認">
                    </div>
                  </div>
                  <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary btn-xl" type="submit">新規登録</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="splash-footer">&copy; 2019</div>
          </div>
        </div>
      </div>
    </div>
    <?php include("inc/footer-script.php"); ?>
  </body>
</html>