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
  $filter1 =" and poDate between  '".conv_date_db($s_date)."' and '".conv_date_db($e_date)."'";
  $filter2 =" and receiveDate between  '".conv_date_db($s_date)."' and '".conv_date_db($e_date)."'";
  $filter3 =" and billDate between  '".conv_date_db($s_date)."' and '".conv_date_db($e_date)."'";
}

if($S_REPORT_TYPE=='')
  $S_REPORT_TYPE = '';
if($S_REPORT_TYPE==1){
  $head_txt = 'สั่งซื้อสินค้า';
  $sql =" SELECT poDate,tb_po.poID,productCode,productName,sup_name FROM tb_po
  JOIN tb_po_desc ON tb_po.poID = tb_po_desc.poID
  JOIN tb_product ON tb_po_desc.productID = tb_product.productID
  JOIN tb_supplier ON tb_po.supID = tb_supplier.supID 
  WHERE poStatus != 99 {$filter1}
  -- group by a.poID
  ORDER BY poDate,tb_po.poID"; 
  $col_span = 6;

}else if($S_REPORT_TYPE==2){
  $head_txt = 'รับเข้าสินค้า';
  $sql =" select a.receiveID as BILL_NO,c.productName,c.productCode,c.brandID,c.productSize,c.modelName,
  sum(a.qty) as productUnit,c.unitType,b.receiveDate as doc_date,CONCAT(d.firstname,' ',d.lastname) AS ConcatField
  from tb_receive_desc a  
  join tb_receive b on  a.receiveID = b.receiveID
  join tb_product c on a.productID = c.productID
  join tb_user d on b.create_by = d.userID
  where receiveStatus!=99 {$filter2}
  group by a.receiveID
  order by receiveDate asc,b.receiveID desc";
  $col_span = 5; 
}else if($S_REPORT_TYPE==3){
  $head_txt = 'เบิกสินค้า';
  $sql =" select b.billNo as BILL_NO,c.productName,c.productCode,c.brandID,c.productSize,c.modelName,
  sum(a.billDescUnit) as productUnit,c.unitType,b.billDate as doc_date,CONCAT(d.firstname,' ',d.lastname) AS ConcatField
  from tb_bill_desc a  
  join tb_bill b on  a.billID = b.billID
  join tb_product c on a.productID = c.productID
  join tb_user d on b.create_by = d.userID
  where billStstus = 1 {$filter3}
  group by b.billNo
  order by billDate asc,b.billNo desc";
  $col_span = 5; 
          //billDate
}

