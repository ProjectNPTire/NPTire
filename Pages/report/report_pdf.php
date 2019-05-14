<?php
$path = "../../";
include($path."include/config_header_top.php");
include($path."include/MPDF53/mpdf.php");


$HEADER = '';
$HEAD = "";
$PAGE = '';
$SESSION_ID = session_id();
$YEAR_CACHE = date('Y');
$H_REPORT_1 = $_POST['H_REPORT_1'];
$H_REPORT_2 = $_POST['H_REPORT_2'];
$H_REPORT_3 = $_POST['H_REPORT_3'];

$CREATE_REPORT = $_POST['CREATE_REPORT'];
$DATE_FROM = $_POST['DATE_FROM'];
$DATE_TO = $_POST['DATE_TO'];
$DATE_REPORT = $_POST['DATE_REPORT'];

if($H_REPORT_1 != ''){
	$HEADER .= $H_REPORT_1."<br>";
}
// if($H_REPORT_2 != ''){
// 	$HEADER .= $H_REPORT_2."<br>";
// }
if($H_REPORT_3 != ''){
	$HEADER .= $H_REPORT_3."<br>";
}
$img_logo = "../../assets/images/Layer1.png";
$path_cache = 'cache/'.$YEAR_CACHE.'_'.$SESSION_ID.'/';
$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban',7,7,15,7,'4','4');
$pdf->AddPage();
$pdf->pagenumSuffix = '/';
$CSS = "<style type='text/css'>	

table {
	border-collapse:collapse;
	margin-left: auto;
	margin-right: auto;
}
th {
	padding-left:3px;
	padding-bottom:2px; 		
	padding-top:2px;
	border:solid 1px #000000;
}
td:not(.test) {
	padding-left:3px;
	padding-bottom:2px; 		
	padding-top:2px;
	border:solid 1px #000000;
}
.test{
	font-size:9pt;
	padding:0;
}
</style> ";

// $CSS = "<style type='text/css'>	
// body{
// 	font-size:9pt;
// }

// table {
// 	border-collapse:collapse;
// 	margin-left: auto;
// 	margin-right: auto;
// }
// th {
// 	padding-left:3px;
// 	padding-bottom:2px; 		
// 	padding-top:2px;
// 	border:solid 1px #000000;
// }
// td {
// 	padding-left:3px;
// 	padding-bottom:2px; 		
// 	padding-top:2px;
// 	border:solid 1px #000000;
// }
// </style> ";

//POST 
$FILE_NAME = $_POST['FILE_NAME'];
$HTML =  file_get_contents($path_cache.$FILE_NAME.".txt",'r');
if($HEADER != ''){
	$HEAD = "
	<table class='test' width='90%' border='0'>
	<tbody>
	<tr>
	<td width='10%'><img src='".$img_logo."'></td>
	<td>บริษัท เอ็นพี ไทร์ (ล้อทอง) จำกัด NPTIRE GOLDWHEELS<br>ถนนมีนบุรี-ร่มเกล้า เขตมีนบุรี กรุงเทพฯ 10510<br>
	โทร. 02-543-8957, 02-061-5957 , 095-7923290, <br>092-2766964, 081-4384057
	092-2766964, 081-4384057
	</td>
	<td align='right'>ผู้สั่งพิมพ์: ".$CREATE_REPORT."<br>วันที่สั่งพิมพ์: ".$DATE_REPORT."</td>
	</tr>
	</tbody>
	</table>
	<div style='text-align:center;'><strong>".$HEADER."</strong></div><br>
	<div style='text-align:center;'>".$H_REPORT_2."</div><br>
";
  //$HEAD += "<div style='text-align:center;' ><strong>test</strong></div><br>";
}

$PAGE = "{PAGENO}/{nbpg}";
$pdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td></td>
        <td align="right">'.$PAGE.'</td>
    </tr>
</table>');
// <div class='row clearfix'>
// 	<div class='col-sm-4' style='text-align:left;'>
// 	<img src='".$img_logo."'></div>
// 	<div class='col-sm-4'>
// 	บริษัท เอ็นพี ไทร์ (ล้อทอง) จำกัด NPTIRE GOLDWHEELS<br>ถนนมีนบุรี-ร่มเกล้า เขตมีนบุรี กรุงเทพฯ 10510<br>
// 	โทร. 02-543-8957, 02-061-5957 , 095-7923290, <br>092-2766964, 081-4384057
// 	</div>
// 	</div>

$pdf->WriteHTML($CSS.$HEAD.$HTML);
$pdf->Output();