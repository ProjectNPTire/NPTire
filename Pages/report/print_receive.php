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
// echo $receiveID;
// exit;
$sql_receive = "SELECT * FROM tb_receive WHERE receiveID = '".$receiveID."' ";
$query_receive = $db->query($sql_receive);
$rec_receive = $db->db_fetch_array($query_receive);

$sql_po = "SELECT * FROM tb_po WHERE poID = '".$rec_receive["poID"]."' ";
$query_po = $db->query($sql_po);
$rec_po = $db->db_fetch_array($query_po);

$sql_sup = "SELECT * FROM tb_supplier WHERE supID = '".$rec_po["supID"]."' ";
$query_sup = $db->query($sql_sup);
$rec_sup = $db->db_fetch_array($query_sup);

$sql_pd = "SELECT * FROM tb_po_desc WHERE poID = '".$rec_receive["poID"]."' ";
$query_pd = $db->query($sql_pd);

$poID = $rec_po["poID"];
$sup_name = $rec_sup["sup_name"];
$sup_address = $rec_sup["sup_address"]." ".get_subDistrictID_name($rec_sup["subDistrictID"])." ".get_district_name($rec_sup["districtID"])." ".get_prov_name($rec_sup["provinceID"])." ".$rec_sup["zipcode"];
$sup_tel = $rec_sup["sup_tel"];
// $total = $rec_receive["total"];
$receiveDate = $rec_receive["receiveDate"];
$create_by = $rec_receive["create_by"];
$receiveStatus = $rec_receive["receiveStatus"];

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

$HTML .= '<table width="100%" border="0">';
$HTML .= '<tbody>';
$HTML .= '<tr>';
$HTML .= '<td width="20%"><img src="'.$img_logo.'"></td>';
$HTML .= '<td>';
$HTML .= 'บริษัท เอ็นพี ไทร์ (ล้อทอง) จำกัด NPTIRE GOLDWHEELS<br>ถนนมีนบุรี-ร่มเกล้า เขตมีนบุรี กรุงเทพฯ 10510<br>';
$HTML .= 'โทร. 02-543-8957, 02-061-5957 , 095-7923290, <br>';
$HTML .= '092-2766964, 081-4384057';
$HTML .= '</td>';
$HTML .= '<td width="35%" align="right" valign="top">';
$HTML .= '<h1>ใบรับสินค้า</h1>';
$HTML .= '<h4>เลขที่ใบรับสินค้า : '.$receiveID.'</h4>';
$HTML .= '<h4>เลขที่ใบสั่งซื้อ : '.$rec_po["poID"].'</h4>';
$HTML .= '<h4>วันที่รับสินค้า : '.conv_date($receiveDate).'</h4>';
$HTML .= '</td>';
$HTML .= '</tr>';
$HTML .= '</tbody>';
$HTML .= '</table>';

$HTML .= '<br><br>';

// $HTML .= '<table width="85%" border="0">';
// $HTML .= '<tbody>';
// $HTML .= '<tr>';
// $HTML .= '<td width="5%"></td>';
// $HTML .= '<td width="90%"><b>บริษัทคู่ค้า : </b>'.$sup_name.'</td>';
// $HTML .= '<td width="5%"></td>';
// $HTML .= '</tr>';
// $HTML .= '</tbody>';
// $HTML .= '</table>';

// $HTML .= '<table width="85%" border="0">';
// $HTML .= '<tbody>';
// $HTML .= '<tr>';
// // $HTML .= '<td width="5%"></td>';
// $HTML .= '<td width="90%">ที่อยู่ '.$sup_address.'</td>';
// // $HTML .= '<td width="5%"></td>';
// $HTML .= '</tr>';
// $HTML .= '</tbody>';
// $HTML .= '</table>';

// $HTML .= '<table width="85%" border="0">';
// $HTML .= '<tbody>';
// $HTML .= '<tr>';
// // $HTML .= '<td width="5%"></td>';
// $HTML .= '<td width="90%">เบอร์โทรศัพท์ '.$sup_tel.'</td>';
// // $HTML .= '<td width="5%"></td>';
// $HTML .= '</tr>';
// $HTML .= '</tbody>';
// $HTML .= '</table>';

// $HTML .= '<br><br>';

