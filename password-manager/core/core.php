<?php
session_start();

if(!isset($_SESSION["pwmuser"])){
  header('Location: login.php');
}

include_once("functions.php");

//MYSQLに接続する
$mysqli = connect_db($host,$username,$password,$dbname);