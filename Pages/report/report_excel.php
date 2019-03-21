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

$FILE_NAME = $_POST['FILE_NAME'];
$text = '';
if(!empty($_POST['H_REPORT_1'])){
	$text .= $_POST['H_REPORT_1']."<br>";
}
if(!empty($_POST['H_REPORT_2'])){
	$text .= $_POST['H_REPORT_2']."<br>";
}
if(!empty($_POST['H_REPORT_3'])){
	$text .= $_POST['H_REPORT_3'];
}

$obj = fopen($path_cache.$FILE_NAME.".txt",'r');
$HTML = fread($obj,filesize($path_cache.$FILE_NAME.".txt"));
fclose($obj);
echo '<table style="border-collapse: collapse; width:50%;">
<tr>
	<td colspan="'.$col_span.'" align="center"><span style="font-weight: extra-bold;">'.$text.'</span></td>
</tr>
</table>';
echo $HTML;


?>