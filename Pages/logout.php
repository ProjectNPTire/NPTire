<?php
//session_start();
$path = "../";
include($path."include/config_header_top.php");
	$path_out = "index.php";

session_destroy();

echo "<script>
		self.location.href='index.php';
	  </script>";
?>