<?php
@session_start();
//error_reporting(E_ALL);
error_reporting(0);
/* if(!isset($_SESSION["username"]) && $NoChk!=1)
 {
      echo "<script>
			alert(\"กรุณาเข้าสู่ระบบ\");
			self.location.href='".$path."index.php';
		</script>";
 }*/

include($path."include/config.php");
include($path.'include/include.php');
include($path.'include/function.php');
include($path.'include/config_web.php');
if($_GET){
	foreach($_GET as $key => $param){
		$arrParam = @explode("&",url2param($key));
		if($arrParam){
			foreach($arrParam as $index => $var){
				$arrVar = explode("=",$var);
				${$arrVar[0]} = $arrVar[1];
			}
		}
	}
}

if($_POST || $_GET){
	foreach($_POST as $key => $value){
		${$key} = $value;
	}
	foreach($_GET as $key => $value){
		${$key} = $value;
	}
}
include($path.'include/paging.php');


?>
