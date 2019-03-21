<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];

$tb1 = 'tb_role';

switch($proc){

	case "edit" :
		try{
				foreach ($menuKey as $key => $value) {

					$sql = "SELECT COUNT(menuKey) AS cnt_menu FROM $tb1 WHERE menuKey = '".$key."'";
					$query = $db->query($sql);
					$rec = $db->db_fetch_array($query);

					if($rec['cnt_menu'] > 0)
					{
						// edit
						unset($fields);
						$fields = array(
		                    "isAdd" => ${"isAdd".$key},
		                    "isEdit" => ${"isEdit".$key},
		                    "isDel" => ${"isDel".$key},
		                    "isSearch" => ${"isSearch".$key},
							//"menuKey" => $key,
						);

						$db->db_update($tb1,$fields, " menuKey = '".$key."'");
					}
					else
					{
						// insert
						unset($fields);
						$fields = array(
		                    "isAdd" => ${"isAdd".$key},
		                    "isEdit" => ${"isEdit".$key},
		                    "isDel" => ${"isDel".$key},
		                    "isSearch" => ${"isSearch".$key},
							"menuKey" => $key,
						);

						$db->db_insert($tb1,$fields);
					}
				}

				 $detail = "อัพเดตสิทธิ์การใช้งาน";
				 save_log($detail);

				$text=$save_proc;
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
