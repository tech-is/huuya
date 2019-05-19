<?php
$page_name = "登録する";
include_once("core/core.php");

if(isset($_POST["url"])){
  $name = $mysqli->real_escape_string($_POST['name']);
  $url = $mysqli->real_escape_string($_POST['url']);
  $id = $mysqli->real_escape_string($_POST['id']);
  $pass = $mysqli->real_escape_string($_POST['password']);
  $decrypt_key = get_decrypt_key($mysqli,$_SESSION["pwmuser"]);
  $pass = openssl_encrypt($pass,'AES-128-ECB',$decrypt_key);
  insert_register_user(["username","name","url","login_id","password"],[$_SESSION["pwmuser"],$name,$url,$id,$pass],$mysqli);
  header('Location: index.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <?php require_once("inc/head.php"); ?>
  </head>
  <body>
    <div class="be-wrapper be-fixed-sidebar be-color-header">
      <?php require_once("parts/header-nav.php"); ?>
      <?php require_once("parts/left-side-bar.php"); ?>
      <div class="be-content">
        <div class="page-head">
          <h2 class="page-head-title"><?php echo $page_name; ?></h2>
        </div>
        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header card-header-divider">
                  <?php echo $page_name; ?>
                  <span class="card-subtitle">登録したいサービスのログイン情報を登録します。</span>
                </div>
                <div class="card-body">
                  <form method="post" action="">
                    <div class="form-group">
                      <label for="name">サービス名</label>
                      <input class="form-control" id="name" type="text" name="name" required="">
                    </div>
                    <div class="form-group">
                      <label for="url">URL</label>
                      <input class="form-control" id="url" type="text" name="url" required="">
                    </div>
                    <div class="form-group">
                      <label for="id">ログインID</label>
                      <input class="form-control" id="id" type="text" name="id" required="">
                    </div>
                    <div class="form-group">
                      <label for="password">ログインパスワード</label>
                      <input class="form-control" id="password" type="password" name="password" required="">
                    </div>
                    <div class="row pt-3">
                      <div class="col-sm-12">
                        <p class="text-right">
                          <button class="btn btn-space btn-primary" type="submit">登録</button>
                        </p>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once("inc/footer-script.php"); ?>
  </body>
</html>