// $HTML .= '<table width="90%" border="0">';
// $HTML .= '<tbody>';
// $HTML .= '<tr>';
// $HTML .= '<td><h4>รายการรับเข้าสินค้า</h4></td>';
// $HTML .= '</tr>';
// $HTML .= '</tbody>';
// $HTML .= '</table>';

$HTML .= '<table class="table table-bordered" width="100%" border="1" valign="top">';

$HTML .= '<thead>';
$HTML .= '<tr>';
$HTML .= '<th>ลำดับ</th>';
$HTML .= '<th>รหัสสินค้า</th>';
$HTML .= '<th>ชื่อสินค้า</th>';
$HTML .= '<th>ประเภท</th>';
$HTML .= '<th>ยี่ห้อ</th>';
$HTML .= '<th>คุณลักษณะ</th>';
$HTML .= '<th>ประเภทตำแหน่งเก็บ</th>';
$HTML .= '<th>ตำแหน่งเก็บ</th>';
$HTML .= '<th>จำนวน</th>';
$HTML .= '<th>รับเข้า</th>';
$HTML .= '</tr>';
$HTML .= '</thead>';

$HTML .= '<tbody>';

$i = 0;
$qty1 = 0;
while($rec_pd = $db->db_fetch_array($query_pd))
{

	$sql_product = "SELECT tb_productstore.*,tb_locationtype.locationTypeName,tb_location.locationName
	,tb_product.productName,tb_product.productCode,tb_product.productTypeID,tb_product.brandID
	FROM  tb_productstore 
	JOIN tb_locationtype ON tb_productstore.locationTypeID = tb_locationtype.locationTypeID 
	JOIN tb_location ON tb_productstore.locationID = tb_location.locationID
	JOIN tb_product ON tb_productstore.productID = tb_product.productID
        WHERE tb_productstore.productID = '".$rec_pd["productID"]."' ";
        $query_product = $db->query($sql_product);
        $rec_product = $db->db_fetch_array($query_product);

	$sql_receive_desc = "SELECT * FROM tb_receive_desc WHERE receiveID = '".$receiveID."' and productID = '".$rec_pd["productID"]."' ";
	$query_receive_desc = $db->query($sql_receive_desc);
	$rec_receive_desc = $db->db_fetch_array($query_receive_desc);

	$sql_attr = "SELECT tb_attribute.attrName, tb_productattr.value
	FROM tb_productattr JOIN tb_attribute ON tb_productattr.attrID = tb_attribute.attrID
	WHERE productID = '".$rec_pd["productID"]."'";
	$query_attr = $db->query($sql_attr);
	$nums_attr = $db->db_num_rows($query_attr);

	$attr = '';

	if($nums_attr > 0){
		while($rec_attr = $db->db_fetch_array($query_attr))
		{
			$attr .= $rec_attr['attrName'].": ".$rec_attr['value']."<br>";
		}
	}else{
		$attr = '-';
	}

	$productID = $rec_pd['productID'];
	$productTypeName = get_productType_name($rec_product['productTypeID']);
	$brandName = get_brand_name($rec_product['brandID']);
	$modelName = $rec_product['modelName'];
	$productSize = $rec_product['productSize'];
	// $price = $rec_pd['price'];
	$qty = $rec_pd['qty'];
	$receive_qty = $rec_receive_desc['qty'];
	$qty1 += $qty;
	// $amount = $rec_pd['amount'];

	$HTML .= '<tr>';
	$HTML .= '<td align="center">'.(++$i).'</td>';
	$HTML .= '<td>'.$rec_product['productCode'].'</td>';
	$HTML .= '<td>'.$rec_product['productName'].'</td>';
	$HTML .= '<td>'.get_productType_name($rec_product['productTypeID']).'</td>';
	$HTML .= '<td>'.get_brand_name($rec_product['brandID']).'</td>';
	$HTML .= '<td>'.$attr.'</td>';
	$HTML .= '<td>'.$rec_product['locationTypeName'].'</td>';
	$HTML .= '<td>'.$rec_product['locationName'].'</td>';
	$HTML .= '<td align="right">'.number_format($qty).'</td>';
	$HTML .= '<td align="right">'.number_format($receive_qty).'</td>';
	$HTML .= '</tr>';
}


$HTML .= '</tbody>';

$HTML .= '<tfoot>';
$HTML .= '<tr>';
$HTML .= '<td colspan="10" align="center">รวม '.$i.' รายการ จำนวน '.$qty1.' ชิ้น</td>';
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
