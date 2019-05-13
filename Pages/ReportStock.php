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


if($S_REPORT_TYPE!=''){
  $filter ="where locationID = '".$S_REPORT_TYPE."'";
}

$sql =" select * from tb_location 
{$filter}";


$H_REPORT_1 = 'รายงานข้อมูลสินค้าจัดเก็บตามพื้นที่';
$CREATE_REPORT = $_SESSION['sys_name'];
date_default_timezone_set("Asia/Bangkok");
$DATE_REPORT = date("d/m/Y h:i:s");


$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$html = '<table class="table table-bordered table-striped table-hover dataTable" border="1">
<thead>
<tr>
<th>ตำแหน่งจัดเก็บ</th>
<th>สินค้าในตำแหน่งจัดเก็บ</th>
</tr>
</thead>
<tbody>';
if($nums>0){
  $i=0;
  while ($rec = $db->db_fetch_array($query)) {
    $i++;
    $sql1 ="select SUM(ps_unit) as total from tb_location left join tb_productstore on tb_location.locationID = tb_productstore.locationID where tb_location.locationID = '".$rec['locationID']."' group by tb_location.locationID";
    $query1 = $db->query($sql1);
    $rec1 = $db->db_fetch_array($query1);

    $html .=  '<tr>
    <td align="left">'.$rec['locationName'].'<br/>จำนวนทั้งหมด '.number_format($rec1['total']).' ชิ้น</td>
    <td align="center">';
    $sqlproduct =" select  *
    from tb_product a
    left join tb_productstore b on a.productID = b.productID
    where b.locationID = '".$rec['locationID']."' ";

    $queryproduct = $db->query($sqlproduct);
    $numsproduct = $db->db_num_rows($queryproduct);
    if($numsproduct>0){
      $html .= '<table class="table table-bordered table-striped table-hover dataTable" border="1" width="100%">
      <tr>
      <td align="center" width="20%">รหัสสินค้า</td>
      <td align="center" width="20%">ชื่อสินค้า</td>
      <td align="center" width="10%">ยี่ห้อ</td>
      <td align="center" width="10%">รุ่น</td>
      <td align="center" width="10%">ขนาด</td>
      <td align="center" width="5%">จำนวน</td>
      <td align="center" width="5%">หน่วย</td>
      </tr>';
      while ($recproduct = $db->db_fetch_array($queryproduct)) {        
        $html .= '<tr>
        <td>'.$recproduct['productCode'].'</td>
        <td>'.$recproduct['productName'].'</td>
        <td>'.get_brand_name($recproduct['brandID']).'</td>
        <td>'.$recproduct["modelName"].'</td>
        <td>'.$recproduct["productSize"].'</td>
        <td align="right">'.$recproduct["ps_unit"].'</td>
        <td>'.$arr_unitType[$recproduct['unitType']].'</td>
        </tr>';
      }
      $html .= '</table>';
    }else{
      $html .= 'ไม่มีสินค้าในตำแหน่งจัดเก็บนี้';
    }
    $html .=  '</td>
    </tr>';             
  }
}else{
  $html .='<tr><td align="center" colspan="8">ไม่พบข้อมูล</td></tr>';
}

$html .= '</tbody>
</table>';
?>

<body class="theme-red">
  <?php include 'MasterPage.php';?>

  <section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2>รายงานข้อมูลสินค้าจัดเก็บตามพื้นที่</h2>
            </div>
            <div class="body">
              <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" id="FILE_NAME" name="FILE_NAME" value="<?php echo $FILE_NAME; ?>">
                <input type="hidden" name="txt_name" id="txt_name" value="<?php echo $H_REPORT_1;?>">
                <input type="hidden" name="col_span" id="col_span" value="8">
                <input type="hidden" name="H_REPORT_1" id="H_REPORT_1" value="<?php echo $H_REPORT_1;?>">  
                <input type="hidden" name="location" id="location" value="<?php echo $S_REPORT_TYPE;?>">

                <input type="hidden" name="CREATE_REPORT" id="CREATE_REPORT" value="<?php echo $CREATE_REPORT;?>"> 
                <input type="hidden" name="DATE_REPORT" id="DATE_REPORT" value="<?php echo $DATE_REPORT;?>">   

                <div class="row clearfix">                
                  <div class="col-md-10">
                    <b>ตำแหน่งจัดเก็บ</b>
                    <div class="form-float">
                      <select class="form-control show-tick" data-live-search="true" id="S_REPORT_TYPE" name="S_REPORT_TYPE">
                        <option value="">ทั้งหมด</option>
                        <?php
                        $s_location=" SELECT * from tb_location order by locationID asc";
                        $q_location = $db->query($s_location);
                        $n_location = $db->db_num_rows($q_location);
                        while($r_location = $db->db_fetch_array($q_location)){

                          ?>
                          <option value="<?php echo $r_location['locationID'];?>" <?php echo ($S_REPORT_TYPE==$r_location['locationID'])?"selected":"";?>><?php echo $r_location['locationName'];?></option>

                        <?php }  ?>
                      </select>  
                    </div>
                  </div>              
                  <div class="col-md-2">
                    <div class="icon-and-text-button-demo">
                      <button onclick="searchData();" class="btn btn-success waves-effect"><span>ค้นหา</span><i class="material-icons">search</i></button>
                    </div>
                  </div>
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

    $("#frm-search").attr("action","ReportStock.php").attr('target','_self').submit();
  }

</script>