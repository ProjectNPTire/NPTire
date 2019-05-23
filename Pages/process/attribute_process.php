<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];
$attrID = $_REQUEST['attrID'];


$tb1 = 'tb_attribute';

switch($proc){
	case "add" :
	try{


		unset($fields);
		$fields = array(
			"attrName"=>$attrName,
			"name_nospace"=>str_replace(" ","",$attrName),
			"isEnabled"=>$hdfstatus,
						//"name_nospace"=>str_replace(" ","",$attrName),

		);
				//print_pre($fields);
		
		$db->db_insert($tb1,$fields);
		$detail = 'เพิ่มข้อมูลคุณลักษณะ : '.$attrName;
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
			"attrName"=>$attrName,
			"name_nospace"=>str_replace(" ","",$attrName),
			"isEnabled"=>$hdfstatus,
		);

		$db->db_update($tb1,$fields, " attrID = '".$attrID."'");
		$detail = 'แก้ไขข้อมูลคุณลักษณะ : '.$attrName;
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
		where $attrID ='".$attrID."' ";
		$query = $db->query($sql);
		$nums = $db->db_num_rows($query);
		$rec = $db->db_fetch_array($query);
		$detail = 'ยกเลิกข้อมูข้อมูลคุณลักษณะ  : '.$rec['attrName'];
		save_log($detail);


		$db->db_delete($tb1, " attrID = '".$attrID."'");
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
