<?php

$path = "../../";
include($path."include/config_header_top.php");
include($path."include/MPDF53/mpdf.php");

$HEADER = '';
$HEAD = "";
$SESSION_ID = session_id();
$YEAR_CACHE = date('Y');

$img_logo = "../../assets/images/Layer1.png";

$path_cache = 'cache/'.$YEAR_CACHE.'_'.$SESSION_ID.'/';
$pdf = new mPDF('th', 'A4', '0', 'THSaraban',7,7,15,7,'4','4');
$pdf->AddPage();
$CSS = "<style type='text/css'>
				body{
					font-size:9pt;
				}
				table {
					border-collapse:collapse;
					margin-left: auto;
   					margin-right: auto;
				}
				th {
					padding-left:3px;
					padding-bottom:2px;
					padding-top:2px;
				}
				td {
					padding-left:3px;
					padding-bottom:2px;
					padding-top:2px;
				}
			</style> ";
			/*border:solid 1px #000000;
			border:solid 1px #000000;*/

global $db;

 $sql_bill = "SELECT A.*,B.* FROM tb_bill A
			JOIN tb_user B ON A.create_by = B.userID
			 WHERE A.billID = '".$billID."' ";
			
$query_bill = $db->query($sql_bill);
$rec_bill = $db->db_fetch_array($query_bill);

if($rec_bill['billStstus']==1){
	$billStstus = "ปกติ";
	$namecan = "-";
	$datecan = "-";
}else {
	$billStstus = "ยกเลิก";
	
	if($rec_bill['cancelUserID'] ){
		$namecan = $rec_bill["firstname"]." ".$rec_bill["lastname"];
		$datecan = conv_date($rec_bill["cancelDate"]);
		
	}
}
echo $sql_bd = "SELECT * FROM tb_bill_desc WHERE billID = '".$rec_bill["billID"]."' ";
$query_bd = $db->query($sql_bd);

/* 
$sql_po = "SELECT * FROM tb_po WHERE poID = '".$rec_receive["poID"]."' ";
$query_po = $db->query($sql_po);
$rec_po = $db->db_fetch_array($query_po);

$sql_sup = "SELECT * FROM tb_supplier WHERE supID = '".$rec_po["supID"]."' ";
$query_sup = $db->query($sql_sup);
$rec_sup = $db->db_fetch_array($query_sup);

 */
/* 
$poID = $rec_po["poID"];
$sup_name = $rec_sup["sup_name"];
$sup_address = $rec_sup["sup_address"]." ".get_subDistrictID_name($rec_sup["subDistrictID"])." ".get_district_name($rec_sup["districtID"])." ".get_prov_name($rec_sup["provinceID"])." ".$rec_sup["zipcode"];
$sup_tel = $rec_sup["sup_tel"];
// $total = $rec_receive["total"];
$receiveDate = $rec_receive["receiveDate"];
$create_by = $rec_receive["create_by"];
$receiveStatus = $rec_receive["receiveStatus"];
 */
$HTML = '';

// $HTML .= '<table width="90%" border="0">';
// $HTML .= '<tbody>';
// $HTML .= '<tr>';
// $HTML .= '<td rowspan="3" width="65%"><h1>ใบรับสินค้า</h1></td>';
// $HTML .= '<td width="35%" align="right"><h4>เลขที่ใบรับสินค้า : '.$receiveID.'</h4></td>';
// $HTML .= '</tr>';
// $HTML .= '<tr>';
// $HTML .= '<td width="35%" align="right"><h4>เลขที่ใบสั่งซื้อ : '.$rec_po["poID"].'</h4></td>';
// $HTML .= '</tr>';
// $HTML .= '<tr>';
// $HTML .= '<td width="35%" align="right"><h4>วันที่เอกสาร : '.conv_date($receiveDate).'</h4></td>';
// $HTML .= '</tr>';
// $HTML .= '</tbody>';
// $HTML .= '</table>';

$HTML .= '<table width="90%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
$HTML .= '<td width="22%"><img src="'.$img_logo.'"></td>';
$HTML .= '<td>';
$HTML .= 'บริษัท เอ็นพี ไทร์ (ล้อทอง) จำกัด NPTIRE GOLDWHEELS<br>ถนนมีนบุรี-ร่มเกล้า เขตมีนบุรี กรุงเทพฯ 10510<br>';
$HTML .= 'โทร. 02-543-8957, 02-061-5957 , 095-7923290, <br>';
$HTML .= '092-2766964, 081-4384057';
$HTML .= '</td>';
$HTML .= '<td width="40%" align="right" style="vertical-align:top">';
$HTML .= '<h1>ใบเบิกสินค้า</h1>';
$HTML .= '<h4>เลขที่ใบเบิกสินค้า : '.$rec_bill['billNo'].'</h4>';
//$HTML .= '<h4>เลขที่ใบสั่งซื้อ : '.$rec_po["poID"].'</h4>';
$HTML .= '<h4>ชื่อผู้เบิก : '.$rec_bill["firstname"]." ".$rec_bill["lastname"].'</h4>';
$HTML .= '<h4>วันที่เบิกสินค้า : '.conv_date($rec_bill['billDate']).'</h4>';
$HTML .= '</td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<br><br>';

