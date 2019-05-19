<?php
$page_name = "確認する";
include_once("core/core.php");
$info = get_register_user($_SESSION["pwmuser"],$mysqli);
$decrypt_key = get_decrypt_key($mysqli,$_SESSION["pwmuser"]);

if(isset($_POST["id"]) && isset($_POST["login_id"]) && isset($_POST["password"])){
  $id = $mysqli->real_escape_string($_POST['id']);
  $login_id = $mysqli->real_escape_string($_POST['login_id']);
  $password = $mysqli->real_escape_string($_POST['password']);
  $decrypt_key = get_decrypt_key($mysqli,$_SESSION["pwmuser"]);
  $password = openssl_encrypt($password,'AES-128-ECB',$decrypt_key);
  $data = [$id,$login_id,$password];
  update_register_user($data,$mysqli);
  header('Location: confirm.php');
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
          <?php foreach($info as $key => $val): ?>
            <?php if($key % 2 == 0): ?>
              <div class="row">
            <?php endif; ?>
            <div class="col-lg-6">
              <div class="card card-flat">
                <div class="card-header card-header-divider">
                  <a href="<?php echo $val[2]; ?>" target="_blank"><?php echo $val[1]; ?><span class="mdi mdi-open-in-new"></span></a>
                  <div class="tools dropdown">
                    <span class="icon mdi mdi-delete"></span>
                    <span class="<?php echo $val[0]; ?>"></span>
                  </div>
                </div>
                <div class="card-body">
                  <form method="post" action="">
                    <div class="form-group">
                      <h3>ID
                        <span class="mdi mdi-collection-item copy-btn" data-clipboard-target="#login-id-<?php echo $key; ?>"></span>
                      </h3>
                      <input class="form-control" type="text" name="login_id" value="<?php echo $val[3]; ?>" required="" read-only id="login-id-<?php echo $key; ?>">
                    </div>
                    <div class="form-group">
                      <h3>パスワード
                        <span class="mdi mdi-collection-item pw-cp-btn" id="<?php echo $val[0]; ?>"></span>
                        <span class="copy-btn" data-clipboard-target="#password-<?php echo $key; ?>"></span>
                      </h3>
                      <input class="form-control pw" type="password" name="password" value="●●●●●●●●●●●●" required="" read-only>
                      <input class="row-data" type="password" value="●●●●●●●●●●●●" id="password-<?php echo $key; ?>">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $val[0]; ?>">
                    <div class="row pt-3 submit-form">
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
            <?php if(($key - 1) % 2 == 0): ?>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php require_once("inc/footer-script.php"); ?>
    <script src="assets/js/splash.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.16/clipboard.min.js"></script>
    <script>
      $(function(){
        var clipboard = new Clipboard('.copy-btn');
        clipboard.on('success', function(e) { 
          splash("コピーしました");
        });
        $('.pw-cp-btn').on('click',function(){
          var index = $(this).attr("id");
          $.ajax({
            url:'./core/ajax.php',
            type:'POST',
            data:{
              'username':"<?php echo $_SESSION["pwmuser"]; ?>",
              'index':index,
              'get':true
            }
          })
          .done((data) => {
            $(this).parent().parent().find(".row-data").val(data);
            $(this).parent().find(".copy-btn").click();
          });
        });
        $('.form-control').on('click',function(){
          for(var i = 0;i < $(this).parent().parent().find(".form-group").length;i++){
            $(this).parent().parent().find(".form-group:eq("+i+") input.form-control").prop('read-only', false);
            if($(this).parent().parent().find(".form-group:eq("+i+") input.form-control").hasClass('pw')){
              $(this).parent().parent().find(".form-group:eq("+i+") input.form-control").val("");
            }
          }
          $(this).parent().parent().find(".submit-form").show();
        });
        $('.mdi-delete').on('click',function(){
          if(window.confirm('本当に削除してもよろしいですか？')){
            var index = $(this).parent().find("span:eq(1)").attr("class");
            $.ajax({
              url:'./core/ajax.php',
              type:'POST',
              data:{
                'username':"<?php echo $_SESSION["pwmuser"]; ?>",
                'index':index,
                'delete':true
              }
            })
            .done((data) => {
              location.reload();
            });
          }
        });
      });
    </script>
  </body>
</html>