<?php  
// error_reporting(0);
ob_start();
session_start();
date_default_timezone_set('America/La_Paz');
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

// $cont=$info.' - '.$data;
// $datos = $db->prepare('INSERT INTO probando VALUES(:id, :cont, :fecha)');
// $datos->execute(array(':id' => 1, ':cont' => $cont, ':fecha' => $fecha));



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







	case "detalle":
	// $datos = $db->prepare('INSERT INTO probando VALUES(:id, :cont, :fecha)');
	// $datos->execute(array(':id' => 1, ':cont' => 1, ':fecha' => $fecha));

	$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	if($verificar > 0)
	{
		$id = $db->query("SELECT max(CodSincDetalle) FROM SincDetalle")->fetchColumn();
		if($id == ''){
			$id = 1;
		}else{
			$id = $id + 1;
		}

		$cont=0;
		// $datos = $db->prepare('INSERT INTO probando VALUES(:id, :cont, :fecha)');
		// $datos->execute(array(':id' => $id, ':cont' => $cont, ':fecha' => $fecha));
		$array=$data;
		$array  = substr($array, 0, -1);
		$array1 = explode("|", $array);
		if( !empty( $array1 ) ){
			$array2 = array_chunk($array1, 18);
			// $cont=count($array2);
			foreach ($array2 as $value) {

				$aux=explode(' ', $value[3]);
				$value[3]=$aux[0];
				$value[3]=implode('-', array_reverse(explode('-', $value[3])));

				$aux=explode(' ', $value[4]);
				$value[4]=$aux[0];
				$value[4]=implode('-', array_reverse(explode('-', $value[4])));

				// $cont=$value[3];
				// $datos = $db->prepare('INSERT INTO probando VALUES(:id, :cont, :fecha)');
				// $datos->execute(array(':id' => $id, ':cont' => $cont, ':fecha' => $fecha));

				$datos = $db->prepare('INSERT INTO SincDetalle VALUES(:CodSincDetalle,:TipoDcto, :NroDcto, :Apu, :Fecha, :FechaVto, :TipoDctoM, :NroDctoM, :Precio, :Tc, :CodConcepto, :CodCliente, :Debe, :Haber, :CodArt, :Dcajas, :Hcajas, :Dunidades, :Hunidades, :FechaCarga)');
				$datos->execute(array('CodSincDetalle' => $id,'TipoDcto' => $value[0], 'NroDcto' => $value[1], 'Apu' => $value[2], 'Fecha' => $value[3], 'FechaVto' => $value[4], 'TipoDctoM' => $value[5], 'NroDctoM' => $value[6], 'Precio' => $value[7], 'Tc' => $value[8], 'CodConcepto' => $value[9], 'CodCliente' => $value[10], 'Debe' => $value[11], 'Haber' => $value[12], 'CodArt' => $value[13], 'Dcajas' => $value[14], 'Hcajas' => $value[15], 'Dunidades' => $value[16], 'Hunidades' => $value[17], 'FechaCarga' => $fecha));
				$id++;

			}
		}
		$cont=count($array2);




		

		// $query="INSERT INTO probando ( id, cont, fecha )";

		// for ($i=0; $i < $len; $i++) { 
		// 	if(($i+1)!=$len){
		// 		$query.=" SELECT $i,'2','01/01/1999' UNION ALL ";
		// 	}else{
		// 		$query.=" SELECT $i,'2','01/01/1999'";				
		// 	}

		// }
		// if($len>0){
		// 	$datos = $db->prepare($query);
		// 	$datos->execute();
		// }



		echo json_encode("Done Detalle.".$cont);
	}else{
		echo json_encode("NOT Done.");

	}
	// echo json_encode('|||');
	break;




	case "maestro":
	
	$verificar = $db->query("SELECT count(*) FROM Personal WHERE CodPersonal= '$codigo' and CI='$password'")->fetchColumn();
	if($verificar > 0)
	{
		$id = $db->query("SELECT max(CodSincMaestro) FROM SincMaestro")->fetchColumn();
		if($id == ''){
			$id = 1;
		}else{
			$id = $id + 1;
		}

		$cont=0;

		$array=$data;
		$array  = substr($array, 0, -1);
		$array1 = explode("|", $array);
		if( !empty( $array1 ) ){
			$array2 = array_chunk($array1, 7);
			// $cont=count($array2);
			foreach ($array2 as $value) {

				$aux=explode(' ', $value[2]);
				$value[2]=$aux[0];
				$value[2]=implode('-', array_reverse(explode('-', $value[2])));

				$aux=explode(' ', $value[3]);
				$value[3]=$aux[0];
				$value[3]=implode('-', array_reverse(explode('-', $value[3])));

				// $cont=$value[3];
				// $datos = $db->prepare('INSERT INTO probando VALUES(:id, :cont, :fecha)');
				// $datos->execute(array(':id' => $id, ':cont' => $cont, ':fecha' => $fecha));

				$datos = $db->prepare('INSERT INTO SincMaestro VALUES(:CodSincMaestro, :TipoDcto, :NroDcto, :Fecha, :FechaVto, :Obs, :CodCliente, :Conteo, :FechaCarga)');
				$datos->execute(array('CodSincMaestro' => $id,'TipoDcto' => $value[0], 'NroDcto' => $value[1], 'Fecha' => $value[2], 'FechaVto' => $value[3], 'Obs' => $value[4], 'CodCliente' => $value[5], 'Conteo' => $value[6], 'FechaCarga' => $fecha));
				$id++;
				
			}
		}
		$cont=count($array2);

		echo json_encode("Done Maestro.".$cont);
	}else{
		echo json_encode("NOT Done.");

	}

	break;






}
// echo json_encode($codigo.'|||'.$password.'|||'.$info.'|||'.$data);
?>