<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';

$page_key ='4_1';

$filter = '';
if($s_po_id){
   $filter .= " and poID like '%".$s_po_id."%'";
}
if($s_sup_id){
   $filter .= " and supID = '".$s_sup_id."'";
}
if($s_po_date){
   $filter .= " and poDate = '".conv_date_db($s_po_date)."'";
}
if($s_po_status){
   $filter .= " and poStatus = '".$s_po_status."'";
}

$field = "* ";
$table = "tb_po";
$pk_id = "poID";
$wh = "1=1  {$filter}";
$orderby = "order by poID DESC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." where ".$wh ." ".$orderby .$limit;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));
chk_role($page_key,'isSearch',1);
?>

<body class="theme-red">
    <?php include 'MasterPage.php';?>

    <section class="content">
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>รายการสั่งซื้อสินค้า</h2>
                        </div>
                        <div class="body table-responsive">
                            <form id="frm-search" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <input type="hidden" id="proc" name="proc" value="">
                                <input type="hidden" id="form_page" name="form_page" value="OrderList.php">
                                <input type="hidden" id="poID" name="poID" value="">
                                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
                                <input type="hidden" id="page" name="page" value="<?php echo $page;?>">

                               <!--  <div class="row clearfix">
                                    <div class="col-sm-6">
                                     <div class="form-group">
                                      <b>เลขที่ใบสั่งซื้อ </b>
                                      <div class="form-line">
                                        <input type="text " name="s_po_id" id="s_po_id" class="form-control" placeholder="เลขที่ใบสั่งซื้อ" value="<?php echo $s_po_id;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b>ชื่อคู่ค้า/บริษัท </b>
                                    <div class="form-group form-float">
                                      <select name="s_sup_id" id="s_sup_id" class="form-control show-tick" data-live-search="true">
                                          <option value="">เลือก</option>
                                          <?php
                                          $sql_sup=" SELECT * from tb_supplier order by sup_name asc";
                                          $query_sup = $db->query($sql_sup);
                                          while($rec_sup = $db->db_fetch_array($query_sup)){?>
                                              <option value="<?php echo $rec_sup['supID'];?>"  <?php echo ($s_sup_id==$rec_sup['supID'])?"selected":"";?>> <?php echo $rec_sup['sup_name'];?></option>
                                          <?php }  ?>
                                      </select>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row clearfix">
                        <div class="col-sm-6">
                         <b>วันที่เอกสาร </b>
                         <div class="input-group">
                            <div class="form-line">
                                <input type="text" class="form-control datepicker" name="s_po_date" id="s_po_date" placeholder="DD/MM/YYYY" value="<?php echo $s_po_date;?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <b>สถานะ </b>
                            <div class="form-group form-float">
                                <select name="s_po_status" id="s_po_status" class="form-control show-tick" data-live-search="true" onchange="get_area(this.value,'subDistrictID',2);">
                                    <option value="">เลือก</option>
                                    <option value="1" <?php echo ($s_po_status == 1)? "selected" : ""; ?>>รอรับสินค้า</option>
                                    <option value="2" <?php echo ($s_po_status == 2)? "selected" : ""; ?>>ค้างรับ</option>
                                    <option value="1" <?php echo ($s_po_status == 3)? "selected" : ""; ?>>รับสินค้าครบแล้ว</option>
                                    <option value="99" <?php echo ($s_po_status == 99)? "selected" : ""; ?>>ยกเลิก</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="icon-and-text-button-demo align-center">
                    <button type="button" class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                </div> -->

                <div class="icon-and-text-button-demo align-right">
                    <button type="button" style="<?php echo chk_role($page_key,'isAdd'); ?>" class="btn btn-primary waves-effect" onclick="addData();"><span>เพิ่มข้อมูล</span><i class="material-icons">add</i></button>
                </div>
                <div class="">
                    <table width="100%" id="table1" class="table table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th align="center">เลขที่ใบสั่งซื้อ</th>
                                <th align="center">ชื่อ/บริษัทคู่ค้า</th>
                                <th align="center">วันที่ทำรายการ</th>
                                <th align="center">สถานะ</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($nums>0){
                                $i=0;
                                while ($rec = $db->db_fetch_array($query)) {
                                                //$del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect" onClick="cancelPO(\''.$rec["poID"].'\');">ยกเลิกเอกสาร</a>';
                                    $del = '';
                                    if($_SESSION['userType'] == 1 && ($rec['poStatus'] == 1 || $rec['poStatus'] == 2)){
                                      $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect"  onClick="cancelPO('.$rec['poID'].');"  title="ยกเลิก" >'.$img_cancel.'</a>';
                                  }
                                  $info = ' <a style="'.chk_role($page_key,'isSearch').'" class="btn btn-info btn-xs waves-effect" onClick="infoPO(\''.$rec["poID"].'\');" title="รายละเอียด">'.$img_info.'</a>';
                                  ?>
                                  <tr>
                                      <td align="center"><?php echo ++$i; ?></td>
                                      <td><?php echo $rec['poID']; ?></td>
                                      <td><?php echo get_sup_name($rec['supID']); ?></td>
                                      <td><?php echo conv_date($rec['poDate']); ?></td>
                                      <td><?php echo $arr_po_status[$rec['poStatus']]; ?></td>
                                      <td align="center"><?php echo $info.$del; ?></td>
                                  </tr>
                              <?php }
                          }else{
                            echo '<tr><td align="center" colspan="7">ไม่พบข้อมูล</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <!-- <?php echo ($nums > 0) ? endPaging("frm-search", $total_record) : ""; ?> -->
            </div>
        </form>
    </div>
</div>
</div>
</div>
<!-- #END# Basic Examples -->

<div id="modal-load"></div>

</div>
</section>

<?php include 'js.php';?>
</body>

</html>

<script>
    $(document).ready(function() {
       $("#table1").DataTable({
         "ordering": false,
     })
   });
    function searchData(){
        $('#frm-search').removeAttr('target');
        $("#frm-search").submit();
    }

    function addData(){
        $("#proc").val("add");
        $('#frm-search').removeAttr('target');
        $("#frm-search").attr("action","OrderInfo.php").submit();
    }

    function cancelPO(id){
      if(confirm("ต้องการยกเลิกเอกสารใช่หรือไม่ ?")){
        $("#proc").val("cancel");
        $("#poID").val(id);
        $('#frm-search').removeAttr('target');
        $("#frm-search").attr("action","process/order_process.php").submit();
    }
}

function infoPO(id){
    $.post( "process/ajax_response.php", { func: "getPOInfo", id: id  }, function( data ) {
        //console.log(data);
        var html = "";

        html += '<div class="modal fade" id="frm-modal" tabindex="-1" role="dialog">';
        html += '<div class="modal-dialog modal-lg" role="document">';
        html += '<div class="modal-content">';

        html += '<div class="modal-header">';
        html += '<div class="row">';
        // html += '<div class="col-sm-6">';
        // html += '<h1 class="modal-title" id="largeModalLabel">';
        // html += 'บริษัท เอ็นพี ไทร์ (ล้อทอง) จำกัด <br/>';
        // html += 'NP TIRE (GOLD WHEELS) CO.,LTD <br/>';
        // html += '35/23-25 ถ.มีนบุรี-ร่มเกล้า เขตมีนบุรี กรุ่งเทพฯ 10510 <br/>';
        // html += 'โทร 02-543-8957, 02-061-5957';
        // html += '</h1>';
        // html += '</div>';
        html += '<div class="col-sm-12 text-right">';
        html += '<h1 class="modal-title" id="largeModalLabel">';
        html += 'ใบสั่งซื้อสินค้า<br/>';
        html += 'เลขที่ใบสั่งซื้อ : '+id+'<br/>';
        html += 'วันที่สั่งซื้อ : '+data["po_head"].poDate;

        html += '</h1>';
        html += '</div>';
        html += '</div>';
        html += '</div>';


        html += '<div class="modal-body">';

        // html += '<div class="row">';
        // html += '<div class="col-sm-4">';
        // html += '<div class="form-group">';
        // html += '<b>เลขที่ใบสั่งซื้อ : '+id+'</b>';
        // html += '</div>';
        // html += '</div>';

        // html += '<div class="col-sm-4">';
        // html += '<div class="form-group">';
        // html += '<b>วันที่เอกสาร : '+data["po_head"].poDate+'</b>';
        // html += '</div>';
        // html += '</div>';

        // html += '<div class="col-sm-4">';
        // html += '<div class="form-group">';
        // html += '<b>ผู้ทำรายการ : '+data["po_head"].empname+'</b>';
        // html += '</div>';
        // html += '</div>';
        // html += '</div>';

        html += '<div class="form-group">';
        html += '<div class="row">';

        html += '<div class="col-sm-12" style="border:1px dotted #ccc!important;border-radius: 10px;">';
        html += '<div class="col-sm-offset-1">';
        html += '<br/">';

        html += '<div class="row clearfix">';

        html += '<div class="col-sm-6">';
        html += '<div class="form-group">';
        html += '<b>คู่ค้า/บริษัท : </b>'+data["po_head"].sup_name;
        html += '</div>';
        html += '</div>';

        html += '<div class="col-sm-6">';
        html += '<div class="form-group">';
        html += '<b>ตัวแทนขาย : </b>'+data["po_head"].namesale;
        html += '</div>';
        html += '</div>';

        html += '</div>';

        html += '<div class="row clearfix">';

        html += '<div class="col-sm-6">';
        html += '<div class="form-group">';
        html += '<b>ที่อยู่ : </b>'+data["po_head"].sup_address;
        html += '</div>';
        html += '</div>';

        html += '<div class="col-sm-6">';
        html += '<div class="form-group">';
        html += '<b>เบอร์โทรศัพท์ตัวแทน : </b>'+data["po_head"].mobilesale;
        html += '</div>';
        html += '</div>';

        html += '</div>';

        html += '<div class="row clearfix">';

        html += '<div class="col-sm-6">';
        html += '<div class="form-group">';
        html += '<b>เบอร์โทรศัพท์บริษัท : </b>'+data["po_head"].sup_tel;
        html += '</div>';
        html += '</div>';

        // html += '<div class="col-sm-6">';
        // html += '<div class="form-group">';
        // html += '<b>สถานะ : </b>'+data["po_head"].poStatusName;
        // html += '</div>';
        // html += '</div>';

        html += '</div>';


        html += '</div>';
        html += '</div>';

        html += '</div>';
        html += '</div>';

        // if(data["po_head"].isCancel == 1 && (data["po_head"].poStatus == 1 || data["po_head"].poStatus == 2))
        // {
        //     html += '<div class="text-right">';
        //     html += '<a class="btn btn-danger waves-effect" onClick="cancelPO(\''+id+'\');" >ยกเลิกเอกสาร</a>';
        //     html += '</div>';
        // }

        html += '</div>';



        html += '<div class="modal-body">';
        html += '<table class="table table-bordered" id="tb-search" style="font-size:14px">';
        html += '<thead>';
        html += '<tr>';
        html += '<th>ลำดับ</th>';
        html += '<th>รหัสสินค้า</th>';
        html += '<th>ชื่อสินค้า</th>';
        html += '<th>ยี่ห้อ</th>';
        html += '<th>รุ่น</th>';
        html += '<th>ขนาด</th>';
        html += '<th>ราคา/หน่วย</th>';
        html += '<th>จำนวน</th>';
        html += '<th>รับแล้ว</th>';
        html += '<th>รวม</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';

        if(data["po_desc"]){
            for(var i = 0; i < data["po_desc"].length; i++ ){
               html += '<tr>';
               html += '<td align="center">'+(i+1)+'</td>';
               html += '<td align="center">'+data["po_desc"][i].productCode+'</td>';
               html += '<td>'+data["po_desc"][i].productName+'</td>';
               html += '<td>'+data["po_desc"][i].brandName+'</td>';
               html += '<td>'+data["po_desc"][i].modelName+'</td>';
               html += '<td>'+data["po_desc"][i].productSize+'</td>';
               html += '<td align="right">'+addCommas(data["po_desc"][i].price)+'</td>';
               html += '<td align="right">'+data["po_desc"][i].qty+'</td>';
               html += '<td align="right">'+data["po_desc"][i].received_qty+'</td>';
               html += '<td align="right">'+addCommas(data["po_desc"][i].amount)+'</td>';
               html += '</tr>';
           }
       }
       else {
        html += '<tr>';
        html += '<td colspan="9" align="center">ไม่พบข้อมูล</td>';
        html += '</tr>';
    }

    html += '</tbody>';

    html += '<tfoot>';
    html += '<tr>';
    html += '<td colspan="9" align="center">ราคาสุทธิ(รวมvat)</td>';
    html += '<td align="right">'+addCommas(data["po_head"].total)+'</td>';
    html += '</tr>';
    html += '</tfoot>';

    html += '</table>';
    html += '</div>';

    html += '<div class="modal-footer">';
    html += '<div class="col-sm-12 text-center">';
    html += '<a class="btn btn-default waves-effect" onclick="printPO(\''+id+'\');">พิมพ์</a>';
    html += '<a class="btn btn-default waves-effect" data-dismiss="modal" >ปิด</a>';
    html += '</div>';
    html += '</div>';

    html += '</div>';
    html += '</div>';
    html += '</div>';

    $("#modal-load").html(html);
    $("#frm-modal").modal('show');

}, "json");
}

function printPO(id){
    $('#poID').val(id);
    $('#frm-search').attr('action','report/print_PO.php');
    $('#frm-search').attr('target','_blank');
    $('#frm-search').submit();
}

</script>
