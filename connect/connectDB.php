<?php
	date_default_timezone_set('Asia/Bangkok');
	$host = "localhost";
	$user = "root";
	$pas  = "1234";
	//$pas  = "";
	$link = mysqli_connect($host,$user,$pas) or die ("Connection fail");
	$db = "nptire_db";
	mysqli_select_db($link,$db) or die ("Connection DB fail");
	mysqli_query($link,"SET NAMES UTF8");
	mysqli_query($link,"SET charecter_set_results=UTF8");
	mysqli_query($link,"SET charecter_set_client=UTF8");
	mysqli_query($link,"set charecter_set_connection=UTF8");
	$date = date("Y-m-d");
	$time = date("H-i-s");
?>