<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

$url_back = '../'.$_REQUEST['form_page'];
$proc = $_REQUEST['proc'];

$tb1 = 'tb_po';
$tb2 = 'tb_po_desc';

switch($proc){
	case "add" :
		try{

            $po_ym = "PO-".date("ym");

            $sql_po_no = "SELECT COUNT(*) AS poID FROM tb_po WHERE poID like '".$po_ym."%' ";
            $query_po_no = $db->query($sql_po_no);
            $rec_po_no = $db->db_fetch_array($query_po_no);
            $run_no = sprintf("%03d", ($rec_po_no['poID']+1));

            $poID = $po_ym.$run_no;

			unset($fields);
			$fields = array(
				"poID"=>$poID,
				"supID"=>$_POST['supID'],
				"total"=>$_POST['total'],
				"poDate"=>date("Y-m-d"),
				"create_by"=>$_SESSION["sys_id"],
				"poStatus"=>1,
			);

            $db->db_insert($tb1,$fields);

            foreach ($_POST['productID'] as $key => $value) {
                unset($fields);
                $fields = array(
                    "poID"=>$poID,
                    "productID"=>$_POST['productID'][$key],
                    "price"=>$_POST['price'][$key],
                    "qty"=>$_POST['qty'][$key],
                    "amount"=>($_POST['qty'][$key]*$_POST['price'][$key]),
                );

                $db->db_insert($tb2,$fields);
            }

            $detail = "เพิ่มข้อมูลการสั่งซื้อสินค้า :".$poID;
			save_log($detail);

			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;

	case "cancel":
		try{

			$fields = array(
			 	"poStatus"=>99,
			 	"cancelBy"=>$_SESSION['sys_name'],
			 	"cancelDate"=>date('Y-m-d'),
			 	"cancelUserID"=>$_SESSION['sys_id'],
			 );

			$db->db_update($tb1,$fields, " poID = '".$poID."'");

			$detail = "ยกเลิกเอกสาร ".$poID;
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
