<?php
$path = "../../";
include($path."include/config_header_top.php");
include($path."include/MPDF53/mpdf.php");
$HEADER = '';
$$HEAD = "";
$SESSION_ID = session_id();
$YEAR_CACHE = date('Y');
$H_REPORT_1 = $_POST['H_REPORT_1'];
$H_REPORT_2 = $_POST['H_REPORT_2'];
$H_REPORT_3 = $_POST['H_REPORT_3'];

$CREATE_REPORT = $_POST['CREATE_REPORT'];
$DATE_REPORT = $_POST['DATE_REPORT'];

if($H_REPORT_1 != ''){
	$HEADER .= $H_REPORT_1."<br>";
}
if($H_REPORT_2 != ''){
	$HEADER .= $H_REPORT_2."<br>";
}
if($H_REPORT_3 != ''){
	$HEADER .= $H_REPORT_3."<br>";
}

$path_cache = 'cache/'.$YEAR_CACHE.'_'.$SESSION_ID.'/';
$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban',7,7,15,7,'4','4');
$pdf->AddPage();
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
td {
	padding-left:3px;
	padding-bottom:2px; 		
	padding-top:2px;
	border:solid 1px #000000;
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
  $HEAD = "<div style='text-align:center;'><strong>".$HEADER."</strong></div><div style='text-align:right;'>".$CREATE_REPORT."</div><div style='text-align:right;'>".$DATE_REPORT."</div><br>";
  //$HEAD += "<div style='text-align:center;' ><strong>test</strong></div><br>";
}

$pdf->WriteHTML($CSS.$HEAD.$HTML);
$pdf->Output();