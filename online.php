<?php  
// error_reporting(0);
ob_start();
session_start();
require("conection.php");

if(isset($_POST['codigo'])){
	$codigo 	= $_POST['codigo'];
}

if(isset($_POST['password'])){
	$password 	= $_POST['password'];
}

if(isset($_POST['info'])){
	$info 		= $_POST['info'];
}

// $fecha=date('d/m/Y');
// $fecha='22/08/2013';

switch ($info) {


//1 con errores en DB
//2 Conexion correcta


	case "verificar":
	$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	if($verificar > 0)
	{
		echo json_encode("1");
	}else{
		echo json_encode("0");
	}
	break;

	case "is_ok":
	$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	if($verificar > 0)
	{
		echo json_encode("ok");
	}else{
		echo json_encode("0");
	}
	break;


	case "is_online":
	
		echo json_encode("2");
	
	break;

















}
// echo json_encode('1');
?>