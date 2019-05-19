<?php
$page_name = "設定";
include_once("core/core.php");
if(isset($_POST['pass1'])){
  $pass1 = $mysqli->real_escape_string($_POST['pass1']);
  $pass2 = $mysqli->real_escape_string($_POST['pass2']);
  $pass3 = $mysqli->real_escape_string($_POST['pass3']);

  $query = "SELECT * FROM user WHERE username='".$_SESSION["user"]."'";
  $result = $mysqli->query($query);

  if(!$result){
    $mysqli->close();
    exit();
  }

  while($row = $result->fetch_assoc()){
    $db_password = $row['password'];
  }

  $result->close();

  if(password_verify($pass1,$db_password) && $pass2 == $pass3){
    $password = password_hash($pass2,PASSWORD_DEFAULT);
    update_user($_SESSION["user"],$password,$mysqli);
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <?php include("inc/head.php"); ?>
  </head>
  <body>
    <div class="be-wrapper be-fixed-sidebar be-color-header">
      <?php include_once("parts/header-nav.php"); ?>
      <?php include_once("parts/left-side-bar.php"); ?>
      <div class="be-content">
        <div class="main-content container-fluid">
          <!--Main Start-->
          <h2 class="page-head-title"><?php echo $page_name; ?></h2>
          <div class="row">
            <!--col-md-6 Start-->
            <div class="col-md-6">
              <div class="card card-border-color card-border-color-primary">
                <div class="card-header">パスワードの変更</div>
                <div class="card-body">
                  <form method="post" action="">
                    <div class="form-group">
                      <label for="pass1">以前のパスワード</label>
                      <input class="form-control" id="pass1" type="password" name="pass1" required="">
                    </div>
                    <div class="form-group">
                      <label for="pass2">新しいパスワード</label>
                      <input class="form-control" id="pass2" type="password" name="pass2" required="">
                    </div>
                    <div class="form-group">
                      <label for="pass3">新しいパスワードの確認</label>
                      <input class="form-control" id="pass3" type="password" name="pass3" required="">
                    </div>
                    <div class="row pt-3">
                      <div class="col-sm-12">
                        <p class="text-right">
                          <button class="btn btn-space btn-primary" type="submit">更新</button>
                        </p>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!--col-md-6 End-->
          </div>
          <!--Main End-->
        </div>
      </div>
    </div>
    <?php include("inc/footer-script.php"); ?>
  </body>
</html>