<?php
function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function login(){
        include_once("view/login.html");
}
function portfolio(){
        include_once("view/pildivorm.html");
}
function regvorm(){
        include_once("view/regvorm.html");
}
function signup(){
        include_once("view/signup.html");
}
function kontakt(){
        include_once("view/contact.html");
}
function tellimus(){
        include_once("view/tellimused.html");
}
function logout(){
        session_destroy();
		header("Location: ?");
}
function auth(){
	global $connection;
	
	if ($_SERVER['REQUEST_METHOD']=='GET'){
		include_once('views/login.html');
	}
	if (empty($_POST['username']) || empty($_POST['passwd'])){
		$errors[]= "Kasutajanimi/Parool puudu!";
		include_once('views/login.html');
	}
	if ($_SERVER['REQUEST_METHOD']=="POST"){
		if (isset($_POST['username']) && isset($_POST['passwd'])){
			$kasutaja =  mysqli_real_escape_string($connection,htmlspecialchars($_POST['username']));
			$parool = mysqli_real_escape_string($connection,htmlspecialchars($_POST['passwd']));
			$sql = "SELECT * FROM 12103979_kylastajad WHERE username='$kasutaja' AND passw=SHA1('$parool')";
			$result = mysqli_query($connection, $sql);
			if (mysqli_num_rows($result) >= 1){
				$_SESSION['username'] = mysqli_fetch_assoc($result);
				header("Location: ?page=tellimus");
			}else{
				$errors[]= "Kasutajat ei eksisteeri!";
				include_once('views/login.html');
			}
		}
	}
}
?>