<?php
ini_set("display_errors", 1);
$errors=array();

function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa �hendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function login(){
	global $connection;
	global $errors;
	
	if (!empty($_SESSION['username'])){
		header("Location: ?");	
	}
	if ($_SERVER['REQUEST_METHOD']=='GET'){
		include_once('view/login.html');
	}
	
	if (empty($_POST['username']) || empty($_POST['passwd'])){
		$errors[]= "Kasutajanimi/Parool puudu!";
		include_once('view/login.html');
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
				include_once('view/login.html');
			}
		}
	}
}

function portfolio(){
        include_once("view/pildivorm.html");
}
function pakkumine(){
    global $connection;
	global $errors;
		$name="";
		$phone="";
		$saun="Soome saun";
		$price="";
		$description="";
		if ($_SERVER['REQUEST_METHOD']=='GET'){
			include_once('view/pakkumine.html');
		}
		if ($_SERVER['REQUEST_METHOD']=='POST'){
			if (empty($_POST["name"])){
				$errors[]= "Nimi puudu!";
			}else{
				$name =  htmlspecialchars($_POST['name']);
			}
			if (empty($_POST["phone"])){
				$errors[]= "Telefoni number puudu!";
			}else{
				$phone =  htmlspecialchars($_POST['phone']);
			}
			if (empty($_POST["saun"])){
				$errors[]= "Sauna valik tegemata!";
			}else{
				$saun =  htmlspecialchars($_POST['saun']);
			}
			if (empty($_POST["price"])){
				$errors[]= "Eelarve sisestamata!";
			}else{
				$price =  htmlspecialchars($_POST['price']);
			}
			if (empty($_POST["description"])){
				$errors[]= "Info sisestamata!";
			}else{
				$description =  htmlspecialchars($_POST['description']);
			}
			
			$nimi =  mysqli_real_escape_string($connection,htmlspecialchars($_POST['name']));
			$telefon = mysqli_real_escape_string($connection,htmlspecialchars($_POST['phone']));
			$saun = mysqli_real_escape_string($connection,htmlspecialchars($_POST['saun']));
			$eelarve = mysqli_real_escape_string($connection,htmlspecialchars($_POST['price']));
			$info = mysqli_real_escape_string($connection,htmlspecialchars($_POST['description']));
			
			if (empty($errors)){
				$sql= "INSERT INTO 12103979_tellimused (nimi,telefon,saun,eelarve,info) VALUES ('$nimi','$telefon','$saun','$eelarve','$info')";
				$result=mysqli_query($connection, $sql);
				if (mysqli_affected_rows($connection) > 0){
					header("Location: ?");
				}else{
					$errors[]= "Ei suutnud infot baasi lisada!";
					include_once('view/pakkumine.html');
				}
			}
		}
       include_once("view/pakkumine.html");
}
function signup(){
    global $connection;
	global $errors;
		if (empty($_SESSION['username'])) {
			header("Location: ?page=login");	
		}
		if ($_SERVER['REQUEST_METHOD']=='GET'){
			include_once('view/signup.html');
		}
		if ($_SERVER['REQUEST_METHOD']=='POST'){
			if (empty($_POST["username"])){
				$errors[]= "Kasutajanimi puudu!";
			}
			if (empty($_POST["passwd"])){
				$errors[]= "Parool puudu!";
			}
			if (($_POST["passwd"])!= ($_POST["passwd2"])){
				$errors[]= "Paroolid ei klapi!";
			}
			
			$kasutaja =  mysqli_real_escape_string($connection,htmlspecialchars($_POST['username']));
			$parool = mysqli_real_escape_string($connection,htmlspecialchars($_POST['passwd']));

			if (empty($errors)){
				$sql= "INSERT INTO 12103979_kylastajad (username, passw) VALUES ('$kasutaja', SHA1('$parool'))";
				$result=mysqli_query($connection, $sql);
				if (mysqli_affected_rows($connection) > 0){
					header("Location: ?");
				}else{
					$errors[]= "Ei suutnud kasutajat tekitada!";
					include_once('view/signup.html');
				}
			}
		}
include_once('view/signup.html');
}
function kontakt(){
        include_once("view/contact.html");
}
function tellimus(){
		global $connection;
		if (empty($_SESSION['username'])){
			header("Location: ?page=login");
		}
		$tellimused=array();
		$sql="SELECT * FROM 12103979_tellimused";
		$result = mysqli_query($connection, $sql);
		while ($rida = mysqli_fetch_assoc($result)){
				$tellimused[]=$rida;
		}
        include_once("view/tellimused.html");
}
function logout(){
		if (empty($_SESSION['username'])){
			header("Location: ?page=login");
		}
		$_SESSION=array();
        session_destroy();
		header("Location: ?");
}

?>