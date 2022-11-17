<?php
require_once __DIR__."/../_implementation.php";
	
$db = new PDO('mysql:dbname='.$DB_NAME.';host='.$DB_HOST, $DB_USER_NAME, $DB_PASSWORD);

function select($cols, $tblName, $extra = "") {
	global $db;
	$stmt = $db->prepare("SELECT ".implode(", ", $cols)." FROM $tblName $extra");
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
