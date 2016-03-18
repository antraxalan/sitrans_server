<?php  
// error_reporting(0);
ob_start();
session_start();
require("conection.php");
// $Nombre		= $_POST['var1'];
if(isset($_POST['codigo'])){
	$codigo 	= $_POST['codigo'];
}

if(isset($_POST['password'])){
	$password 	= $_POST['password'];
}

if(isset($_POST['info'])){
	$info 		= $_POST['info'];
}
if(isset($_POST['data'])){
	$data 		= $_POST['data'];
}

$fecha=date('d/m/Y');
$fecha=date('d/m/Y').' '.date('h:i:s a');
// $fecha='22/08/2013';



switch ($info) {





	// case "verificar":
	// $verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	// if($verificar > 0)
	// {
	// 	echo json_encode("1");
	// }else{
	// 	echo json_encode("0");
	// }
	// break;





	// case "articulo":
	// $verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	// if($verificar > 0)
	// {
	// 	$datos = $db->prepare("SELECT a.codmarca codmarca,desmarca,a.CodArt CodArt,a.DesArt DesArt,a.DesArtReducido DesArtReducido,a.Calibre Calibre,
	// 		a.TipoArticulo TipoArticulo,a.CantxEmpaque CantxEmpaque,a.PrecioCompra PrecioCompra,a.PrecioVtaMin PrecioVtaMin,a.PrecioVtaMax PrecioVtaMax,
	// 		a.CodBotella CodBotella,b.DesArt DesBotella,b.PreciovtaMin PVtaMinBot,a.CodCaja CodCaja,c.Desart DesCaja,
	// 		c.PreciovtaMin PVtaMinCaja,c.PreciovtaMax PVtaMaxCaja,a.estado
	// 		from articulo a inner join marca d on a.codmarca=d.codmarca
	// 		left outer join articulo b on a.CodBotella=b.CodArt
	// 		left outer join articulo c on a.CodCaja=c.CodArt
	// 		where a.estado='A'
	// 		order by a.codmarca,a.codart");
	// 	$datos->execute();

	// 	$articulos='';
	// 	while($row = $datos->fetch()) {
	// 		for ($i=0; $i < 19; $i++) { 
	// 			$articulos.=$row[$i].'@';
	// 		}
	// 	}
	// 	$array  = substr($articulos, 0, -1);
	// 	$array1 = explode("@", $array);
	// 	$array2 = array_chunk($array1, 19);
	// 	// echo "<pre>";
	// 	// print_r($array2);
	// 	// echo "</pre>";
	// 	// echo($array2);
	// 	echo json_encode($array2);
	// }
	// break;





	// case "cliente":
	// $verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	// if($verificar > 0)
	// {
	// 	$datos = $db->prepare("SELECT a.codcliente codcliente,nombre,razonsocial,direccion,nit,nrotelefono1,nrotelefono2,a.codzona codzona,deszona,a.codpersonal,despersonal,d.codruta codruta,desruta
	// 		from clientes a inner join zona b on a.codzona=b.codzona
	// 		inner join personal c on a.codpersonal=c.codpersonal
	// 		left outer join RutasClientes d on a.codcliente=d.codcliente
	// 		left outer join Rutas e on d.codruta=e.codruta
	// 		where a.codcliente>=100");
	// 	$datos->execute();

	// 	$articulos='';
	// 	while($row = $datos->fetch()) {
	// 		for ($i=0; $i < 13; $i++) { 
	// 			$articulos.=$row[$i].'@';
	// 		}
	// 	}
	// 	$array  = substr($articulos, 0, -1);
	// 	$array1 = explode("@", $array);
	// 	$array2 = array_chunk($array1, 13);

	// 	echo json_encode($array2);
	// }
	// break;





	case "detalle":
	$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	if($verificar > 0)
	{
		$id = $db->query("SELECT max(id) FROM probando")->fetchColumn();
		if($id == ''){
			$id = 1;
		}else{
			$id = $id + 1;
		}

		$cont=0;
		// $data=$data;

		// $tipo_riesgo = $db->prepare('SELECT id_rtype ,detalle from risktype ORDER BY id_rtype DESC');
		// $tipo_riesgo->execute();

		// while($row = $data->fetch()) {  
		// 	$cont=$cont+1;
		// }
// $cont=gettype($data);
		$array=$data;
		$array  = substr($array, 0, -1);
		$array1 = explode("|", $array);
		$array2 = array_chunk($array1, 18);
		$cont=count($array2);


		$datos = $db->prepare('INSERT INTO probando VALUES(:id, :cont, :fecha)');
		$datos->execute(array(':id' => $id, ':cont' => $cont, ':fecha' => $fecha));



		echo json_encode("Done.");
	}else{
		echo json_encode("NOT Done.");

	}
	// echo json_encode('|||');
	break;




	// case "maestro":
	// $verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	// if($verificar > 0)
	// {
	// 	$datos = $db->prepare("SELECT a.TipoDcto TipoDcto,a.NroDcto NroDcto,a.Fecha Fecha,a.FechaVto FechaVto,'Saldo deuda' Obs,a.CodCliente CodCliente,count(*) Conteo
	// 		from maestro a inner join  detalle b on a.tipodcto=b.tipodctom and a.nrodcto=b.nrodctom and codconcepto=1400
	// 		group by a.TipoDcto,a.NroDcto,a.Fecha,a.FechaVto,a.CodCliente
	// 		order by tipodcto,nrodcto");

	// 	$datos->execute();

	// 	$articulos='';
	// 	while($row = $datos->fetch()) {
	// 		for ($i=0; $i < 7; $i++) { 
	// 			$articulos.=$row[$i].'@';
	// 		}
	// 	}
	// 	$array  = substr($articulos, 0, -1);
	// 	$array1 = explode("@", $array);
	// 	$array2 = array_chunk($array1, 7);

	// 	echo json_encode($array2);
	// }
	// break;






}
// echo json_encode($codigo.'|||'.$password.'|||'.$info.'|||'.$data);
?>