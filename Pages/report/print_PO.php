<?php

$path = "../../";
include($path."include/config_header_top.php");
include($path."include/MPDF53/mpdf.php");

//include 'css.php';

$HEADER = '';
$HEAD = "";
echo $SESSION_ID = session_id();
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

global $db;
$sql_po = "SELECT * FROM tb_po WHERE poID = '".$poID."' ";
$query_po = $db->query($sql_po);
$rec_po = $db->db_fetch_array($query_po);

$sql_sup = "SELECT * FROM tb_supplier WHERE supID = '".$rec_po["supID"]."' ";
$query_sup = $db->query($sql_sup);
$rec_sup = $db->db_fetch_array($query_sup);

$sql_user = "SELECT * FROM  tb_user WHERE userID = '".$rec_po["create_by"]."' ";
$query_user = $db->query($sql_user);
$rec_user = $db->db_fetch_array($query_user);

$sql_pd = "SELECT * FROM tb_po_desc WHERE poID = '".$poID."' ";
$query_pd = $db->query($sql_pd);

$poID = $rec_po["poID"];
$sup_name = $rec_sup["sup_name"];
$sup_address = $rec_sup["sup_address"]." ".get_subDistrictID_name($rec_sup["subDistrictID"])." ".get_district_name($rec_sup["districtID"])." ".get_prov_name($rec_sup["provinceID"])." ".$rec_sup["zipcode"];
$sup_tel = $rec_sup["sup_tel"];
$total = $rec_po["total"];
$poDate = $rec_po["poDate"];
$create_by = $rec_user["firstname"]." ".$rec_user["lastname"];
$poStatus = $rec_po["poStatus"];


$HTML = '';

// $HTML .= '<table width="90%" border="0">';
// $HTML .= '<tbody>';
// $HTML .= '<tr>';
// $HTML .= '<td rowspan="2" width="70%"><h1>ใบสั่งซื้อสินค้า</h1></td>';
// $HTML .= '<td width="30%" align="right"><h4>เลขที่ใบสั่งซื้อ : '.$poID.'</h4></td>';
// $HTML .= '</tr>';
// $HTML .= '<tr>';
// $HTML .= '<td width="30%" align="right"><h4>วันที่เอกสาร : '.conv_date($poDate).'</h4></td>';
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
$HTML .= '<td width="30%" align="right" style="vertical-align:top">';
$HTML .= '<h1>ใบสั่งซื้อสินค้า</h1>';
$HTML .= '<h4>เลขที่ใบสั่งซื้อ : '.$poID.'</h4>';
$HTML .= '<h4>วันที่สั่งซื้อ : '.conv_date($poDate).'</h4>';
$HTML .= '</td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<br><br>';

$HTML .= '<table width="85%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '<td width="90%"><b>บริษัทคู่ค้า : </b>'.$sup_name.'</td>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<table width="85%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '<td width="90%">ที่อยู่ '.$sup_address.'</td>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<table width="85%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '<td width="90%">เบอร์โทรศัพท์ '.$sup_tel.'</td>';
// $HTML .= '<td width="5%"></td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<br><br>';

$HTML .= '<table width="90%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
$HTML .= '<td><h4>รายการสินค้าสั่งซื้อ</h4></td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<table width="90%" border="1">';

$HTML .= '<thead>';
$HTML .= '<tr>';
$HTML .= '<th width="10%">ลำดับ</th>';
$HTML .= '<th width="15%">รหัส</th>';
$HTML .= '<th width="35%">สินค้า</th>';
// $HTML .= '<th width="10%">ยี่ห้อ</th>';
// $HTML .= '<th width="10%">รุ่น</th>';
$HTML .= '<th width="5%">ราคา/ชิ้น</th>';
$HTML .= '<th width="5%">จำนวน</th>';
$HTML .= '<th width="10%">รวม</th>';
$HTML .= '</tr>';
$HTML .= '</thead>';

$HTML .= '<tbody>';

$i = 0;
$qty1 = 0;
while($rec_pd = $db->db_fetch_array($query_pd))
{

	$sql_product = "SELECT * FROM tb_product WHERE productID = '".$rec_pd["productID"]."' ";
	$query_product = $db->query($sql_product);
	$rec_product = $db->db_fetch_array($query_product);

	$productID = $rec_pd['productID'];
	$productCode = $rec_product['productCode'];
	$productName = $rec_product['productName'];
	$brandName = get_brand_name($rec_product['brandID']);
	$productSize = $rec_product['productSize'];
	$price = $rec_pd['price'];
	$qty = $rec_pd['qty'];
	$amount = $rec_pd['amount'];
	$qty1 += $qty;

	$HTML .= '<tr>';
	$HTML .= '<td align="center">'.(++$i).'</td>';
	$HTML .= '<td>'.$productCode.'</td>';
	$HTML .= '<td>'.$productName.'</td>';
	// $HTML .= '<td>'.$brandName.'</td>';
	// $HTML .= '<td>'.$productSize.'</td>';
	$HTML .= '<td align="right">'.number_format($price).'</td>';
	$HTML .= '<td align="right">'.number_format($qty).'</td>';
	$HTML .= '<td align="right">'.number_format($amount).'</td>';
	$HTML .= '</tr>';
}


$HTML .= '</tbody>';


$HTML .= '<tfoot>';
$HTML .= '<tr>';
$HTML .= '<td colspan="2">รวม '.$i.' รายการ จำนวน '.$qty1.' ชิ้น</td>';
$HTML .= '<td colspan="4">';
$HTML .= '<div class="row">';
$HTML .= 'รวมสุทธิ(รวมvat)';
$HTML .= '<div class="col-sm-8 text-center">'.convert_bahttext($total).'</div>';
$HTML .= '<div class="col-sm-2 text-right">'.number_format($total).'</div>';
$HTML .= '</div>';
$HTML .= '</td>';
// $HTML .= '<td align="right">''</td>';
// $HTML .= '</tr>';
// $HTML .= '<tr>';
// $HTML .= '<td colspan="6" align="center"></td>';
// // $HTML .= '<td align="right">'.number_format($total).'</td>';
$HTML .= '</tr>';
$HTML .= '</tfoot>';

$HTML .= '</table>';

$HTML .= '<br><br>';

$HTML .= '<table width="90%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
$HTML .= '<td width="50%" align="center">ลงชื่อ ................................</td>';
$HTML .= '<td width="50%" align="center">ลงชื่อ ................................</td>';
$HTML .= '</tr>';
$HTML .= '<tr>';
$HTML .= '<td width="50%" align="center">(          '.$create_by.'          )</td>';
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
