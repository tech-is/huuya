<?php
include_once("../config/config.php");
include_once("functions.php");

//MYSQLに接続する
$mysqli = connect_db($host,$username,$password,$dbname);

if(isset($_POST["username"]) && isset($_POST["index"]) && isset($_POST["get"])){
	$username = htmlspecialchars($_POST["username"]);
	$index = htmlspecialchars($_POST["index"]);
	$decrypt_key = get_decrypt_key($mysqli,$username);
	echo get_row_data($index,$decrypt_key,$mysqli);
}

if(isset($_POST["username"]) && isset($_POST["index"]) && isset($_POST["delete"])){
	$username = htmlspecialchars($_POST["username"]);
	$index = htmlspecialchars($_POST["index"]);
	delete_register_user($username,$index,$mysqli);
}