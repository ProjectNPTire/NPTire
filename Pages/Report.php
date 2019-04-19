<!DOCTYPE html>
<html>

<?php 
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='999999';


$SESSION_ID = session_id();
$YEAR_CACHE = date('Y');
$path_cache = 'report/cache/'.$YEAR_CACHE.'_'.$SESSION_ID;

$FILE_NAME = pathinfo(__FILE__, PATHINFO_FILENAME);

if($s_date!='' && $e_date!=''){
  $H_REPORT_2 ="ระหว่างวันที่ ".$s_date."ถึง ". $e_date;
  $filter1 =" and between  '".conv_date_db($s_date)."' and '".conv_date_db($e_date)."'";
  $filter2 =" and between  '".conv_date_db($s_date)."' and '".conv_date_db($e_date)."'";
  $filter3 =" and between  '".conv_date_db($s_date)."' and '".conv_date_db($e_date)."'";
}

if($S_REPORT_TYPE=='')
  $S_REPORT_TYPE = 1;
if($S_REPORT_TYPE==1){
  $head_txt = 'สั่งซื้อสินค้า';
  $sql =" select a.poID as BILL_NO,c.productName,c.productCode,c.brandID,c.productSize,c.modelName,
  a.qty as productUnit,c.unitType
  from tb_po_desc a  
  join tb_po b on  a.poID = b.poID
  join tb_product c on a.productID = c.productID
  where 1=1 {$filter1}
  "; 

}else if($S_REPORT_TYPE==2){
  $head_txt = 'รับเข้าสินค้า';
  $sql =" select a.receiveID as BILL_NO,c.productName,c.productCode,c.brandID,c.productSize,c.modelName,
  a.qty as productUnit,c.unitType
  from tb_receive_desc a  
  join tb_receive b on  a.receiveID = b.receiveID
  join tb_product c on a.productID = c.productID
  where receiveStatus!=99 {$filter2}
  "; 
}else if($S_REPORT_TYPE==3){
  $head_txt = 'เบิกสินค้า';
  $sql =" select b.billNo as BILL_NO,c.productName,c.productCode,c.brandID,c.productSize,c.modelName,
  a.billDescUnit as productUnit,c.unitType
  from tb_bill_desc a  
  join tb_bill b on  a.billID = b.billID
  join tb_product c on a.productID = c.productID
  where billStstus = 1 {$filter3}
  "; 
          //billDate
}

$H_REPORT_1 = 'รายงานรายการ'.$head_txt;


$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$html = '<table class="table table-bordered table-striped table-hover dataTable" border="1">
<thead>
<tr>
<th width="5%">ลำดับ</th>
<th width="10%">เลขที่เอกสาร</th>
<th width="10%">รหัสสินค้า</th>
<th width="20%">ชื่อสินค้า</th>
<th width="10%">ยี่ห้อ</th>
<th width="10%">ขนาด</th>
<th width="10%">รุ่น</th>
<th width="10%">จำนวน</th>
</tr>
</thead>
<tbody>';
if($nums>0){
  $i=0;
  while ($rec = $db->db_fetch_array($query)) {  $i++;
   $html .=  '<tr>
   <td align="center" >'.$i.'</td>
   <td align="center" >'.$rec['BILL_NO'].'</td>
   <td align="center" >'.$rec['productCode'].'</td>
   <td align="center" >'.$rec['productName'].'</td>
   <td align="center" >'.get_brand_name($rec['brandID']).'</td>
   <td align="center" >'.$rec['productSize'].'</td>
   <td align="center" >'.$rec['modelName'].'</td>
   <td align="center">'.number_format($rec['productUnit']).' '.$arr_unitType[$rec['unitType']].'</td>
   </tr>';             
 }
}else{
  $html .=      '<tr><td align="center" colspan="8">ไม่พบข้อมูล</td></tr>';
}

$html .= '    </tbody>
</table>
';
                 // <td lign="center"><span class="badge bg-red">'.number_format($rec['productUnit']).' '.$arr_unitType[$rec['unitType']].'</span></td>


?>

<body class="theme-red">
  <?php include 'MasterPage.php';?>

  <section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2>รายงาน</h2>
            </div>
            <div class="body">
             <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <input type="hidden" id="FILE_NAME" name="FILE_NAME" value="<?php echo $FILE_NAME; ?>">
              <input type="hidden" name="txt_name" id="txt_name" value="<?php echo $H_REPORT_1;?>">
              <input type="hidden" name="col_span" id="col_span" value="8">
              <input type="hidden" name="H_REPORT_1" id="H_REPORT_1" value="<?php echo $H_REPORT_1;?>">
              <input type="hidden" name="H_REPORT_2" id="H_REPORT_2" value="<?php echo $H_REPORT_2;?>">
              <input type="hidden" name="H_REPORT_3" id="H_REPORT_3" value="">

              <div class="row clearfix">                
                <div class="col-md-4">
                  <b>เอกสาร</b>
                  <div class="form-float">
                    <select class="form-control show-tick" data-live-search="true" id="S_REPORT_TYPE" name="S_REPORT_TYPE">
                      <option value="1" <?php echo ($S_REPORT_TYPE==1)?"selected":"";?>>สั่งซื้อ</option>
                      <option value="2" <?php echo ($S_REPORT_TYPE==2)?"selected":"";?>>รับเข้า</option>
                      <option value="3" <?php echo ($S_REPORT_TYPE==3)?"selected":"";?>>เบิก</option>
                    </select>  
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <b>ตั้งแต่วันที่</b>
                    <div class="form-line">
                      <input type="text" class="form-control datepicker" name="s_date" id="s_date" placeholder="DD/MM/YYYY" value="<?php echo $s_date?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <b>ถึงวันที่</b>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" class="form-control datepicker" name="e_date" id="e_date" placeholder="DD/MM/YYYY" value="<?php echo $e_date?>">
                      <!-- </div> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="icon-and-text-button-demo text-center">
                <button onclick="searchData();" class="btn btn-success waves-effect"><span>ค้นหา</span><i class="material-icons">search</i></button>
              </div>

              <!-- <div class="table-responsive"> -->
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                  <div class="dt-buttons">
                   <a class="dt-button buttons-excel buttons-html5"  onClick="print_report('excel');"  tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>Excel</span></a> 
                   <a class="dt-button buttons-pdf buttons-html5" onClick="print_report('pdf');"  tabindex="0" aria-controls="DataTables_Table_0" href="#"><span>PDF</span></a>
                 </div> 
                 <?php
                 @mkdir($path_cache,0,true);
                 $obj = fopen($path_cache.'/'.$FILE_NAME.".txt", 'w');
                 fwrite($obj, $html);
                 fclose($obj);
                 echo "<br>";
                 echo $html;
                 ?>
               </div>           
               <!-- </div>   -->
             </form>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <?php include 'js.php';?>
</body>

</html>
<script>

  function print_report(type){
    $('#frm-search').attr('action','report/report_'+type+'.php');
    $('#frm-search').attr('target','_blank');
    $('#frm-search').submit();
  }
  function searchData(){

    $("#frm-search").attr("action","Report.php").attr('target','_self').submit();
  }

</script>