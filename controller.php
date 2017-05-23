<?php
require_once("functions.php");
session_start();
connect_db();
$page="pealeht";
if (isset($_GET['page']) && $_GET['page']!=""){
  	$page=htmlspecialchars($_GET['page']);
}

	$pildid=array(
	  array("big"=>"big/soome_saun.jpg", "small"=>"small/soome_saun.jpg", "alt"=>"Soome saun"),
	  array("big"=>"big/vene_saun.jpg", "small"=>"small/vene_saun.jpg", "alt"=>"Vene Saun"),
	  array("big"=>"big/turgi_saun.jpg", "small"=>"small/turgi_saun.jpg", "alt"=>"Türgi saun"),
	  array("big"=>"big/suitsusaun.jpg", "small"=>"small/suitsusaun.jpg", "alt"=>"Suitsusaun"),
	  array("big"=>"big/aurusaun.jpg", "small"=>"small/aurusaun.jpg", "alt"=>"Aurusaun"),
	  array("big"=>"big/aroomisaun.jpg", "small"=>"small/aroomisaun.jpg", "alt"=>"Aroomisaun"),
	);


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