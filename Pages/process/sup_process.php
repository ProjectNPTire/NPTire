<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];

$tb1 = 'tb_supplier';

switch($proc){
	case "add" :
		try{
				unset($fields);
				$fields = array(
						"supCode"=>$supCode,
						"sup_name"=>$sup_name,
						"sup_email"=>$sup_email,
						"sup_mobile"=>$sup_mobile,
						"sup_tel"=>$sup_tel,
						"sup_address"=>$sup_address,
						"provinceID"=>$provinceID,
						"districtID"=>$districtID,
						"subDistrictID"=>$subDistrictID,
						"zipcode"=>$zipcode,
						"note"=>$note,
						"namesale"=>$namesale,
						"lastnamesale"=>$lastnamesale,
						"mobilesale"=>$mobilesale,
						"idline"=>$idline,
						"name_nospace"=>str_replace(" ","",$sup_name),
				);
				 $db->db_insert($tb1,$fields);
				 $detail = "เพิ่มข้อมูลคู่ค้า/บริษัท".$sup_name;
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
					"supCode"=>$supCode,
					"sup_name"=>$sup_name,
					"sup_email"=>$sup_email,
					"sup_mobile"=>$sup_mobile,
					"sup_tel"=>$sup_tel,
					"sup_address"=>$sup_address,
					"provinceID"=>$provinceID,
					"districtID"=>$districtID,
					"subDistrictID"=>$subDistrictID,
					"zipcode"=>$zipcode,
					"note"=>$note,
					"namesale"=>$namesale,
					"lastnamesale"=>$lastnamesale,
					"mobilesale"=>$mobilesale,
					"idline"=>$idline,
					"name_nospace"=>str_replace(" ","",$sup_name),
				);

				 $db->db_update($tb1,$fields, " supID = '".$supID."'");
				 $detail = "แก้ไขข้อมูลคู่ค้า/บริษัท ".$sup_name;
				 save_log($detail);

				$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;

	case "delete" :
		try{
			$db->db_delete($tb1, " supID = '".$supID."'");
			$detail = "ลบข้อมูลคู่ค้า/บริษัท ".$sup_name;
			save_log($detail);
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;

}

?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="act" name="act" value="<?php echo $act;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
