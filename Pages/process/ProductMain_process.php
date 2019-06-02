<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$path_pic = $path."file_productImg/";

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];
$productID = $_REQUEST['productID'];
$productImg = $_FILES['productImg'];
//print_pre($_POST); exit;
$tb1 = 'tb_product';
$tb2 = 'tb_productstore';

switch($proc){
	case "add" :
	try{

		if ($productImg["size"]>0) {
			$tmp_name = $productImg["tmp_name"];
			$type_pic =  explode(".",$productImg["name"]);
			$name = date('YmdHis').".".$type_pic[1];
			copy($tmp_name,$path_pic.$name);
			@unlink($path_pic.$old_file);
		}else{
			$name = $old_file;
		}

		$urlString = '175/65R14 82H';
		$width = explode("/",$productSize);
		$series = explode("R",$width[1]);

		unset($fields);
		$fields = array(
			"productCode"=>$productCode,
			"productName"=>$productName,
			"name_nospace"=>str_replace(" ","",$productName),
			"productTypeID"=>1,
			"brandID"=>$hdfbrandID,
			"locationType"=>$hdflocationType,
			"productImg"=>$name,
			"orderPoint"=>$orderPoint,
			"productUnit"=>str_replace(",","",$productUnit),
			"unitID"=>$hdfunitID,
			"isEnabled"=>$hdfstatus,
			"productDetail"=>$productDetail,
			"width"=>$width[0],
			"series"=>$series[0],
			"diameter"=>$series[1],
			"model"=>$model,
		);
		$productID = $db->db_insert($tb1,$fields,'y');

		if(sizeof($locationID)>0){
			foreach ($locationID as $key => $value) {
				unset($fields);
				$fields = array(
					"productID"=>$productID,
					"locationID"=>$value,
					"ps_unit"=>$ps_unit[$key],

				);
				$db->db_insert($tb2,$fields);

			}
		}
		$detail = 'เพิ่มข้อมูลสินค้า  : '.$productName;
		save_log($detail);
		$text=$save_proc;
	}catch(Exception $e){
		$text=$e->getMessage();
	}
	break;

	case "edit" :
	try{

		if ($productImg["size"]>0) {
			$tmp_name = $productImg["tmp_name"];
			$type_pic =  explode(".",$productImg["name"]);
			$name = date('YmdHis').".".$type_pic[1];
			copy($tmp_name,$path_pic.$name);
			@unlink($path_pic.$old_file);
		}else{
			$name = $old_file;
		}
		unset($fields);
		$fields = array(
			"productCode"=>$productCode,
			"productName"=>$productName,
			"name_nospace"=>str_replace(" ","",$productName),
			"productTypeID"=>1,
			"brandID"=>$hdfbrandID,
			"locationType"=>$hdflocationType,
			"productImg"=>$name,
			"orderPoint"=>$orderPoint,
			"productUnit"=>str_replace(",","",$productUnit),
			"unitID"=>$hdfunitID,
			"isEnabled"=>$hdfstatus,
			"productDetail"=>$productDetail,
			"width"=>$width[0],
			"series"=>$series[0],
			"diameter"=>$series[1],
			"model"=>$model,
		);

		$db->db_update($tb1,$fields, " productID = '".$productID."'");
		$db->db_delete($tb2, " productID = '".$productID."'");
		if(sizeof($locationID)>0){
			foreach ($locationID as $key => $value) {
				unset($fields);
				$fields = array(
					"productID"=>$productID,
					"locationID"=>$value,
					"ps_unit"=>$ps_unit[$key],

				);
				$db->db_insert($tb2,$fields);

			}
		}

		$detail = 'แก้ไขข้อมูลสินค้า : '.$productName;
		save_log($detail);

		$text=$edit_proc;
	}catch(Exception $e){
		$text=$e->getMessage();
	}
	break;

	case "delete" :
	try{
		$sql     = " SELECT *
		FROM $tb1
		where productID ='".$productID."' ";
		$query = $db->query($sql);
		$nums = $db->db_num_rows($query);
		$rec = $db->db_fetch_array($query);

		$detail = 'แก้ไขข้อมูลสินค้า  : '.$rec['productName'];
		save_log($detail);

		$db->db_delete($tb1, " productID = '".$productID."'");
		$db->db_delete($tb2, " productID = '".$productID."'");
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
