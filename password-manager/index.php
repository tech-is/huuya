<?php
$page_name = "ホーム";
include_once("core/core.php");
if(isset($_SESSION["login"])){
  unset($_SESSION["login"]);
  logined($_SESSION["pwmuser"],$mysqli);
}
$array = [
  ["-primary","register.php","登録する","登録したいサービスのログイン情報を登録します。"],
  ["-success","confirm.php","確認する","登録したサービスのログイン情報の確認・変更をします。"],
  ["-warning","login-history.php","ログイン履歴","PASSWORD Managerにログインした履歴を確認できます。"],
  ["","settings.php","設定","PASSWORD Managerのログイン情報を変更できます。"]
];
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
          <?php start_panel($array); ?>
        </div>
      </div>
    </div>
    <?php require_once("inc/footer-script.php"); ?>
  </body>
</html>