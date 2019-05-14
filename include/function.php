<?php

function PrintAll($PageRep){

$print = "<div class=\"btn-group\">
<button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\">
พิมพ์  <span class=\"caret\"></span>
</button>
<ul class=\"dropdown-menu\" role=\"menu\">
<li><a href=\"#\" onClick=\"print_report('pdf','$PageRep');\" >พิมพ์แบบ PDF</a></li>
<li><a href=\"#\" onClick=\"print_report('excel','$PageRep');\" >พิมพ์แบบ EXCEL</a></li>
<li><a href=\"#\" onClick=\"print_report('word','$PageRep');\" >พิมพ์แบบ WORD</a></li>
</ul>
</div>";
return $print;
}
function Print_any($PageRep,$str){// $str ='word','excel','pdf'

		$print = "<div class=\"btn-group\">
		<button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\">
		พิมพ์  <span class=\"caret\"></span>
		</button>
		<ul class=\"dropdown-menu\" role=\"menu\">";

		if($str=='pdf'){
		$print .= "<li><a href=\"#\" class=\"dropdown-item\" onClick=\"print_report('pdf','$PageRep');\" >พิมพ์แบบ PDF</a></li>";
		}
		if($str=='excel'){
		$print .= "<li><a href=\"#\" class=\"dropdown-item\" onClick=\"print_report('excel','$PageRep');\" >พิมพ์แบบ EXCEL</a></li>";

		}
		if($str=='word'){
		$print .= "<li><a href=\"#\" class=\"dropdown-item\" onClick=\"print_report('word','$PageRep');\" >พิมพ์แบบ WORD</a></li>";
		}
		$print .="</ul>
		</div>";
		return $print;
}



function paging($formname,$allrows,$page_show,$page_size,$char_sub, $startPage, $endPage, $page){
	$totalpage = calculate_page($allrows, $page_size);
	$startPages = findrange_page($page_show, $totalpage, $page, $startPage, $endPage, "min");
	$endPages = findrange_page($page_show, $totalpage, $page, $startPage, $endPage, "max");
	if ($page != 1){ // Prvious
		$prev_page = $page-1;
		//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=1$link_value'>|&lt;</a>&nbsp;";
		$ctrlPage.= "<span onclick=\"document.getElementById('page').value=1;document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\"this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">|&lt;</span>$char_sub";
		//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$prev_page$link_value'>&lt;&lt;</a>&nbsp;";
		$ctrlPage.= "<span onclick=\"document.getElementById('page').value='$prev_page';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">&lt;&lt;</span>$char_sub";
	}else{
		$ctrlPage.="<font color=\"#CCCCCC\">|&lt;&nbsp;</font>";
		$ctrlPage.= "<font color=\"#CCCCCC\">&lt;&lt;&nbsp;</font>";
	}
	if ($totalpage > 1) {
		for($i=$startPages ; $i<$page ; $i++)
		{
			//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$i$link_value'>$i</a>$char_sub";
			$ctrlPage.= "<span class=\"pageNormal\" onclick=\"document.getElementById('page').value='$i';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">$i</span>$char_sub";
		}

		$ctrlPage.= "<b>".$page."</b>$char_sub";
		for($i=$page+1 ; $i<=$endPages ; $i++)
		{
			//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$i$link_value'>$i</a>$char_sub";
			$ctrlPage.= "<span class=\"pageNormal\" onclick=\"document.getElementById('page').value='$i';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">$i</span>$char_sub";
		}
		if (($page != $totalpage) && ($totalpage !=0)){
			$next_page = $page+1;
			//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$next_page$link_value'>&gt;&gt;</a>";
			$ctrlPage.= "<span onclick=\"document.getElementById('page').value='$next_page';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">&gt;&gt;</span>$char_sub";
			//$ctrlPage.= "&nbsp;<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$totalpage$link_value'>&gt;|</a>";
			$ctrlPage.= "<span onclick=\"document.getElementById('page').value='$totalpage';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">&gt;|</span>";
		}else{
			$ctrlPage.= "<font color=\"#CCCCCC\">&gt;&gt;</font>";
			$ctrlPage.= "<font color=\"#CCCCCC\">&nbsp;&gt;|</font>";
		}
	}else{
		$ctrlPage =1;
	}
	return $ctrlPage;
}

