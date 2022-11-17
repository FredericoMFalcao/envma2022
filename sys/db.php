<?php

/*
*
*	LIBRARY
*
*/
function select($cols, $tblName, $extra = "") {
	global $db;
	$stmt = $db->prepare("SELECT ".implode(", ", $cols)." FROM $tblName $extra");
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



/*
*
*	EXECUTABLE CODE
*
*/

// 1. Fetch credentials
require_once __DIR__."/../_implementation.php";	
// 2. Connect to Database
$db = new PDO('mysql:dbname='.$DB_NAME.';host='.$DB_HOST, $DB_USER_NAME, $DB_PASSWORD);

// 3. Get CURRENT USER
$currentUser = "xxx";




// 3. HANDLE FILE UPLOADS (memes)
if(isset($_FILES["meme"]) && isset($_FILES["meme"]["tmp_name"])) 
	move_uploaded_file($_FILES["meme"]["tmp_name"], __DIR__."/../uploads/$currentUser.jpg");
