# Password Manager
[![a]]
## Description
大まかなツールの概要を[こちら](https://docs.google.com/presentation/d/1KZi7R2r1dczK77msYR_nRHUg3sEn50ZVAo6vBDGhH14/edit?usp=sharing)のGoogleスライドにまとめている。

## Environment
- Mac OS(Ver 10.14.4)
- Mamp(Ver 5.0.1)
- Web Server(Apache)
- PHP(Ver 7.2.7)
- MySQL(Ver 5.7.21)

## How To Use
*config/config.php*にデータベースへの接続情報を記述するのみで利用可能。必要なテーブルは自動で作成される。

## Directory
```
.
├── assets //メディアファイル
│   ├── css
│   │   └── style.css
│   ├── img
│   ├── js
│   └── lib
├── config
│   └── config.php //DB接続情報の記述ファイル
├── confirm.php //登録情報の閲覧ファイル
├── core
│   ├── ajax.php //ajax経由のリクエストを捌くファイル
│   ├── core.php
│   └── functions.php //関数ファイル
├── inc
│   ├── footer-script.php //footerでのjsファイル読み込みファイル
│   └── head.php //headタグ内の読み込み関連ファイル
├── index.php //ログイン後トップページ
├── login-history.php //ログイン履歴の確認ファイル
├── login.php //ログインページ
├── parts
│   ├── header-nav.php //ヘッダーナビゲーション
│   ├── left-side-bar.php //左メニュー
│   └── start-panel.php //スタートパネル用のパーツ
├── register.php //ログイン情報登録ページ
├── settings.php //設定ページ
├── sign-out.php //ログアウトファイル
└── sign-up.php //ユーザー登録ページ
```

## Secure
ユーザー登録を行う際（sign-up.php）に、ランダムな25文字の鍵を作成しており、その鍵を元にログイン情報の暗号化・復号化を行っている。尚ユーザーごとに鍵情報は異なる。

## Period
開発期間は２日弱。

## Review
アジャイル開発となったため、コードが殴り書きになっている箇所が見受けられるかもしれない。最低限の抽象化とセキュアを意識した。