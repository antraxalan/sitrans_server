<?php  
// error_reporting(0);
ob_start();
session_start();
require("conection.php");
$Nombre		= $_POST['var1'];
$IdPrueba	= "1";
// $principal		= 'alan';
$guardar  = $db->prepare("INSERT INTO test(IdPrueba,Nombre) values(:IdPrueba,:Nombre)");
$guardar->execute(array(':IdPrueba'=>$IdPrueba, ':Nombre'=>$Nombre));

// $datos = $db->prepare('SELECT hl FROM VentaDiariaNecesaria WHERE Fecha =  :f1 and IdNegocio=2');
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
// echo($datos);

$articulos='';
while($row = $datos->fetch()) {
	for ($i=0; $i < 19; $i++) { 
		$articulos.=$row[$i].'@';
	}
}
// echo $articulos;
$array  = substr($articulos, 0, -1);
$array1 = explode("@", $array);
$array2 = array_chunk($array1, 19);
// echo "<pre>";
// print_r($array2);
// echo "</pre>";
// echo($array2);




// echo "dsadas";
// print_r($array);

// echo($matrix);

// echo json_encode($articulos);
// $datos = $db->prepare('UPDATE  Ajustes set TiempoPrincipalSeg = :principal, TiempoBdMin= :bd where IdAjustes = 1 ');
// $datos->execute(array(':principal' => $principal,':bd' => $bd));


// echo json_encode("Modificados exitosamente.");

echo json_encode($array2);


?>