<?php
require_once("functions.php");
session_start();
connect_db();
$page="pealeht";
if (isset($_GET['page']) && $_GET['page']!=""){
  	$page=htmlspecialchars($_GET['page']);
}

include_once("view/head.html");
switch($page){
	case "login":
		login();
	break;
	case "portfolio":
		portfolio();
	break;
	case "pakkumine":
		pakkumine();
	break;
	case "signup":
		signup();
	break;
	case "kontakt":
		kontakt();
	break;
	case "tellimus":
		tellimus();
	break;
	case "logout":
		logout();
	break;
	default:
		include_once("view/pealeht.html");
	break;
}
include_once("view/foot.html");
?>