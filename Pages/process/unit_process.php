<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];
$unitID = $_REQUEST['unitID'];


$tb1 = 'tb_unit';

switch($proc){
	case "add" :
	try{


		unset($fields);
		$fields = array(
			"unitCode"=>strtoupper($unitCode),
			"unitName"=>$unitName,
			"name_nospace"=>str_replace(" ","",$unitName),
			"isEnabled"=>$hdfstatus,

		);
		$unitID = $db->db_insert($tb1,$fields,'y');


		$detail = 'เพิ่มข้อมูลหน่วย : '.$unitName;
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
			"unitCode"=>strtoupper($unitCode),
			"unitName"=>$unitName,
			"name_nospace"=>str_replace(" ","",$unitName),
			"isEnabled"=>$hdfstatus,
		);

		$db->db_update($tb1,$fields, " unitID = '".$unitID."'");

		$detail = 'แก้ไขข้อมูลหน่วย : '.$unitName;
		save_log($detail);

		$text=$edit_proc;
	}catch(Exception $e){
		$text=$e->getMessage();
	}
	break;

	case "delete" :
	try{
		$detail = 'ยกเลิกข้อมูลหน่วย  : '.$rec['unitName'];
		save_log($detail);
		$db->db_delete($tb1, " unitID = '".$unitID."'");
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