//แปลงค่าวันที่
function conv_date($input, $format_month='', $type=''){
	global $mont_en, $mont_en_short, $month_th, $month_th_short,$dow_th2;

	/*
		$input='2013-11-14 10:43:04' || '2013-11-14',
		$type='' ไม่แสดงเวลา
		$type='1' แสดงเวลา
	*/
		//echo substr($input,5,2);
	if(trim($input)){
		if($format_month=='long'){
			$date=(int)substr($input,8,2)." ".$month_th[substr($input,5,2)]." ".(substr($input,0,4));
		}elseif($format_month=='short'){
			$date=(int)substr($input,8,2)." ".$month_th_short[substr($input,5,2)]." ".(substr($input,0,4));
		}elseif($format_month=='year'){
			$date=(int)(substr($input,0,4));
		}elseif($format_month=='full'){
			$date=(int)substr($input,8,2)." เดือน ".$month_th[substr($input,5,2)]." พ.ศ. ".(substr($input,0,4));
                }elseif($format_month=='full2'){//REPORT ประชุม 10/09/57[PG]
                        $date="วัน".$dow_th2[date('D', strtotime($input))]."ที่ ".(int)substr($input,8,2)." ".$month_th[substr($input,5,2)]." พ.ศ. ".(substr($input,0,4));;
		}elseif($format_month=='short2'){
			$date=(int)substr($input,8,2)." ".$month_th[substr($input,5,2)]."  ".(substr($input,0,4));
		}elseif($format_month=='holiday'){
			$date=(int)substr($input,8,2)." ".$month_th[substr($input,5,2)];
		}elseif($format_month=='eng'){
			$date=(int)substr($input,8,2)." ".$mont_en[substr($input,5,2)]."  ".substr($input,0,4);
		}elseif($format_month=='pdf'){
			$date=toThaiNumber((int)substr($input,8,2)." ".$month_th_short[substr($input,5,2)]." ".(substr($input,0,4)));
		}elseif($format_month=='time'){
			$date=substr($input,10,6);
		}elseif($format_month=='short3'){
			$date=(int)substr($input,8,2)." ".$month_th_short[substr($input,5,2)]." ".(substr($input,0,4));
		}else{
			$date=substr($input,8,2)."/".substr($input,5,2)."/".(substr($input,0,4));
		}

		if($type=='1'){
			if($format_month!='pdf'){
				$date.=" ".substr($input,10,9).' น.';
			}else{
				$date.=toThaiNumber(substr($input,10,9));
			}
		}
	}else{
		$date=($format_month=='')?"":"-";
	}
	return $date;
}

//แปลงค่าวันที่ ลง DB
function conv_date_db($input){
    $input = explode("/",$input);
	//print_r($input);
	$date=sizeof($input) == 3 ?($input[2])."-".$input[1]."-".$input[0]:'NULL';
	//echo $date;
	return $date;
}


$bahttext_reading = array(
 1 => array('','เอ็ด','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า'),
 2 => array('','สิบ','ยี่สิบ','สามสิบ','สี่สิบ','ห้าสิบ','หกสิบ','เจ็ดสิบ','แปดสิบ','เก้าสิบ'),
 3 => array('','หนึ่งร้อย','สองร้อย','สามร้อย','สี่ร้อย','ห้าร้อย','หกร้อย','เจ็ดร้อย','แปดร้อย','เก้าร้อย'),
 4 => array('','หนึ่งพัน','สองพัน','สามพัน','สี่พัน','ห้าพัน','หกพัน','เจ็ดพัน','แปดพัน','เก้าพัน'),
 5 => array('','หนึ่งหมื่น','สองหมื่น','สามหมื่น','สี่หมื่น','ห้าหมื่น','หกหมื่น','เจ็ดหมื่น','แปดหมื่น','เก้าหมื่น'),
 6 => array('','หนึ่งแสน','สองแสน','สามแสน','สี่แสน','ห้าแสน','หกแสน','เจ็ดแสน','แปดแสน','เก้าแสน')
);

