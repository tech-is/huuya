<?php

include_once("config/config.php");

//DBとの接続処理
function connect_db($host,$username,$password,$dbname){
	$mysqli = new mysqli($host, $username, $password, $dbname);
	if ($mysqli->connect_error) {
		error_log($mysqli->connect_error);
		exit;
	}
	return $mysqli;
}

//新規登録
function insert_register($name,$data,$mysqli){
	$query = "INSERT INTO user(".implode(",",$name).") VALUES('".implode("','",$data)."')";
	$mysqli->query($query);
	header('Location: login.php');
	exit;
}

//情報登録
function insert_register_user($name,$data,$mysqli){
	$query = "INSERT INTO register_user(".implode(",",$name).") VALUES('".implode("','",$data)."')";
	$mysqli->query($query);
}

//パスワードの変更	
function update_user($name,$data,$mysqli){
	$query = 'UPDATE user SET password="'.$data.'" WHERE username="'.$name.'"';
	$mysqli->query($query);
    header('Location: index.php');
    exit;
}

//decrypt_keyを取得する
function get_decrypt_key($mysqli,$name){
	$query = 'SELECT * FROM user WHERE username="'.$name.'"';
	$result = $mysqli->query($query);
  	if(!$result){
    	$mysqli->close();
    	exit();
  	}
  	while($row = $result->fetch_assoc()){
    	$decrypt_key = $row['decrypt_key'];
  	}
  	$result->close();
  	return $decrypt_key;
}

function start_panel($array){
  foreach($array as $key => $val){
    if($key % 2 == 0){
      echo '<div class="row">';
    }
    require("parts/start-panel.php");
    if(($key - 1) % 2 == 0){
      echo '</div>';
    }
  }
}

function get_row_data($index,$decrypt_key,$mysqli){
  $query = 'SELECT * FROM register_user WHERE id="'.$index.'"';
  $result = $mysqli->query($query);
    if(!$result){
      $mysqli->close();
      exit();
    }
    $i = 0;
    while($row = $result->fetch_assoc()){
      $row_data = $row['password'];
    }
    $result->close();
    return row_decrypt($decrypt_key,$row_data);
}

function logined($username,$mysqli){
	$user_info = get_user_info();
	date_default_timezone_set('Asia/Tokyo');
	$date = date("Y年m月d日");
	$time = date("H時i分s秒");
	$name = ["username","date","time","platform","browser_name","browser_version"];
	$data = [$username,$date,$time,$user_info["platform"],$user_info["browser_name"],$user_info["browser_version"]];
	$query = "INSERT INTO login_history(".implode(",",$name).") VALUES('".implode("','",$data)."')";
	$mysqli->query($query);
}

function get_login_history($username,$mysqli){
	$history = [];
	$query = 'SELECT * FROM login_history WHERE username="'.$username.'"';
	$result = $mysqli->query($query);
  	if(!$result){
    	$mysqli->close();
    	exit();
  	}
  	$i = 0;
  	while($row = $result->fetch_assoc()){
  		$history[$i][] = $row['date'];
  		$history[$i][] = $row['time'];
  		$history[$i][] = $row['platform'];
  		$history[$i][] = $row['browser_name'];
  		$history[$i][] = $row['browser_version'];
    	$i++;
  	}
  	$result->close();
  	return array_reverse($history);
}

function get_register_user($username,$mysqli){
	$info = [];
	$query = 'SELECT * FROM register_user WHERE username="'.$username.'"';
	$result = $mysqli->query($query);
  	if(!$result){
    	$mysqli->close();
    	exit();
  	}
  	$i = 0;
  	while($row = $result->fetch_assoc()){
  		$info[$i][] = $row['id'];
  		$info[$i][] = $row['name'];
  		$info[$i][] = $row['url'];
  		$info[$i][] = $row['login_id'];
  		$info[$i][] = $row['password'];
    	$i++;
  	}
  	$result->close();
  	return array_reverse($info);
}

function update_register_user($data,$mysqli){
	$name = ["login_id","password"];
	foreach($name as $key => $val){
		$query = 'UPDATE register_user SET '.$val.'="'.$data[$key+1].'" WHERE id="'.$data[0].'"';
		$mysqli->query($query);
	}
}

function delete_register_user($username,$index,$mysqli){
	$query = 'DELETE FROM register_user WHERE id="'.$index.'"';
	$mysqli->query($query);
}

function get_user_info(){
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $browser_name = $browser_version = $platform = NULL;
    
    //Browser
    if(preg_match('/Edge/i', $ua)){
      	$browser_name = 'Edge';
      	if(preg_match('/Edge\/([0-9.]*/', $ua, $match)){
      	  $browser_version = $match[1]; 
      	}
    }elseif(preg_match('/(MSIE|Trident)/i', $ua)){
      	$browser_name = 'IE';
      	if(preg_match('/MSIE\s([0-9.]*)/', $ua, $match)){
      	  $browser_version = $match[1];
      	}elseif(preg_match('/Trident\/7/', $ua, $match)){
      	  $browser_version = 11;
      	}
    }elseif(preg_match('/Presto|OPR|OPiOS/i', $ua)){
      	$browser_name = 'Opera';
      	if(preg_match('/(Opera|OPR|OPiOS)\/([0-9.]*)/', $ua, $match)) $browser_version = $match[2];
    }elseif(preg_match('/Firefox/i', $ua)){
      	$browser_name = 'Firefox';
      	if(preg_match('/Firefox\/([0-9.]*)/', $ua, $match)) $browser_version = $match[1];
    }elseif(preg_match('/Chrome|CriOS/i', $ua)){
      	$browser_name = 'Chrome';
      	if(preg_match('/(Chrome|CriOS)\/([0-9.]*)/', $ua, $match)) $browser_version = $match[2];
    }elseif(preg_match('/Safari/i', $ua)){
      	$browser_name = 'Safari';
      	if(preg_match('/Version\/([0-9.]*)/', $ua, $match)) $browser_version = $match[1];
    }else{
    	$browser_name = '不明';
    	$browser_version = '不明';
    }
    
    //Platform
    if(preg_match('/ipod/i', $ua)){
      	$platform = 'iPod';
    }elseif(preg_match('/iphone/i', $ua)){
      	$platform = 'iPhone';
    }elseif(preg_match('/ipad/i', $ua)){
      	$platform = 'iPad';
    }elseif(preg_match('/android/i', $ua)){
      	$platform = 'Android';
    }elseif(preg_match('/windows phone/i', $ua)){
      	$platform = 'Windows Phone';
    }elseif(preg_match('/linux/i', $ua)){
      	$platform = 'Linux';
    }elseif(preg_match('/macintosh|mac os/i', $ua)) {
      	$platform = 'Mac';
    }elseif(preg_match('/windows/i', $ua)){
      	$platform = 'Windows';
    }else{
    	$platform = '不明';
    }
    
    return array(
      	'browser_name' => $browser_name,
      	'browser_version' => intval($browser_version),
      	'platform' => $platform
    );
}

function row_decrypt($decrypt_key,$val){
	return openssl_decrypt($val, 'AES-128-ECB', $decrypt_key);
}