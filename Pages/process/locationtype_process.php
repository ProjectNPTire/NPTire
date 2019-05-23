<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");
//$path_pic = $path."file_img/";
$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];
$locationTypeID = $_REQUEST['locationTypeID'];
//$userID = $_REQUEST['userID'];
//$img = $_FILES['img'];

$tb1 = 'tb_locationtype';

switch($proc){
	case "add" :
	try{
		unset($fields);
		$fields = array(
						//"locationID"=>$locationID,
			"locationTypeCode"=>$locationTypeCode,
			"locationTypeName"=>$locationTypeName,
			"name_nospace"=>str_replace(" ","",$locationTypeName),
			"locationType"=>$hdflocationType,
			"isEnabled"=>$hdfstatus,
		);
				//print_pre($fields);
		$db->db_insert($tb1,$fields);
		$detail = "เพิ่มข้อมูลประเภทตำแหน่งสินค้า ".$locationTypeName;
		save_log($detail);
		$text=$save_proc;
	}catch(Exception $e){
		$text=$e->getMessage();
	}
	break;
	case "edit" :
	try{
		unset($fields);
		$fields = array(
			"locationTypeCode"=>$locationTypeCode,
			"locationTypeName"=>$locationTypeName,
			"name_nospace"=>str_replace(" ","",$locationTypeName),
			"locationType"=>$hdflocationType,
			"isEnabled"=>$hdfstatus,
		);

		$db->db_update($tb1,$fields, " locationTypeID = '".$locationTypeID."'");
		// echo "<pre>";
		
		// print_r($db);
		// echo "</pre>";
//exit;
		$detail = "แก้ไขข้อมูลตำแหน่งสินค้า locationTypeName : ".$locationTypeName;
		save_log($detail);

		$text=$edit_proc;
	}catch(Exception $e){
		$text=$e->getMessage();
	}
	break;

	case "delete" :
	try{
		$db->db_delete($tb1, " locationTypeID = '".$locationTypeID."'");
		$detail = "ลบข้อมูลตำแหน่งสินค้า locationTypeName : ".$locationTypeName;
		save_log($detail);
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
