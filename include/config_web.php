<?php
//#################################//
$title_project = "ห้องเสื้อ King & Queen";
$img_icon = $path."images/small_logo_kin.png";

$TIMESTAMP = date("Y-m-d H:i:s");

if(sizeof($_GET)>0){
	foreach($_GET as $key => $param){
		$arrParam = @explode("&",url2param($key));
		if($arrParam){
			foreach($arrParam as $index => $var){
				$arrVar = explode("=",$var);
				${$arrVar[0]} = $arrVar[1];
			}
		}
	}
	foreach($_GET as $key => $value){
	   	${$key} = $value;
	}
}

if(isset($_GET['proc'])=='add'){
	$proc = "add";
	$add_proc = "เพิ่มข้อมูล";

}else if(isset($_GET['proc'])=='edit'){
	$proc = "edit";
	$edit_proc = "แก้ไขข้อมูล";

}

//fix text
$date_now=date("Ymd");//วันปัจจุบัน
$date_now_db=date("Y-m-d");//วันปัจจุบัน
$time_now=date("His");//เวลาปัจจุบัน
$time_now_db=date("H:i:s");//เวลาปัจจุบัน
$YEAR_PRESENT = (date("Y")+543);//ปีปัจจุบัน
$date_now_default=date("d/m/".$YEAR_PRESENT);//วันปัจจุบันดีฟอลต์
$time_now_h_default=date("H");//ชั่วโมงปัจจุบันดีฟอลต์
$time_now_m_default=date("i");//นาทีปัจจุบันดีฟอลต์
for($Y=($YEAR_PRESENT+2);$Y>=($YEAR_PRESENT-10);$Y--){//select ปี
	$A_CONFIG_YEAR[$Y] = $Y;
}
$YEAR_BUDGET = (date('m') < 10)?date("Y")+543:date("Y")+544;//ปีงบประมาณ
$YEAR_BUDGET_PREV = $YEAR_BUDGET-5;
//$USER_BY=iconv('utf-8','tis-620',str_replace("&nbsp;"," ",$_SESSION["sys_name"]));//ชื่อผู้ใช้
$SYS_ADDR=$_SERVER["REMOTE_ADDR"];//ip address
$save_proc="บันทึกข้อมูลเรียบร้อย";
$edit_proc="แก้ไขข้อมูลเรียบร้อย";
$del_proc="ลบข้อมูลเรียบร้อย";
$cancle_proc="ยกเลิกข้อมูลเรียบร้อย";
$send_proc="อนุมัติข้อมลเรียบร้อยแล้ว";
$upload_proc="นำเข้าข้อมูลเรียบร้อย";
$send_edit_proc="ยกเลิกการอนุมัติข้อมลเรียบร้อยแล้ว";

$img_add="<i class=\"material-icons\">add</i>";
$img_edit='<i class="material-icons">edit</i>';
$img_del='<i class="material-icons">delete_forever</i>';
$img_cancel='<i class="material-icons">cancel</i>';
$img_upload="<i class=\"fas fa-upload\"></i>";
$img_download="<i class=\"fas fa-download\"></i>";
$img_save="<i class=\"icon-save\"></i>";
$img_send="<i class=\"fas fa-share-square\"></i>";
$img_view = "<i class=\"material-icons\">search</i>";
$img_list = "<i class=\"fas fa-list-ul\"></i>";
$img_calendar = "<i class=\"fas fa-calendar-alt\"></i>";
$img_user = "<i class=\"icon-user\"></i>";
$img_print = "<i class=\"fas fa-print\"></i>";
$img_reply = "<i class=\"icon-undo \"></i>";
$img_info = "<i class=\"material-icons\">info_outline</i>";
$img_times = "<i class=\"fas fa-times\"></i>";
$img_right = '<i class="fas fa-caret-right"></i>';



//array txt
$mont_en =  array ("01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
$mont_en_short =  array ("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
$month_th = array ("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
$month_th_short = array ("01"=>"ม.ค.","02"=>"ก.พ.","03"=>"มี.ค","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","08"=>"ส.ค.","09"=>"ก.ย.","10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");
$dow_th = array ("1"=>"จันทร์","2"=>"อังคาร","3"=>"พุธ","4"=>"พฤหัสบดี","5"=>"ศุกร์","6"=>"เสาร์","7"=>"อาทิตย์");
$dow_th2 = array ("Mon"=>"จันทร์","Tue"=>"อังคาร","Wed"=>"พุธ","Thu"=>"พฤหัสบดี","Fri"=>"ศุกร์","Sat"=>"เสาร์","Sun"=>"อาทิตย์");
$dow_th_short = array ("1"=>"จ.","2"=>"อ.","3"=>"พ.","4"=>"พฤ.","5"=>"ศ.","6"=>"ส.","7"=>"อา.");
$arr_active = array ("1"=>"<span style='color:green'>ใช้งาน</span>","0"=>"<span style='color:red'>ไม่ใช้งาน</span>");
$arr_bill_status = array ("1"=>"<span>เบิกสินค้าแล้ว</span>","2"=>"<span style='color:red'>ยกเลิกการเบิก</span>");
$arr_receive_status = array ("1"=>"<span>รับสินค้าแล้ว</span>","99"=>"<span style='color:red'>ยกเลิก</span>");
$arr_po_status = array ("3"=>"<span>รับสินค้าครบแล้ว</span>","99"=>"<span style='color:red'>ยกเลิกการสั่งซื้อ</span>","1"=>"<span>รอรับสินค้า</span>","2"=>"<span>ค้างรับ</span>");
$arr_userType = array ("1"=>"<span style='color:green'>Admin</span>","2"=>"<span style='color:red'>พนักงาน</span>");
$arr_unitType = array ("1"=>"เส้น","2"=>"วง","3"=>"คู่","4"=>"กล่อง","5"=>"หน่วย","6"=>"ขวด","7"=>"ลิตร");
$arr_locationType = array ("1"=>"Large","2"=>"Small");
$DEF_ROWS_PER_PAGE = 20;
$DEF_POPUP_ROWS_PER_PAGE = 10;
$DEF_POPUP_PAGE_SET = 20;
?>
