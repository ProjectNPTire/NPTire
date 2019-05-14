<?php
$path = "../../";
include($path."include/config_header_top.php");
$SESSION_ID = session_id();
$YEAR_CACHE = date('Y');
$txt_name = $_POST['txt_name'];
$path_cache = 'cache/'.$YEAR_CACHE.'_'.$SESSION_ID.'/';
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="'.$txt_name.'.xls"');
header("Pragma: no-cache");

//POST 

$H_REPORT_1 = $_POST['H_REPORT_1'];
$H_REPORT_2 = $_POST['H_REPORT_2'];
$H_REPORT_3 = $_POST['H_REPORT_3'];

$FILE_NAME = $_POST['FILE_NAME'];
$text = '';
if(!empty($_POST['H_REPORT_1'])){
	$text .= $_POST['H_REPORT_1']."<br>";
}
// if(!empty($_POST['H_REPORT_2'])){
// 	$text .= $_POST['H_REPORT_2']."<br>";
// }
if(!empty($_POST['H_REPORT_3'])){
	$text .= $_POST['H_REPORT_3'];
}

$CREATE_REPORT = $_POST['CREATE_REPORT'];
$DATE_FROM = $_POST['DATE_FROM'];

$obj = fopen($path_cache.$FILE_NAME.".txt",'r');
$HTML = fread($obj,filesize($path_cache.$FILE_NAME.".txt"));
fclose($obj);
$img_logo = "../../assets/images/Layer1.png";
echo '<table style="border-collapse: collapse; width:50%;">
<tr>
<td><img src="'.$img_logo.'"></td>
<td>บริษัท เอ็นพี ไทร์ (ล้อทอง) จำกัด NPTIRE GOLDWHEELS<br>ถนนมีนบุรี-ร่มเกล้า เขตมีนบุรี กรุงเทพฯ 10510<br>
โทร. 02-543-8957, 02-061-5957 , 095-7923290, <br>092-2766964, 081-4384057
092-2766964, 081-4384057
</td>
<td colspan="4" align="right">ผู้สั่งพิมพ์: "'.$CREATE_REPORT.'"<br>วันที่สั่งพิมพ์: "'.$DATE_REPORT.'"</td>
</tr>
<tr>
<td colspan="'.$col_span.'" align="center"><span style="font-weight: extra-bold;">'.$text.$H_REPORT_2.'</span></td>
</tr>
</table><br>';
echo $HTML;


?>