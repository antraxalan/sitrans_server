<?php  
$db = new PDO("sqlsrv:Server=BOCLPZP79W0P\SQLEXPRESS;Database=Distribuidora", "sa", "Sqladmin2015");
// $db = new PDO("sqlsrv:Server=BOCLPZN31JD1\SQLEXPRESS;Database=travelExpenses", "joaarzem", "quilmes2014");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>