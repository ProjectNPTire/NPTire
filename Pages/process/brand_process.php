<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];
$brandID = $_REQUEST['brandID'];


$tb1 = 'tb_brand';

switch($proc){
	case "add" :
	try{


		unset($fields);
		$fields = array(
			"brandName"=>$brandName,
			"brandName_short"=>$brandName_short,
			"brandDetail"=>$brandDetail,
			"name_nospace"=>str_replace(" ","",$brandName),
			"productTypeID"=>$hdfproductTypeID,
			"isEnabled"=>$hdfstatus,
						//"name_nospace"=>str_replace(" ","",$brandName),

		);
				//print_pre($fields);
		
		$db->db_insert($tb1,$fields);
		$detail = 'เพิ่มข้อมูลยี่ห้อ : '.$brandName;
		save_log($detail);
//exit;
		$text=$save_proc;
	}catch(Exception $e){
		$text=$e->getMessage();
	}
	break;
	case "edit" :
	try{

		unset($fields);
		$fields = array(
			"brandName"=>$brandName,
			"brandName_short"=>$brandName_short,
			"brandDetail"=>$brandDetail,
			"name_nospace"=>str_replace(" ","",$brandName),
			"productTypeID"=>$hdfproductTypeID,
			"isEnabled"=>$hdfstatus,
		);

		$db->db_update($tb1,$fields, " brandID = '".$brandID."'");
		$detail = 'แก้ไขข้อมูลยี่ห้อ : '.$brandName;
		save_log($detail);

		$text=$edit_proc;
	}catch(Exception $e){
		$text=$e->getMessage();
	}
	break;

	case "delete" :
	try{

		$sql     = " SELECT *
		FROM ".$tb1."
		where $brandID ='".$brandID."' ";
		$query = $db->query($sql);
		$nums = $db->db_num_rows($query);
		$rec = $db->db_fetch_array($query);
		$detail = 'ลบข้อมูข้อมูลยี่ห้อ  : '.$rec['brandName'];
		save_log($detail);


		$db->db_delete($tb1, " brandID = '".$brandID."'");
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