function convert_bahttext($number){ 
	$txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
	$txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
	$number = str_replace(",","",$number); 
	$number = str_replace(" ","",$number); 
	$number = str_replace("บาท","",$number); 
	$number = explode(".",$number); 
	if(sizeof($number)>2){ 
		return 'ทศนิยมหลายตัวนะจ๊ะ'; 
		exit; 
	} 
	$strlen = strlen($number[0]); 
	$convert = ''; 
	for($i=0;$i<$strlen;$i++){ 
		$n = substr($number[0], $i,1); 
		if($n!=0){ 
			if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
			elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
			elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
			else{ $convert .= $txtnum1[$n]; } 
			$convert .= $txtnum2[$strlen-$i-1]; 
		} 
	} 

	$convert .= 'บาท'; 
	if($number[1]=='0' OR $number[1]=='00' OR 
		$number[1]==''){ 
		$convert .= 'ถ้วน'; 
}else{ 
	$strlen = strlen($number[1]); 
	for($i=0;$i<$strlen;$i++){ 
		$n = substr($number[1], $i,1); 
		if($n!=0){ 
			if($i==($strlen-1) AND $n==1){$convert 
				.= 'เอ็ด';} 
				elseif($i==($strlen-2) AND 
					$n==2){$convert .= 'ยี่';} 
					elseif($i==($strlen-2) AND 
						$n==1){$convert .= '';} 
						else{ $convert .= $txtnum1[$n];} 
					$convert .= $txtnum2[$strlen-$i-1]; 
				} 
			} 
			$convert .= 'สตางค์'; 
		} 
		return $convert; 
	} 


function url2code($paramLink){
	return base64_encode(urlencode($paramLink));
}
function url2param($paramLink){
	return urldecode(base64_decode($paramLink));
}

function text($txt){
	//return iconv("tis-620","utf-8",trim($txt));
	return trim($txt);
}


function ctext($txt){
	//echo $txt;
	$strOut=strip_tags($txt);
	$strOut=htmlspecialchars($strOut, ENT_QUOTES);
	$strOut=stripslashes($strOut);

	$strOut=str_replace("“",'"',$strOut);
	$strOut=str_replace("”",'"',$strOut);

	$strOut=str_replace("'"," ",$strOut);
	$strOut=trim($strOut);

	//return iconv("utf-8","tis-620",$strOut);
	return $strOut;
}

//แปลงตัวเลขเป็นเลขไทย
function toThaiNumber($number){
	$numthai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
	$numarabic = array("1","2","3","4","5","6","7","8","9","0");
	$str = str_replace($numarabic, $numthai, $number);
	return $str;
}


function print_pre($arr){
	$txt = "<pre>".print_r($arr)."</pre>";
	return $txt;
	}

function format_phone($phone,$phone_type='mobile',$type_bk='',$ext=''){//tel  mobile  fax Bangkok up-country
		$phones = '';
		$phones = preg_replace("/[^0-9]/", "", $phone);
		if(strlen($phones) == 7){
			//$phones = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phones);
		}elseif(strlen($phones) == 9){

			if($phone_type=='tel'){
				if($type_bk=='bk'){
					$phones = preg_replace("/([0-9]{1})([0-9]{4})([0-9]{4})/", $ext==''?"$1 $2 $3":"$1 $2 $3"." ต่อ ".$ext, $phones);
				}else{
					$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})/", $ext==''?"$1 $2 $3":"$1 $2 $3"." ต่อ ".$ext, $phones);
				}
			}else if($phone_type=='mobile'){
				if($type_bk=='bk'){
					$phones = preg_replace("/([0-9]{1})([0-9]{4})([0-9]{4})/", "$1 $2 $3", $phones);
				}else{
					$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})/", "$1 $2 $3", $phones);
				}
			}else if($phone_type=='fax'){
				if($type_bk=='bk'){
					$phones = preg_replace("/([0-9]{1})([0-9]{4})([0-9]{4})/", "$1 $2 $3", $phones);
				}else{
					$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})/", "$1 $2 $3", $phones);
				}
			}

		}elseif(strlen($phones) == 10){

			if($phone_type=='tel'){
				$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1 $2 $3", $phones);
			}else if($phone_type=='mobile'){
					$phones = preg_replace("/([0-9]{2})([0-9]{4})([0-9]{4})/", "$1 $2 $3", $phones);
			}else if($phone_type=='mobile2'){
					$phones = preg_replace("/([0-9]{2})([0-9]{4})([0-9]{4})/", "$1 $2 $3", $phones);
			}else if($phone_type=='fax'){
				$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1 $2 $3", $phones);
			}
		}
		return $phones;
	}



