<?php
$page_name = "ログイン履歴";
include_once("core/core.php");
$user_info = get_user_info();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <?php require_once("inc/head.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/css/tableexport.min.css">
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
          <!--Start row-->
          <div class="row">
            <div class="col-lg-12">
              <div class="card card-table">
                <div class="card-header">現在のログイン情報</div>
                <div class="card-body">
                  <table class="table table-striped table-borderless">
                    <thead>
                      <tr>
                        <th>プラットフォーム</th>
                        <th>ブラウザ名</th>
                        <th>ブラウザバージョン</th>
                      </tr>
                    </thead>
                    <tbody class="no-border-x">
                      <tr>
                        <td><?php echo $user_info["platform"]; ?></td>
                        <td><?php echo $user_info["browser_name"]; ?></td>
                        <td><?php echo $user_info["browser_version"]; ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--End row-->
          <!--Start row-->
          <div class="row">
            <div class="col-lg-12">
              <div class="card card-table">
                <div class="card-header">ログイン情報</div>
                <div class="card-body">
                  <table class="table table-striped table-borderless" id="login-history">
                    <tbody class="no-border-x">
                      <tr>
                        <th>日付</th>
                        <th>時刻</th>
                        <th>プラットフォーム</th>
                        <th>ブラウザ名</th>
                        <th>ブラウザバージョン</th>
                      </tr>
                      <?php
                      $history = get_login_history($_SESSION["pwmuser"],$mysqli);
                      foreach($history as $val): ?>
                        <tr>
                          <td><?php echo $val[0]; ?></td>
                          <td><?php echo $val[1]; ?></td>
                          <td><?php echo $val[2]; ?></td>
                          <td><?php echo $val[3]; ?></td>
                          <td><?php echo $val[4]; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--End row-->
        </div>
      </div>
    </div>
    <?php require_once("inc/footer-script.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.1/xlsx.core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.2.0/js/tableexport.min.js"></script>
    <script>
      $(function(){
        $("table#login-history").tableExport({
          formats:["xlsx","csv"],
          bootstrap: true,
          filename: "PWM-ログイン履歴"
        });
      });
    </script>
  </body>
</html>