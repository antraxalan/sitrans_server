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


$guardar  = $db->prepare("INSERT INTO VentaMensualNecesaria(IdNegocio,Anio,Mes,IdRegion,Hl) values(:IdNegocio,:Anio,:Mes,:IdRegion,:Hl)");
$guardar->execute(array(':IdNegocio'=>$id, ':Anio'=>$anio, ':Mes'=>$mes, ':IdRegion'=>$id_region, ':Hl'=>$values));




switch ($info) {

	case "verificar":
	$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	if($verificar > 0)
	{
		echo json_encode("1");
	}else{
		echo json_encode("0");
	}
	break;





	case "articulo":
	$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	if($verificar > 0)
	{
		$datos = $db->prepare("SELECT a.codmarca codmarca,desmarca,a.CodArt CodArt,a.DesArt DesArt,a.DesArtReducido DesArtReducido,a.Calibre Calibre,
			a.TipoArticulo TipoArticulo,a.CantxEmpaque CantxEmpaque,a.PrecioCompra PrecioCompra,a.PrecioVtaMin PrecioVtaMin,a.PrecioVtaMax PrecioVtaMax,
			a.CodBotella CodBotella,b.DesArt DesBotella,b.PreciovtaMin PVtaMinBot,a.CodCaja CodCaja,c.Desart DesCaja,
			c.PreciovtaMin PVtaMinCaja,c.PreciovtaMax PVtaMaxCaja,a.estado
			from articulo a inner join marca d on a.codmarca=d.codmarca
			left outer join articulo b on a.CodBotella=b.CodArt
			left outer join articulo c on a.CodCaja=c.CodArt
			where a.estado='A'
			order by a.codmarca,a.codart");
		$datos->execute();

		$articulos='';
		while($row = $datos->fetch()) {
			for ($i=0; $i < 19; $i++) { 
				$articulos.=$row[$i].'@';
			}
		}
		$array  = substr($articulos, 0, -1);
		$array1 = explode("@", $array);
		$array2 = array_chunk($array1, 19);
		// echo "<pre>";
		// print_r($array2);
		// echo "</pre>";
		// echo($array2);
		echo json_encode($array2);
	}
	break;





	case "cliente":
	$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	if($verificar > 0)
	{
		$datos = $db->prepare("SELECT a.codcliente codcliente,nombre,razonsocial,direccion,nit,nrotelefono1,nrotelefono2,a.codzona codzona,deszona,a.codpersonal,despersonal,d.codruta codruta,desruta
			from clientes a inner join zona b on a.codzona=b.codzona
			inner join personal c on a.codpersonal=c.codpersonal
			left outer join RutasClientes d on a.codcliente=d.codcliente
			left outer join Rutas e on d.codruta=e.codruta
			where a.codcliente>=100");
		$datos->execute();

		$articulos='';
		while($row = $datos->fetch()) {
			for ($i=0; $i < 13; $i++) { 
				$articulos.=$row[$i].'@';
			}
		}
		$array  = substr($articulos, 0, -1);
		$array1 = explode("@", $array);
		$array2 = array_chunk($array1, 13);

		echo json_encode($array2);
	}
	break;





	case "detalle":
	$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	if($verificar > 0)
	{
		$datos = $db->prepare("SELECT 0 tipodcto,0 nrodcto,0 apu,b.fecha fecha,b.fechavto fechavto,tipodctoM,nrodctoM,0 precio,0 tc,
			codconcepto,a.codcliente codcliente,
			sum(debe-haber) debe,0 haber,0 codart,0 dcajas,0 hcajas,0 dunidades,0 hunidades
			from detalle a inner join maestro b on a.tipodctom=b.tipodcto and a.nrodctom=b.nrodcto
			where codconcepto=1400
			group by b.fecha,b.fechavto,tipodctoM,nrodctoM,codconcepto,a.codcliente
			having sum(debe-haber)<>0
			union
			select 0 tipodcto,0 nrodcto,0 apu,'01-01-1900' fecha,'01-01-1900' fechavto,0 tipodctoM,0 nrodctoM,0 precio,0 tc,
			CodConcepto,a.CodCliente CodCliente,
			sum(Debe-haber) debe,0 haber,a.CodArt CodArt,Sum(DUnidades-HUnidades)/CantxEmpaque dcajas,0 hcajas,Sum(DUnidades-HUnidades) dunidades,0 hunidades
			from Detalle a inner join Articulo b on a.CodArt=b.CodArt
			where CodConcepto=1600
			group by CodConcepto,a.CodCliente,a.CodArt,CantxEmpaque
			having Sum(Debe-Haber)<>0 or Sum(DUnidades-HUnidades)/CantxEmpaque<>0 or Sum(DUnidades-HUnidades)<>0
			union
			select 0 tipodcto,0 nrodcto,0 apu,'01-01-1900' fecha,'01-01-1900' fechavto,0 tipodctoM,0 nrodctoM,max(precio) precio,0 tc,
			1200 CodConcepto,CodCliente,
			0 debe,0 haber,CodArt,0 dcajas,0 hcajas,0 dunidades,0 hunidades
			from Detalle 
			where tipodcto in (1,2)
			and codconcepto in (1200,1400) and debe>0
			group by CodCliente,CodArt");
$datos->execute();

$articulos='';
while($row = $datos->fetch()) {
	for ($i=0; $i < 18; $i++) { 
		$articulos.=$row[$i].'@';
	}
}
$array  = substr($articulos, 0, -1);
$array1 = explode("@", $array);
$array2 = array_chunk($array1, 18);

echo json_encode($array2);
}
break;
}
// echo json_encode('1');
?>