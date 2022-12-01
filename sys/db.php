<?php

/*
*
*	0. LIBRARY
*
*/
function escapeStrings(&$array) {
	foreach($array as $k=>$v)
		if (is_string($v) && $v != "NULL")
			$array[$k] = "'".str_replace("'","''", $v)."'";
	return $array;
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
function update(array $cols, string $tblName, array $where) {
	global $db;
	escapeStrings($cols);
	$query = "UPDATE $tblName SET ".
		implode(", ",
			array_map(
				function($name,$value){return "$name = $value";},
				array_keys($cols),
				array_values($cols)
			)
		)
	." WHERE "
	.implode(" AND ",array_map(function($name, $value){return "$name = $value";},array_keys($where),escapeStrings($where)))
	;
				error_log("attempting query: ".$query);
	$stmt = $db->prepare($query);
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
$db = new PDO('mysql:dbname='.(explode(".",$_SERVER["SERVER_NAME"])[0]).';host='.$DB_HOST, $DB_USER_NAME, $DB_PASSWORD);



// 1.3. HANDLE LOGIN
if (!isset($_COOKIE["loginID"])) die("No login id token provided.");
$queryResults = select(["Utilizador","FraseEpica","NomeLongo","Admin"], "Utilizadores","WHERE Token = '{$_COOKIE["loginID"]}'");
if (empty($queryResults)) die("Login token not found.");
$currentUser = $queryResults[0]["Utilizador"];
$currentUserData = $queryResults[0];
$currentUserIsAdmin = ($queryResults[0]["Admin"] ? true : false);

// 1.4 PRE-LOAD CHAMPIONSHIP
$campeonato = select(["Nome","Estado"], "Campeonatos")[0]; 

// 1.5. HANDLE FILE UPLOADS
if (!empty($_FILES)) {

	// Handle meme uploads
	if(isset($_FILES["meme"]) && isset($_FILES["meme"]["tmp_name"])) 
		move_uploaded_file($_FILES["meme"]["tmp_name"], __DIR__."/../uploads/$currentUser.jpg");
	
}

// 1.6. HANDLE DATA UPLOAD
if (!empty($_POST)) {
	if (isset($_POST["_table"])) {
		// Extract table name
		$tbl = $_POST["_table"]; unset($_POST["_table"]);
		if (isset($_POST["_operation"]) && $_POST["_operation"] == "insert") {
			unset($_POST["_operation"]);
			//
			//  Handle INSERTs
			//
			try {
				insert($_POST, $tbl);	
			} catch (Exception $e) {
				die ($e->getMessage());
			}			
			
		} else {
			if (isset($_POST["operation"])) unset($_POST["_operation"]);
			//
			//  Handle UPDATES
			//
			$filterArray = ["Utilizador" => $currentUser];
			foreach($_POST as $key => $value)
				if (strpos($key,"_pk_") === 0) {
					unset($_POST[$key]);
					$filterArray[str_replace("_pk_","",$key)] = $value;
				}
		
			// Hotfix: 
			if ($tbl == "ApostasJogos" && !isset($_POST["Boost"])) $_POST["Boost"] = "NULL";
		
			// Update data
			try {
				update($_POST, $tbl, $filterArray);	
			} catch (Exception $e) {
				die ($e->getMessage());
			}			
		}

	}
	
}
