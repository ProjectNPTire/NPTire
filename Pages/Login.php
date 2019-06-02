<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_start();

$path = "../";
$NoChk=1;

include($path."include/config_header_top.php");

$username = $_POST["username"];
$password = $_POST["password"];

//แสดงข้อมูลชื่อ


////

if($username != "" & $password != ""){

	$sqlChk		= "	SELECT *
	FROM tb_user
	where username = '".$username."' and password = '".$password."' ";

	$queryChk = $db->query($sqlChk);
	$nums = $db->db_num_rows($queryChk);
	$arrSet = array();

//	$nums ="";
	if($nums){
		$rec = $db->db_fetch_array($queryChk);

		if ($rec["userStatus"] == 1 && $rec["activeStatus"] == 1) {
			$_SESSION["sys_id"] = $rec["userID"];//รหัส per
			$_SESSION["username"] = $rec["username"];//ชื่อผู้ใช้งาน
			$_SESSION["userType"] = $rec["userType"];//
			$_SESSION['sys_name'] = $rec["firstname"].' '.$rec["lastname"];

			echo "<script>self.location.href='main.php';</script>";
		}else if ($rec["userStatus"] == 1 && $rec["activeStatus"] == 0) {
			session_destroy();
			echo "<script>
			alert(\"ไม่สามารถเข้าระบบได้เนื่องจากพนักงานถูกปิดการใช้งาน\");
			self.location.href='index.php';
			</script>";
		}else if ($rec["userStatus"] == 2 && $rec["activeStatus"] == 0) {
			session_destroy();
			echo "<script>
			alert(\"ไม่สามารถเข้าระบบได้เนื่องจากพนักงานลาออก\");
			self.location.href='index.php';
			</script>";
		}
	}else{
			//header('Content-type: text/html; charset=utf-8');
		session_destroy();
		echo "<script>
		alert(\"ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง\");
		self.location.href='index.php';
		</script>";
	}
}else{
	//header('Content-type: text/html; charset=utf-8');
	session_destroy();
	echo "<script>
	alert(\"ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง\");
	self.location.href='index.php';
	</script>";
}
?>
