<?php  
// error_reporting(0);
ob_start();
session_start();
require("conection.php");
$Nombre		= $_POST['var1'];
$IdPrueba	= "1";
// $principal		= 'alan';
$fecha='22/08/2013';
$guardar  = $db->prepare("INSERT INTO test(IdPrueba,Nombre) values(:IdPrueba,:Nombre)");
$guardar->execute(array(':IdPrueba'=>$IdPrueba, ':Nombre'=>$Nombre));

// $datos = $db->prepare('SELECT hl FROM VentaDiariaNecesaria WHERE Fecha =  :f1 and IdNegocio=2');
$datos = $db->prepare("SELECT 0 tipodcto,0 nrodcto,0 apu,b.fecha fecha,b.fechavto fechavto,tipodctoM,nrodctoM,0 precio,0 tc,codconcepto,a.codcliente codcliente,
			sum(debe-haber) debe,0 haber,0 codart,0 dcajas,0 hcajas,0 dunidades,0 hunidades
			from detalle a inner join maestro b on a.tipodctom=b.tipodcto and a.nrodctom=b.nrodcto
			where codconcepto=1400
			group by b.fecha,b.fechavto,tipodctoM,nrodctoM,codconcepto,a.codcliente
			having sum(debe-haber)<>0
			union
			select 0 tipodcto,0 nrodcto,0 apu,'01-01-1900' fecha,'01-01-1900' fechavto,0 tipodctoM,0 nrodctoM,0 precio,0 tc,
			CodConcepto,a.CodCliente CodCliente,
			sum(Debe-haber) debe,0 haber,a.codart CodArt,Sum(DUnidades-HUnidades)/CantxEmpaque dcajas,0 hcajas,Sum(DUnidades-HUnidades) dunidades,0 hunidades
			from Detalle a inner join Articulo b on a.CodArt=b.CodArt
			where CodConcepto=1600
			group by CodConcepto,a.CodCliente,a.CodArt,CantxEmpaque
			having Sum(Debe-Haber)<>0 or Sum(DUnidades-HUnidades)/CantxEmpaque<>0 or Sum(DUnidades-HUnidades)<>0
			union
			select 0 tipodcto,0 nrodcto,0 apu,max(fecha) fecha,'01-01-1900' fechavto,0 tipodctoM,0 nrodctoM,0 precio,0 tc,
			1200 CodConcepto,CodCliente,
			max(debe) debe,0 haber,CodArt,max(dcajas) dcajas,0 hcajas,0 dunidades,0 hunidades
			from Detalle 
			where tipodcto in (1,2)
			and codconcepto in (1200,1400) and debe>0
			group by CodCliente,CodArt
			union
			select 0 tipodcto,0 nrodcto,0 apu,fecha,fechavto,tipodctoM,nrodctoM,0 precio,0 tc,codconcepto,codcliente,
			debe,haber,codart,dcajas,hcajas,dunidades,hunidades
			from detalle 
			where codconcepto=1800 and tipodcto=40
			and codcliente=13
			and fecha='$fecha'
			order by CodConcepto,CodCliente,CodArt");
$datos->execute();
// echo($datos);

$articulos='';
while($row = $datos->fetch()) {
	for ($i=0; $i < 18; $i++) { 
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