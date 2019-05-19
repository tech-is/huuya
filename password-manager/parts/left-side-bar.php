<div class="be-left-sidebar">
  <div class="left-sidebar-wrapper">
    <a class="left-sidebar-toggle" href="#"><?php echo $page_name; ?></a>
    <div class="left-sidebar-spacer">
      <div class="left-sidebar-scroll">
        <div class="left-sidebar-content">
          <ul class="sidebar-elements">
            <li class="divider">Menu</li>
            <li<?php if($page_name == "ホーム"){echo ' class="active"';} ?>>
              <a href="index.php">
                <i class="icon mdi mdi-home"></i>
                <span>ホーム</span>
              </a>
            </li>
            <li<?php if($page_name == "登録する"){echo ' class="active"';} ?>>
              <a href="register.php">
                <i class="icon mdi mdi-account-add"></i>
                <span>登録</span>
              </a>
            </li>
            <li<?php if($page_name == "確認する"){echo ' class="active"';} ?>>
              <a href="confirm.php">
                <i class="icon mdi mdi-eye"></i>
                <span>確認</span>
              </a>
            </li>
            <li<?php if($page_name == "ログイン履歴"){echo ' class="active"';} ?>>
              <a href="login-history.php">
                <i class="icon mdi mdi-assignment"></i>
                <span>ログイン履歴</span>
              </a>
            </li>
            <li<?php if($page_name == "設定"){echo ' class="active"';} ?>>
              <a href="settings.php">
                <i class="icon mdi mdi-settings"></i>
                <span>設定</span>
              </a>
            </li>
            <li>
              <a href="sign-out.php">
                <i class="icon mdi mdi-power"></i>
                <span>ログアウト</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>