$HTML .= '<table width="85%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '<td width="50%"><b>สถานะ : </b>'.$billStstus.'</td>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<table width="85%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '<td width="90%">ชื่อผู้ยกเลิก : '.$namecan.'</td>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<table width="85%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '<td width="90%">วันที่ยกเลิก : '.$datecan.'</td>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<br><br>';

$HTML .= '<table width="90%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
$HTML .= '<td><h4>รายการการเบิกสินค้า</h4></td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<table width="90%" border="1">';

$HTML .= '<thead>';
$HTML .= '<tr>';
$HTML .= '<th width="5%">ลำดับ</th>';
$HTML .= '<th width="15%">รหัสสินค้า</th>';
$HTML .= '<th width="35%">ชื่อสินค้า</th>';
$HTML .= '<th width="10%">ยี่ห้อสินค้า</th>';
$HTML .= '<th width="10%">สถานที่จัดเก็บ</th>';
// $HTML .= '<th width="10%">รุ่น</th>';
// $HTML .= '<th width="5%">ราคา/ชิ้น</th>';
$HTML .= '<th width="5%">จำนวน</th>';
$HTML .= '<th width="5%">หน่วยนับ</th>';
// $HTML .= '<th width="10%">รวม</th>';
$HTML .= '</tr>';
$HTML .= '</thead>';

$HTML .= '<tbody>';

$i = 0;
$qty1 = 0;
while($rec_bd = $db->db_fetch_array($query_bd))
{

	$sql_product = "SELECT * FROM tb_product WHERE productID = '".$rec_bd["productID"]."' ";
	$query_product = $db->query($sql_product);
	$rec_product = $db->db_fetch_array($query_product);

	$sql_bill_desc = "SELECT * FROM tb_bill_desc WHERE billID = '".$billID."' ";
	$query_bill_desc = $db->query($sql_bill_desc);
	$rec_bill_desc = $db->db_fetch_array($query_bill_desc);
	
	$sql_locat = "SELECT * FROM tb_location WHERE locationID = '".$rec_bill_desc["locationID"]."' ";
	$query_locat = $db->query($sql_locat);
	$rec_locat = $db->db_fetch_array($query_locat);

	$productID = $rec_bd['productID'];
	$productCode = $rec_product['productCode'];
	$productName = $rec_product['productName'];
	$productTypeName = get_productType_name($rec_product['productTypeID']);
	$brandName = get_brand_name($rec_product['brandID']);
	$location = get_location_name($rec_locat['locationID']);

	$qty = $rec_bd['billDescUnit'];
	$unitType= $arr_unitType[$rec_product['unitType']];;
	//$receive_qty = $rec_receive_desc['qty'];
	$qty1 += $qty;
	// $amount = $rec_pd['amount'];

	$HTML .= '<tr>';
	$HTML .= '<td align="center">'.(++$i).'</td>';
	$HTML .= '<td>'.$productCode.'</td>';
	$HTML .= '<td>'.$productName.'</td>';
	$HTML .= '<td>'.$brandName.'</td>';
	$HTML .= '<td>'.$location.'</td>';
	// $HTML .= '<td>'.$productSize.'</td>';
	// $HTML .= '<td align="right">'.number_format($price).'</td>';
	$HTML .= '<td align="right">'.number_format($qty).'</td>';
	$HTML .= '<td align="right">'.$unitType.'</td>';
	// $HTML .= '<td align="right">'.number_format($amount).'</td>';
	$HTML .= '</tr>';
}


$HTML .= '</tbody>';

$HTML .= '<tfoot>';
$HTML .= '<tr>';
$HTML .= '<td colspan="7" align="center">รวม '.$i.' รายการ จำนวน '.$qty1.' ชิ้น</td>';
// $HTML .= '<td align="right">'.number_format($total).'</td>';
$HTML .= '</tr>';
$HTML .= '</tfoot>';

// $HTML .= '<tfoot>';
// $HTML .= '<tr>';
// $HTML .= '<td colspan="7" align="center">รวมสุทธิ</td>';
// $HTML .= '<td align="right">'.number_format($total).'</td>';
// $HTML .= '</tr>';
// $HTML .= '</tfoot>';

$HTML .= '</table>';

$HTML .= '<br><br>';

$HTML .= '<table width="90%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
$HTML .= '<td width="50%" align="center">ลงชื่อ ................................</td>';
$HTML .= '<td width="50%" align="center">ลงชื่อ ................................</td>';
$HTML .= '</tr>';
$HTML .= '<tr>';
$HTML .= '<td width="50%" align="center">(          '.$_SESSION[sys_name].'          )</td>';
$HTML .= '<td width="50%" align="center">(          อโนทัย   ลักษมีอธิคม          )</td>';
$HTML .= '</tr>';
$HTML .= '<tr>';
$HTML .= '<td width="50%" align="center">____/____/____</td>';
$HTML .= '<td width="50%" align="center">____/____/____</td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';


$pdf->WriteHTML($CSS.$HEAD.$HTML);
$pdf->Output();