$H_REPORT_1 = 'รายงาน'.$head_txt;
$CREATE_REPORT = $_SESSION['sys_name'];
$DATE_FROM = $s_date;
$DATE_TO = $e_date;
date_default_timezone_set("Asia/Bangkok");
$DATE_REPORT = date("d/m/Y h:i:s");

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
// <th width="5%">ลำดับ</th>
// <th width="10%">วันที่สั่งซื้อ</th>
// <th width="10%">เลขที่ใบสั่งซื้อ</th>
// <th width="10%">รหัสสินค้า</th>
// <th width="20%">ชื่อสินค้า</th>
// <th width="10%">ยี่ห้อ</th>
// <th width="10%">ขนาด</th>
// <th width="10%">รุ่น</th>
// <th width="10%">จำนวน</th>
// <td align="center" >'.$rec['productCode'].'</td>
//    <td align="center" >'.$rec['productName'].'</td>
//    <td align="center" >'.get_brand_name($rec['brandID']).'</td>
//    <td align="center" >'.$rec['productSize'].'</td>
//    <td align="center" >'.$rec['modelName'].'</td>
if($S_REPORT_TYPE!=""){
  $html = '<table class="table table-bordered table-striped table-hover dataTable" border="1">
  <thead>
  <tr>';
  if($S_REPORT_TYPE==1){
    $html .= '
    <th width="10%">วันที่สั่งซื้อ</th>
    <th width="10%">เลขที่ใบสั่งซื้อ</th>
    <th width="10%">จำนวนสั่งซื้อ</th>
    <th width="10%">จำนวนเงิน</th>
    <th width="20%">ผู้สั่งซื้อ</th>';
  } else if($S_REPORT_TYPE==2){
    $html .= '<th width="5%">ลำดับ</th>
    <th width="10%">วันที่รับเข้า</th>
    <th width="10%">เลขที่ใบรับเข้า</th>
    <th width="10%">จำนวนรับเข้า</th>
    <th width="20%">ผู้รับเข้า</th>';
  } else if($S_REPORT_TYPE==3){
    $html .= '<th width="5%">ลำดับ</th>
    <th width="10%">วันที่เบิก</th>
    <th width="10%">เลขที่เบิก</th>
    <th width="10%">จำนวนเบิก</th>
    <th width="20%">ผู้เบิก</th>';
  }
  $html .= '</tr>
  </thead>
  <tbody>';
  if($nums>0){
    $i=0;
    $total=0;
    $sum=0;
    $poDate = '';
    $poID = '';
    $aa = 0;
    while ($rec = $db->db_fetch_array($query)) {
      $i++;
      if($S_REPORT_TYPE==1){
        $html .=  '<tr>';
        //$poID = $rec['poID'];
        //if($poDate == ''){      
          //$poDate = $rec['poDate'];

          if($poDate != $rec['poDate']){
           $poDate = $rec['poDate'];
           $html .=  '<td align="center" rowspan="" >'.$poDate.'</td>';
         }else{
          $html .=  '<td align="center"></td>';
          $aa ++;
        }
      //}
      $html .=  '<td align="center" >'.$rec['poID'].'</td>
      <td align="center" >'.$rec['productCode'].'</td>
      <td align="center" >'.$rec['productName'].'</td>
      <td align="center" >'.$rec['sup_name'].'</td>
      </tr>';
    }else if($S_REPORT_TYPE==2){
      $html .=  '<tr>
      <td align="center" >'.$i.'</td>
      <td align="center" >'.$rec['doc_date'].'</td>
      <td align="center" >'.$rec['BILL_NO'].'</td>
      <td align="center">'.number_format($rec['productUnit']).'</td>
      <td align="center" >'.$rec["ConcatField"].'</td>
      </tr>';
    }else if($S_REPORT_TYPE==3){
      $html .=  '<tr>
      <td align="center" >'.$i.'</td>
      <td align="center" >'.$rec['doc_date'].'</td>
      <td align="center" >'.$rec['BILL_NO'].'</td>
      <td align="center">'.number_format($rec['productUnit']).'</td>
      <td align="center" >'.$rec["ConcatField"].'</td>
      </tr>';
    }
    $total += number_format($rec['productUnit']);
    $sum += $rec["total"];
  }
  if($S_REPORT_TYPE==1){
    $td .= '<td colspan="3" align="center" >รวม '.$i.' รายการ จำนวน '.$total.' ชิ้น</td>
    <td colspan="3" align="center" >รวมสุทธิ '.number_format($sum).' บาท</td>';
  }else if($S_REPORT_TYPE==2){
    $td .= '<td colspan="'.$col_span.'" align="center" >รวม '.$i.' รายการ จำนวน '.$total.' ชิ้น</td>';
  }else if($S_REPORT_TYPE==3){
    $td .= '<td colspan="'.$col_span.'" align="center" >รวม '.$i.' รายการ จำนวน '.$total.' ชิ้น</td>';
  }
  $html .=  '<tr>'.$td.'</tr>'; 
}//else{
//   $html .=      '<tr><td align="center" colspan="8">ไม่พบข้อมูล</td></tr>';
// }

  $html .= '    </tbody>
  </table>';
}
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
              <input type="hidden" name="col_span" id="col_span" value="<?php echo $col_span;?>">
              <input type="hidden" name="H_REPORT_1" id="H_REPORT_1" value="<?php echo $H_REPORT_1;?>">
              <input type="hidden" name="H_REPORT_2" id="H_REPORT_2" value="<?php echo $H_REPORT_2;?>">
              <input type="hidden" name="H_REPORT_3" id="H_REPORT_3" value="">
              <input type="hidden" name="CREATE_REPORT" id="CREATE_REPORT" value="<?php echo $CREATE_REPORT;?>"> 
              <input type="hidden" name="DATE_REPORT" id="DATE_REPORT" value="<?php echo $DATE_REPORT;?>">   
              <!--  <?php echo $DATE_FROM; ?> -->
              <div class="row clearfix">                
                <div class="col-md-4">
                  <b>ประเภทรายงาน</b>
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
                    <label id="s_date-error" class="error" for="s_date">กรุณาระบุ วันที่</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <b>ถึงวันที่</b>
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text" class="form-control datepicker" name="e_date" id="e_date" placeholder="DD/MM/YYYY" value="<?php echo $e_date?>">
                      <!-- </div> -->
                    </div>
                    <label id="e_date-error" class="error" for="e_date">กรุณาระบุ วันที่</label>
                  </div>
                </div>
              </div>
              <div class="icon-and-text-button-demo text-center">
                <button onclick="searchData();"class="btn btn-success waves-effect"><span>ค้นหา</span><i class="material-icons">search</i></button>
              </div>

              <!-- <div class="table-responsive"> -->

                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap no-footer">
                  <div id="bt" class="dt-buttons" style="display: block;">
                   <a class="dt-button buttons-excel buttons-html5"  onClick="print_report('excel');"  tabindex="0" aria-controls="DataTables_Table_0"><span>Excel</span></a> 
                   <a class="dt-button buttons-pdf buttons-html5" onClick="print_report('pdf');"  tabindex="0" aria-controls="DataTables_Table_0"><span>PDF</span></a>
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
    //
    // if ($('#s_date').val() == "") {
    //   $('#s_date-error').show();
    //   return false;
    // }
    // if ($('#e_date').val() == "") {
    //   $('#e_date-error').show();
    //   return false;
    // }
    // if ($('#s_date').val() != "" && $('#e_date').val() != "") {
      $("#frm-search").attr("action","Report.php").attr('target','_self').submit();
    // }
    $('#bt').show();
  }
  $(document).ready(function() {
    $('.error').hide();
  });

</script>