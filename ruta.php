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


$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
if($verificar > 0)
{
	$datos = $db->prepare("SELECT CodRuta, DesRuta from Rutas");
	$datos->execute();

	$articulos='';
	while($row = $datos->fetch()) {
		for ($i=0; $i < 2; $i++) { 
			$articulos.=$row[$i].'@';
		}
	}
	$array  = substr($articulos, 0, -1);
	$array1 = explode("@", $array);
	$array2 = array_chunk($array1, 2);
	echo json_encode($array2);
}else{
	$vacio='';
	echo json_encode($vacio);
}


?>