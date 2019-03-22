<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");
//$path_pic = $path."file_img/";
$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];
$locationID = $_REQUEST['locationID'];
//$userID = $_REQUEST['userID'];
//$img = $_FILES['img'];

$tb1 = 'tb_location';

switch($proc){
	case "add" :
		try{
				unset($fields);
				$fields = array(
						//"locationID"=>$locationID,
						"locationCode"=>$locationCode,
						"locationName"=>$locationName,
						"name_nospace"=>str_replace(" ","",$locationName),
				);
				//print_pre($fields);
				 $db->db_insert($tb1,$fields);
				 $detail = "เพิ่มข้อมูลตำแหน่งสินค้า ".$locationName;
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
					//"locationID"=>$locationID,
					"locationCode"=>$locationCode,
					"locationName"=>$locationName,
					"name_nospace"=>str_replace(" ","",$locationName),
				);

				 $db->db_update($tb1,$fields, " locationID = '".$locationID."'");
				 $detail = "แก้ไขข้อมูลตำแหน่งสินค้า locationName : ".$locationName;
				 save_log($detail);

				$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;

	case "delete" :
		try{
			$db->db_delete($tb1, " locationID = '".$locationID."'");
			$detail = "ลบข้อมูลตำแหน่งสินค้า locationName : ".$locationName;
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
