<?php
session_start();
require("../../conection.php");
$usuario  = $_SESSION['usuario'];
$legajo   = $db->query("SELECT legajo FROM usuarios WHERE username = '$usuario'")->fetchColumn();
$stk             = $_POST['stk'];
$organizacion    = $_POST['organizacion'];
$persona         = $_POST['persona'];
$affected        = $_POST['affected'];
$awareness       = $_POST['awareness'];
$involved        = $_POST['involved'];
$relationship    = $_POST['relationship'];
$posicion        = $_POST['posicion'];
$idMatriz        = $_POST['idMatriz'];
$fecha           = date('d/m/Y');

// print_r($organizacion);
// print_r($persona);

// echo ($stk." ".$affected." ".$awareness." ".$involved." ".$relationship." ".$posicion." ".$idMatriz);

$datos = $db->prepare('UPDATE mstkglobal SET id_stk = :stk, id_aff =:affected, id_awa = :awareness, id_inv = :involved, id_rel = :relationship, id_pos = :posicion, fecha_modificado = :fecha WHERE id_msg = :idMatriz');
$datos->execute(array(':idMatriz' => $idMatriz, ':stk' => $stk, ':affected' => $affected,  ':awareness' => $awareness, ':involved' => $involved, ':relationship' => $relationship, ':posicion' => $posicion, ':fecha' => $fecha));

$borrar = $db->prepare('DELETE FROM stkorg WHERE id_msg = :idMatriz ');
$borrar->execute(array(':idMatriz' => $idMatriz));
$borrar2  = $db->prepare('DELETE FROM conorg WHERE id_msg = :idMatriz ');
$borrar2->execute(array(':idMatriz' => $idMatriz));

foreach ($organizacion as $idOrg) {
	$id2  = $db->query("SELECT max(id_stkorg) FROM stkorg")->fetchColumn();
	if($id2 == ''){
		$id2 = 1;
	}else{
		$id2 = $id2 + 1;
	}
	$datos2 = $db->prepare('INSERT INTO stkorg VALUES(:id2, :stk, :organizacion)');
	$datos2->execute(array(':id2' => $id2, ':stk' => $idMatriz, ':organizacion' => $idOrg));

	foreach ($persona as $idPer) {
		$id3 = $db->query("SELECT max(id_conorg) FROM conorg")->fetchColumn();
		if($id3 == ''){
			$id3 = 1;
		}else{
			$id3 = $id3 + 1;
		}
		$datos3 = $db->prepare('INSERT INTO conorg VALUES (:id3, :organizacion, :persona, :stk)');
		$datos3->execute(array(':id3' => $id3, ':organizacion' => $idOrg, ':persona' => $idPer, ':stk' => $idMatriz));
	}
	// print_r(array(':id2' => $id2, ':stk' => $stk, ':organizacion' => $idOrg));
}

echo json_encode(true);
?>