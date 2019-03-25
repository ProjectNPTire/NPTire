<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];

$tb1 = 'tb_receive';
$tb2 = 'tb_receive_desc';
$tb3 = 'tb_productstore';
$tb4 = 'tb_product';
$tb5 = 'tb_po';
$tb6 = 'tb_po_desc';

switch($proc){
	case "add" :
		try{

            $re_ym = "RE-".date("ym");

            $sql_re_no = "SELECT COUNT(*) AS receiveID FROM tb_receive WHERE receiveID like '".$re_ym."%' ";
            $query_re_no = $db->query($sql_re_no);
            $rec_re_no = $db->db_fetch_array($query_re_no);
            $run_no = sprintf("%04d", ($rec_re_no['receiveID']+1));

            $receiveID = $re_ym.$run_no;

			unset($fields);
			$fields = array(
                "receiveID"=>$receiveID,
				"poID"=>$_POST['poID'],
				"receiveDate"=>date("Y-m-d"),
                "create_by"=>$_SESSION["sys_id"],
				"receiveStatus"=>1,
			);

            $db->db_insert($tb1,$fields);

            $arr_product_remain = array();
            unset($arr_product_remain);

            foreach ($_POST['qty'] as $key => $value) {
                unset($fields);
                $fields = array(
                    "receiveID"=>$receiveID,
                    "poID"=>$_POST['poID'],
                    "locationID"=>$_POST['locationID'][$key],
                    "productID"=>$key,
                    "qty"=>$_POST['qty'][$key],
					"cancelFlag"=>0
                );

                $db->db_insert($tb2,$fields);

                $sql_inv = "SELECT * FROM tb_productstore WHERE productID = '".$key."' AND locationID = '".$_POST["locationID"][$key]."' ";
                $query_inv = $db->query($sql_inv);
                $nums = $db->db_num_rows($query_inv);
                $rec_inv = $db->db_fetch_array($query_inv);

                if($nums > 0){
                    // update
                    unset($fields);
                    $fields = array(
                        "ps_unit"=>($rec_inv['ps_unit'] + $_POST['qty'][$key]),
                    );

                    $db->db_update($tb3,$fields, " productID = '".$key."' AND locationID = '".$_POST['locationID'][$key]."' ");
                }
                else{
                    // insert
                    unset($fields);
                    $fields = array(
                        "productID"=>$key,
                        "locationID"=>$_POST['locationID'][$key],
                        "ps_unit"=>$_POST['qty'][$key],
                    );

                    $db->db_insert($tb3,$fields);
                }

                $sql_check_received = "SELECT SUM(qty) AS sum_received FROM tb_receive_desc WHERE productID = '".$key."' AND pOID = '".$_POST["poID"]."' AND cancelFlag = '0' ";
                $query_check_received = $db->query($sql_check_received);
                $rec_check_received = $db->db_fetch_array($query_check_received);

                $sql_po_desc = "SELECT * FROM tb_po_desc WHERE productID = '".$key."' AND poID = '".$_POST["poID"]."' ";
                $query_po_desc = $db->query($sql_po_desc);
                $rec_po_desc = $db->db_fetch_array($query_po_desc);

                if($rec_check_received['sum_received'] != $rec_po_desc['qty']) $arr_product_remain[] = 1;

            }
            foreach ($_POST['qty'] as $key => $value) {

            $sql_cnt_product = "SELECT SUM(ps_unit) AS sum_ps_unit FROM tb_productstore WHERE productID = '".$key."' ";
            $query_cnt_product = $db->query($sql_cnt_product);
            $rec_cnt_product = $db->db_fetch_array($query_cnt_product);

            $sum_ps_unit = ($rec_cnt_product['sum_ps_unit']=='') ? 0 : $rec_cnt_product['sum_ps_unit'];

            
                unset($fields);
                $fields = array(
                    "productUnit"=>$sum_ps_unit,
                );

                $db->db_update($tb4,$fields, " productID = '".$key."'");
            }

            if(count($arr_product_remain) > 0){
                unset($fields);
                $fields = array(
                    "poStatus"=>2,
                );

                $db->db_update($tb5,$fields, " poID = '".$_POST['poID']."'");
            }
            else{
                unset($fields);
                $fields = array(
                    "poStatus"=>3,
                );

                $db->db_update($tb5,$fields, " poID = '".$_POST['poID']."'");
            }

            $detail = "เพิ่มข้อมูลการรับเข้าสินค้า :".$receiveID;
			save_log($detail);

			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;

	case "cancel":
		try{

			$sql_receive = "SELECT * FROM tb_receive WHERE receiveID = '".$_POST["receiveID"]."' ";
			$query_receive = $db->query($sql_receive);
			$rec_receive = $db->db_fetch_array($query_receive);

            unset($fields);
			$fields = array(
				"receiveStatus"=>99
			);

			$db->db_update($tb1,$fields, " receiveID = '".$_POST['receiveID']."'");



            $sql_receive_desc = "SELECT * FROM tb_receive_desc WHERE receiveID = '".$_POST["receiveID"]."' ";
			$query_receive_desc = $db->query($sql_receive_desc);

			$arr_product_remain = array();
            unset($arr_product_remain);

            while($rec_receive_desc = $db->db_fetch_array($query_receive_desc)){

				unset($fields);
	            $fields = array(
	                "cancelFlag"=>1,
	            );

	            $db->db_update($tb2,$fields, " productID = '".$rec_receive_desc["productID"]."' AND receiveID = '".$rec_receive_desc["receiveID"]."' ");

				$sql_inv = "SELECT * FROM tb_productstore WHERE productID = '".$rec_receive_desc["productID"]."' AND locationID = '".$rec_receive_desc["locationID"]."' ";
                $query_inv = $db->query($sql_inv);
				// $nums = $db->db_num_rows($query_inv);
                $rec_inv = $db->db_fetch_array($query_inv);

				unset($fields);
                $fields = array(
                    "ps_unit"=>($rec_inv["ps_unit"] - $rec_receive_desc["qty"]),
                );

				$db->db_update($tb3,$fields, " productID = '".$rec_receive_desc["productID"]."' AND locationID = '".$rec_receive_desc["locationID"]."' ");

				$sql_cnt_product = "SELECT SUM(ps_unit) AS sum_ps_unit FROM tb_productstore WHERE productID = '".$rec_receive_desc["productID"]."' ";
	            $query_cnt_product = $db->query($sql_cnt_product);
	            $rec_cnt_product = $db->db_fetch_array($query_cnt_product);

				unset($fields);
	            $fields = array(
	                "productUnit"=>$rec_cnt_product['sum_ps_unit'],
	            );

	            $db->db_update($tb4,$fields, " productID = '".$rec_receive_desc["productID"]."'");

				$sql_check_received = "SELECT SUM(qty) AS sum_received FROM tb_receive_desc WHERE productID = '".$rec_receive_desc["productID"]."' AND pOID = '".$rec_receive_desc["poID"]."' AND cancelFlag = '0' ";
                $query_check_received = $db->query($sql_check_received);
                $rec_check_received = $db->db_fetch_array($query_check_received);

                $sql_po_desc = "SELECT * FROM tb_po_desc WHERE productID = '".$rec_receive_desc["productID"]."' AND pOID = '".$rec_receive_desc["poID"]."' ";
                $query_po_desc = $db->query($sql_po_desc);
                $rec_po_desc = $db->db_fetch_array($query_po_desc);

                if($rec_check_received['sum_received'] != $rec_po_desc['qty']) $arr_product_remain[] = 1;

			}

			if(count($arr_product_remain) > 0){
                unset($fields);
                $fields = array(
                    "poStatus"=>2,
                );

                $db->db_update($tb5,$fields, " poID = '".$rec_receive['poID']."'");
            }
            else{
                unset($fields);
                $fields = array(
                    "poStatus"=>3,
                );

                $db->db_update($tb5,$fields, " poID = '".$rec_receive['poID']."'");
            }

			$detail = "ยกเลิกเอกสาร ".$_POST['receiveID'];
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