function get_prov_name($provinceID){
	global $db;
	$sql = "SELECT province_name_th FROM setup_prov WHERE provinceID = '".$provinceID."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	return text($rec['province_name_th']);
}
function get_district_name($districtID){
	global $db;
	$sql = "SELECT district_name_th FROM setup_district WHERE districtID = '".$districtID."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	return text($rec['district_name_th']);
}
function get_subDistrictID_name($subDistrictID){
	global $db;
	 $sql = "SELECT subDistrict_name_th FROM setup_subdistrict WHERE subDistrictID = '".$subDistrictID."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	return text($rec['subDistrict_name_th']);
}


function Back_to_Top(){
	$button_back ='<div class="col-xs-12 col-sm-12" align="left">
								<p id="back-top">
									<a href="#top" onclick="Back_Top()"><span></span>Back to Top</a>
								</p>
                   			</div> ';
	return $button_back;
}

function uploadfile($fileupload, $url, $old_file=''){
	if($fileupload['size']>0){
		$arr = explode(".",$fileupload['name']);
		 $number = count($arr);

				//print_r( $fileupload);
				 $destination = rand(10,99).'_'.date('Ymdhis').".".$arr[$number-1];

				 copy($fileupload['tmp_name'], $url.$destination);
				@unlink($url.$oldimage);


	}else{
		$destination = $oldimage;
	}
	return $destination;
}





function num2thai($number){
	$t1 = array("ศูนย์", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
	$t2 = array("เอ็ด", "ยี่", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน");
	$zerobahtshow = 0; // ในกรณีที่มีแต่จำนวนสตางค์ เช่น 0.25 หรือ .75 จะให้แสดงคำว่า ศูนย์บาท หรือไม่ 0 = ไม่แสดง, 1 = แสดง
	(string) $number;
	$number = explode(".", $number);
	if(!empty($number[1])){
		if(strlen($number[1]) == 1){
			$number[1] .= "0";
		}else if(strlen($number[1]) > 2){
		if($number[1]{2} < 5){
			$number[1] = substr($number[1], 0, 2);
		}else{
			$number[1] = $number[1]{0}.($number[1]{1}+1);
			}
		}
	}
}


function save_log($detail){
	global $db;
	unset($fields);
	$fields = array(
		  "userID"=>$_SESSION["sys_id"],
			"detail"=>$detail,
			"log_dt"=>date('Y-m-d H:i:s'),
	);

	 $db->db_insert('tb_logfiles',$fields);

}
function get_user_name($userid){
	global $db;
	 $sql = "SELECT firstname ,lastname FROM tb_user WHERE userID = '".$userid."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	return text($rec['firstname'].' '.$rec['lastname']);
}
function get_productType_name($productTypeID){
	global $db;
	 $sql = "SELECT productTypeName FROM tb_producttype WHERE productTypeID = '".$productTypeID."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	return text($rec['productTypeName']);
}
function get_brand_name($brandID){
	global $db;
	 $sql = "SELECT brandName FROM tb_brand WHERE brandID = '".$brandID."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	return text($rec['brandName']);
}
function get_location_name($locationID){
	global $db;
	 $sql = "SELECT locationName FROM tb_location WHERE locationID = '".$locationID."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	return text($rec['locationName']);
}
function chk_role($menu,$type,$show=''){
	global $db;
	if($_SESSION["userType"]==2){
		$sql = "SELECT $type FROM tb_role WHERE menuKey = '".$menu."' ";
		// echo ' <script>alert('.$sql.');</script>';
		$query = $db->query($sql);
		$rec = $db->db_fetch_array($query);
		if($show){
			if($rec[$type]==0){
				echo ' <script>alert("คุณไม่มีสิทธิ์ใช้งานหน้านี้");window.location.assign("main.php");</script>';
			}
		}else{
			if($rec[$type]==0){
				$result = ' display:none; ';
			}else{
				$result = ' ';
			}
		}

		return $result;
	}
/*isAdd
roleID
isEdit
isDel
isSearch
*/

}

function get_poStatus($status){
    if($status == 1) $text = "รอรับสินค้า";
	else if($status == 2) $text = "ค้างรับ";
    else if($status == 3) $text = "รับสินค้าครบแล้ว";
    else if($status == 99) $text = "ยกเลิก";
    return $text;
}

function get_sup_name($id){
    global $db;
    $sql = "SELECT * FROM tb_supplier WHERE supID = '".$id."' ";
    $query = $db->query($sql);
    $rec = $db->db_fetch_array($query);
    return $rec['sup_name'];
}

function get_receiveStatus($status){
	if($status == 1) $text = "รับสินค้าแล้ว";
    else if($status == 99) $text = "ยกเลิก";
    return $text;
}
?>
