<?php

/*
*
*	0. LIBRARY
*
*/
function escapeStrings(&$array) {
	foreach($array as $k=>$v)
		if (is_string($v))
			$array[$k] = "'".str_replace("'","''", $v)."'";
}
function select($cols, $tblName, $extra = "") {
	global $db;
	$stmt = $db->prepare("SELECT ".implode(", ", $cols)." FROM $tblName $extra");
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function insert($cols, $tblName) {
	global $db;
	$stmt = $db->prepare("INSERT INTO $tblName (".implode(", ", array_keys($cols)).") VALUES (".implode(", ",escapeStrings(array_values($cols))).")");
	
	return $stmt->execute();
}
function update($cols, $tblName, $where) {
	global $db;
	escapeStrings($cols);
	$stmt = $db->prepare("UPDATE $tblName ".
		implode(", ",
			array_map(
				function($name,$value){return "$name = $value";},
				array_keys($cols),
				array_values($cols)
			)
		)
	." WHERE 1");
	
	return $stmt->execute();
}



/*
*
*	1. EXECUTABLE CODE
*
*/

// 1.1. Fetch credentials
require_once __DIR__."/../_implementation.php";	
// 1.2. Connect to Database
$db = new PDO('mysql:dbname='.$DB_NAME.';host='.$DB_HOST, $DB_USER_NAME, $DB_PASSWORD);

// 1.3. Get CURRENT USER
$currentUser = "xxx";




// 1.4. HANDLE FILE UPLOADS
if (!empty($_FILES)) {

	// Handle meme uploads
	if(isset($_FILES["meme"]) && isset($_FILES["meme"]["tmp_name"])) 
		move_uploaded_file($_FILES["meme"]["tmp_name"], __DIR__."/../uploads/$currentUser.jpg");
	
}

// 1.5. HANDLE DATA UPLOAD
if (!empty($_POST)) {
	if (isset($_POST["_table"])) {
		// Extract table name
		$tbl = $_POST["_table"]; unset($_POST["_table"]);
		// Update data
		update($_POST, $tbl, ["Utilizador" => $currentUser]);	
	}
	
}
