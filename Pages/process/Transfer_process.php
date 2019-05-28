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
					/* "locationTypeID"=>$locationTypeID[$key], */
					"locationID"=>$locationID[$key],
					"billDescUnit"=>str_replace(',','',$billDescUnit[$key]),

				);
				/* echo "<pre>";
				print_r($fields);
				echo "</pre>";
				exit; */
								//print_pre($fields);
				$db->db_insert($tb2,$fields);
				$sql_head    = " SELECT * FROM tb_product  where  productID = '".$value."' ";
				$query_head = $db->query($sql_head);
				$rec_head = $db->db_fetch_array($query_head);
				$total = $rec_head['productUnit'] - (str_replace(',','',$billDescUnit[$key]));

				$db->db_update('tb_product',array('productUnit'=>$total),"productID = '".$value."'");

				$sql_sub     = " SELECT * FROM tb_productstore  where locationID ='".$locationID[$key]."' and productID = '".$value."' ";
				// echo  "<pre>";
				// print_r($sql_sub);
				// echo "</pre>";
				// exit;
				$query_sub = $db->query($sql_sub);
				$rec_sub = $db->db_fetch_array($query_sub);
				$total_sub = $rec_sub['ps_unit'] - (str_replace(',','',$billDescUnit[$key]));
				$db->db_update('tb_productstore',array('ps_unit'=>$total_sub),"ps_id = '".$rec_sub['ps_id']."'");

				if($rec_head['locationType'] == 3){

					$i = $billDescUnit[$key];
					while ($i > 0) {
					//i = return sql();
					//case 1
						$sql_week = " SELECT runID,unit,week FROM tb_week where productID = '".$value."' order by week limit 1 ";
						$query_week = $db->query($sql_week);
						$rec_week = $db->db_fetch_array($query_week);
					$unit = $rec_week['unit']; //จำนวนที่อายุสินค้าน้อยที่สุด
					if ($i >= $unit) { //ถ้าจำนวนที่รับมามากกว่าหรือเท่าจำนวนของอายุสินค้าน้อย
						$db->db_delete("tb_week", " runID = '".$rec_week['runID']."'"); //ลบrow
						$i = $i - $unit; //จำนวนที่เหลือ
					}else{ // ถ้าจำนวนที่รับมาน้อยกว่าจำนวนที่มีอยู่
						$unit = $unit - $i;
						$db->db_update('tb_week',array('unit'=>$unit),"runID = '".$rec_week['runID']."'"); //อัพเดต
						$i = 0; //สินค้าที่รับมาถูกอัพเดตเรียบร้อย
					}
					unset($fields);
					$fields = array(
						"transID"=>$billID,
						"productID"=>$value,
						"week"=>$rec_week['week'],
						"unit"=>$unit * -1,

					);
					$db->db_insert('tb_temp',$fields);


				}
			}

				// $sum = 0;
								// while ($rec_week = $db->db_fetch_array($query_week)){
				// 	if($billDescUnit[$key] > $rec_week['unit']){
				// 		$sum = $billDescUnit[$key] - $rec_week['unit'];
				// 		$db->db_delete("tb_week", " runID = '".$rec_week['runID']."'");
				// 	}else{
				// 		$sum = $billDescUnit[$key];
				// 		$db->db_update('tb_week',array('unit'=>$rec_week['unit']-$sum),"runID = '".$rec_week['runID']."'");
				// 	}
				// }

				// $sql_week = " SELECT runID,unit FROM tb_week where productID = '".$value."' order by week ";
				// $query_week = $db->query($sql_week);

				// $num_sell = $billDescUnit[$key];
				// $data = array();
				// $ = 1;
				// while ($rec_week = $db->db_fetch_array($query_week)){
				// 	if($num_sell > 0){
				// 		if($rec_week['unit'] < $num_sell){
				// 			$data[$i]['runID'] = $rec_week['runID'];
				// 			$data[$i]['unit'] = $rec_week['unit'];
				// 			$num_sell = $num_sell - $rec_week['unit'];

				// 			$db->db_update('tb_week',array('unit'=>$num_sell),"runID = '".$rec_week['runID']."'");
				// 			$i++;
				// 		}else{
				// 			$data[$i]['id'] = $rec_week['runID'];
				// 			$data[$i]['unit'] = $rec_week['unit'];
				// 			break;
				// 		}
				// 	}
				// 	// else{
				// 	// 	break;
				// 	// }
				// }

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

			$sql_s     = " SELECT *  FROM tb_productstore where productID ='".$rec_sub['productID']."' and locationID = '".$rec_sub['locationID']."' and locationTypeID = '".$rec_sub['locationTypeID']."'";
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

		$sql_temp     = " SELECT * FROM tb_temp  where transID ='".$billID."' ";
		$query_temp = $db->query($sql_temp);

		
		while ($rec_temp = $db->db_fetch_array($query_temp)) {

			$sql_p = " SELECT *  FROM tb_week where productID ='".$rec_temp['productID']."' and week ='".$rec_temp['week']."' ";
			// echo  "<pre>";
			// 	print_r($sql_p);
			// 	echo "</pre>";
			// 	exit;
			$query_p = $db->query($sql_p);
			$num_p = $db->db_num_rows($query_p);

			if ($num_p > 0) {
				$rec_p = $db->db_fetch_array($query_p);
				$db->db_update('tb_week',array('unit'=>abs($rec_temp['unit'])+$rec_p['unit']),"productID = '".$rec_temp['productID']."' and week = '".$rec_temp['week']."' ");
			}else{
				unset($fields);
				$fields = array(
					"productID"=>$rec_temp['productID'],
					"week"=>$rec_temp['week'],
					"unit"=>abs($rec_temp['unit']),

				);
				$db->db_insert('tb_week',$fields);
			}

		}

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
