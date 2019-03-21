<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$path_pic = $path."file_img/";

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];
$userID = $_REQUEST['userID'];
$img = $_FILES['img'];

$tb1 = 'tb_user';

//$attach = $_FILES['img'];
//print_r($attach);
// if($attach['error']=='0'){
// 		//เก็บชื่อไฟล์ที่ user พิมพ์เพื่อเข้าสู่ระบบ
// 	$fileinfo = pathinfo($attach['name']);
// 		//เก็บข้อมูลรูปภาพและแปลงเป็นตัวพิมพ์เล็กทั้งหมด เก็บ extension ในfiletype
// 	$filetype = strtolower($fileinfo['extension']);
// 	//1.
// 		//ชนิดของภาพที่เก็บใน array
// 	$type = array('gif','jpg','png','jpeg');
// 		//ตรวจสอบชื่อของรูปใน array
// 	if (in_array($filetype,$type))

// 	//2.
// 		if($filetype=='gif'||$filetype=='jpg'||$filetype=='png'||$filetype=='jpeg')
// 		{
// 		//เวลาปัจจุบัน ที่ user อัพรูปเข้า
// 			$file = time().".$filetype";
// 			move_uploaded_file($attach['tmp_name'],"img/$file");
// 		}
// 		else{
// 			exit("<script>alert('กรุณาตรวจสอบไฟล์');history.back();</script>");
// 		}
// 	}

	switch($proc){
		case "add" :
		try{

			if ($img["size"]>0) {
				$file_type = $img['type'];
				$type = array("image/jpeg", "image/gif", "image/png");			
				if (in_array($file_type,$type)){
					$tmp_name = $img["tmp_name"];
					$type_pic =  explode(".",$img["name"]);
					$name = date('YmdHis').".".$type_pic[1];
					copy($tmp_name,$path_pic.$name);
					@unlink($path_pic.$old_file);
				}else{
					$name = $old_file;
				}
			}else{
				$name = $old_file;
			}
			unset($fields);
			$fields = array(
				"userCode"=>$userCode,
				"firstname"=>$firstname,
				"lastname"=>$lastname,
				"birthday"=>conv_date_db($hdfBirthday),
				"idcard"=>$idcard,
				"email"=>$email,
				"mobile"=>$mobile,
				"address"=>$address,
				"provinceID"=>$hdfProvinceID,
				"districtID"=>$hdfDistrictID,
				"subDistrictID"=>$hdfSubDistrictID,
				"zipcode"=>$zipcode,
				"username"=>$username,
				"password"=>$password1,
				"img"=>$name,
				"activeStatus"=>$activeStatus,
				"userStatus"=>$userStatus,
				"userType"=>$userType,
				"addressIDCard"=>$addressIDCard,
				"provinceIDCard"=>$provinceIDCard,
				"districtIDCard"=>$districtIDCard,
				"subDistrictIDCard"=>$subDistrictIDCard,
				"zipcodeIDCard"=>$zipcodeIDCard,
				"firstnameref"=>$firstnameref,
				"lastnameref"=>$lastnameref,
				"mobileref"=>$mobileref,

			);
				//print_pre($fields);
			$db->db_insert($tb1,$fields);
			$detail = 'เพิ่มข้อมูลพนักงาน Username : '.$username;
			save_log($detail);
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
		break;
		case "edit" :
		try{

			if ($img["size"]>0) {
				$file_type = $img['type'];
				$type = array("image/jpeg", "image/gif", "image/png");			
				if (in_array($file_type,$type)){

					$tmp_name = $img["tmp_name"];
					$type_pic =  explode(".",$img["name"]);
					$name = date('YmdHis').".".$type_pic[1];
					copy($tmp_name,$path_pic.$name);
					@unlink($path_pic.$old_file);
				}else{
					$name = $old_file;
				}
			}else{
				$name = $old_file;
			}
			unset($fields);
			$fields = array(
				"userCode"=>$userCode,
				"firstname"=>$firstname,
				"lastname"=>$lastname,
				"birthday"=>conv_date_db($hdfBirthday),
				"idcard"=>$idcard,
				"email"=>$email,
				"mobile"=>$mobile,
				"address"=>$address,
				"provinceID"=>$hdfProvinceID,
				"districtID"=>$hdfDistrictID,
				"subDistrictID"=>$hdfSubDistrictID,
				"zipcode"=>$zipcode,
				"username"=>$username,
				"password"=>$password1,
				"img"=>$name,
				"activeStatus"=>$activeStatus,
				"userStatus"=>$userStatus,
				"userType"=>$userType,
				"addressIDCard"=>$addressIDCard,
				"provinceIDCard"=>$provinceIDCard,
				"districtIDCard"=>$districtIDCard,
				"subDistrictIDCard"=>$subDistrictIDCard,
				"zipcodeIDCard"=>$zipcodeIDCard,
				"firstnameref"=>$firstnameref,
				"lastnameref"=>$lastnameref,
				"mobileref"=>$mobileref,
			);

			$db->db_update($tb1,$fields, " userID = '".$userID."'");
			$detail = 'แก้ไขข้อมูลพนักงาน Username : '.$username;
			save_log($detail);

			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
		break;

		case "delete" :
		try{
			$sql     = " SELECT *
			FROM tb_user
			where userID ='".$userID."' ";
			$query = $db->query($sql);
			$nums = $db->db_num_rows($query);
			$rec = $db->db_fetch_array($query);

			$detail = 'ลบข้อมูลพนักงาน Username : '.$rec['username'];
			save_log($detail);

			$db->db_delete($tb1, " userID = '".$userID."'");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
		break;

	}

	if($proc!='chk_dup1' && $proc!='chk_dup2'){
		?>
		<form name="form_back" method="post" action="<?php echo $url_back;?>">
			<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
			<input type="hidden" id="act" name="act" value="<?php echo $act;?>" />
		</form>
		<script>
			alert('<?php echo $text;?>');
			form_back.submit();
		</script>
		<?php
	}
	?>
