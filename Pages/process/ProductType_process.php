<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];
$productTypeID = $_REQUEST['productTypeID'];


$tb1 = 'tb_producttype';

switch($proc){
	case "add" :
		try{


				unset($fields);
				$fields = array(
						"productTypeName"=>$productTypeName,
						"productTypeDetail"=>$productTypeDetail,
						"productTypeCode"=>$productTypeCode,
						"productTypeNameShort"=>$productTypeNameShort,
						"name_nospace"=>str_replace(" ","",$productTypeName),

				);
				 //print_pre($fields);
				 $db->db_insert($tb1,$fields);
				 $detail = 'เพิ่มข้อมูลประเภท : '.$productTypeName;
				 save_log($detail);
			$text=$save_proc;
				//exit;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;

	case "edit" :
		try{

				unset($fields);
				$fields = array(
					"productTypeName"=>$productTypeName,
					"productTypeDetail"=>$productTypeDetail,
					'productTypeCode'=>$productTypeCode,
					'productTypeNameShort'=>$productTypeNameShort,
					"name_nospace"=>str_replace(" ","",$productTypeName),
				);

				 $db->db_update($tb1,$fields, " productTypeID = '".$productTypeID."'");

				 $detail = 'แก้ไขข้อมูลประเภท : '.$productTypeName;
 				save_log($detail);

				$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;

	case "delete" :
		try{
			$detail = 'ลบข้อมูข้อมูลยี่ห้อ  : '.$rec['productTypeName'];
			 save_log($detail);
			$db->db_delete($tb1, " productTypeID = '".$productTypeID."'");
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
