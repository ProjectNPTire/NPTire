<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");


$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];

$tb1 = 'tb_bill';
$tb2 = 'tb_bill_desc';

switch($proc){
	case "add" :
		try{

				$sql_no = "SELECT billNo from {$tb1} where billNo like 'BO-".date('Ym')."%' order by billID desc";
				$query_no = $db->query($sql_no);
				$nums_no = $db->db_num_rows($query_no);
				$rec_no=$db->db_fetch_array($query_no);
				if($nums_no>0){
					$no = substr($rec_no['billNo'],9);
				}else{
					$no =0;
				}
					$new_no =  'BO-'.date('Ym').sprintf("%'.03d",((int)($no)+1));
				
			
				unset($fields);
				$fields = array(
						"billNo"=>$new_no,
						"billBy"=>$billBy,
						"billDate"=>date("Y-m-d"),
						"create_by"=>$_SESSION['sys_id'],
						"billStstus"=>1,
						
				);
				//print_pre($fields);
			 		$billID = $db->db_insert($tb1,$fields,'y');

					if(sizeof($productID)>0){
							foreach ($productID as $key => $value) {
								unset($fields);
								$fields = array(
									"billID"=>$billID,
									"productID"=>$value,
									"locationID"=>$locationID[$key],
									"billDescUnit"=>str_replace(',','',$billDescUnit[$key]),

								);
								//print_pre($fields);
								$db->db_insert($tb2,$fields);
								 $sql_head    = " SELECT * FROM tb_product  where  productID = '".$value."' ";
								 $query_head = $db->query($sql_head);
								 $rec_head = $db->db_fetch_array($query_head);
								 $total = $rec_head['productUnit'] - (str_replace(',','',$billDescUnit[$key]));

								 $db->db_update('tb_product',array('productUnit'=>$total),"productID = '".$value."'");

								 $sql_sub     = " SELECT * FROM tb_productstore  where locationID ='".$locationID[$key]."' and productID = '".$value."' ";
								 $query_sub = $db->query($sql_sub);
								 $rec_sub = $db->db_fetch_array($query_sub);
								 $total_sub = $rec_sub['ps_unit'] - (str_replace(',','',$billDescUnit[$key]));
								 $db->db_update('tb_productstore',array('ps_unit'=>$total_sub),"ps_id = '".$rec_sub['ps_id']."'");




							}
					}
			 			$detail = 'เพิ่มข้อมูลการเบิกสินค้า  : '.$new_no;
					save_log($detail);
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	

	case "cancel" :
		try{
			
			 $sql_sub     = " SELECT * FROM $tb2  where billID ='".$billID."' ";
			 $query_sub = $db->query($sql_sub);
			 while ($rec_sub = $db->db_fetch_array($query_sub)) {
			 	
			 			 $sql_p     = " SELECT *  FROM tb_product where productID ='".$rec_sub['productID']."' ";
						 $query_p = $db->query($sql_p);
						 $rec_p = $db->db_fetch_array($query_p);

						 $total = $rec_p['productUnit'] + $rec_sub['billDescUnit'];
						 $db->db_update('tb_product',array('productUnit'=>$total),"productID = '".$rec_sub['productID']."'");

						 $sql_s     = " SELECT *  FROM tb_productstore where productID ='".$rec_sub['productID']."' and locationID = '".$rec_sub['locationID']."'";
						 $query_s = $db->query($sql_s);
						 $rec_s = $db->db_fetch_array($query_s);

						 $total_sub = $rec_s['ps_unit'] + $rec_sub['billDescUnit'];
						$db->db_update('tb_productstore',array('ps_unit'=>$total_sub),"ps_id = '".$rec_s['ps_id']."'");



			 }

			 $sql     = " SELECT *
								 FROM $tb1
								 where billID ='".$billID."' ";
			 $query = $db->query($sql);
			 $rec = $db->db_fetch_array($query);
			 


			 $fields = array(
			 	"billStstus"=>2,
			 	"cancelBy"=>$_SESSION['sys_name'],
			 	"cancelDate"=>date('Y-m-d'),
			 	"cancelUserID"=>$_SESSION['sys_id'],
			 );
			$db->db_update($tb1,$fields,"billID = '".$billID."'");

			$detail = 'ยกเลิกข้อมูลการเบิกสินค้า  : '.$rec['billNo'];
			save_log($detail);

			//$db->db_delete($tb1, " productID = '".$productID."'");
			//$db->db_delete($tb2, " productID = '".$productID."'");
			$text=$cancle_proc;
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
