<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';

$page_key ='5_1';

//$filter = '';

// if($s_receive_id){
//  $filter .= " and receiveID like '%".$s_receive_id."%'";
// }
// if($s_po_id){
//  $filter .= " and poID like '%".$s_po_id."%'";
// }
// if($s_receive_date){
//  $filter .= " and receiveDate = '".conv_date_db($s_receive_date)."'";
// }
// if($s_receive_status){
//  $filter .= " and receiveStatus = '".$s_receive_status."'";
// }

$filter = '';
if($ddl_search == 1){
  if($s_billNo != ""){
    $filter .= " and receiveID  like '%".$s_billNo."%'";
  }
}else if($ddl_search == 2){
  if($s_userID != ""){
   $filter .= " and create_by ='".$s_userID."'";
 }
}else if($ddl_search == 3){
  if($date != ""){
    $filter .= " and receiveDate  like '%".conv_date_db($date)."%'";
  }
 }//else if($ddl_search == 4){
//   if($status != ""){
//    $filter .= " and receiveStatus = '".$status."'";
//  }
// }


  $field = "* ";
  $table = "tb_receive";
  $pk_id = "receiveID";
  $wh = "1=1  {$filter}";
  $orderby = "order by receiveID DESC";
  $limit =" LIMIT ".$goto ." , ".$page_size ;
  $sql = "select ".$field." from ".$table." where ".$wh ." ".$orderby;

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
                <h2>รายการรับเข้าสินค้า</h2>
              </div>
              <div class="body table-responsive">
                <form id="frm-search" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                  <input type="hidden" id="proc" name="proc" value="">
                  <input type="hidden" id="form_page" name="form_page" value="ReceiveList.php">
                  <input type="hidden" id="receiveID" name="receiveID" value="">
                  <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
                  <input type="hidden" id="page" name="page" value="<?php echo $page;?>">

                  <div class="row clearfix">
                    <div class="col-sm-5">
                      <div class="form-group">
                        <div class="form-group form-float">
                          <select name="ddl_search" id="ddl_search" class="form-control show-tick" data-live-search="true"  >
                            <option value=""<?php echo ($ddl_search=="")?"selected":"";?>>แสดงข้อมูลทั้งหมด</option>
                            <option value="1"<?php echo ($ddl_search==1)?"selected":"";?>>เลขที่ใบรับเข้า</option>
                            <option value="2"<?php echo ($ddl_search==2)?"selected":"";?>>ผู้รับ</option>
                            <option value="3"<?php echo ($ddl_search==3)?"selected":"";?>>วันที่รับเข้า</option>
                            <!-- <option value="4"<?php echo ($ddl_search==4)?"selected":"";?>>สถานะ</option> -->
                          </select>
                        </div>
                      </div>                     
                    </div>
                    <div class="col-sm-5" id="bill" style="display: none;">
                      <div class="form-group">
                        <div class="form-line">
                          <input type="text " name="s_billNo" id="s_billNo" class="form-control" placeholder="เลขที่ใบรับเข้า" value="<?php echo $s_billNo;?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-5" id="user" style="display: none;">
                      <div class="form-group">
                        <div class="form-group form-float">
                          <select name="s_userID" id="s_userID" class="form-control show-tick" data-live-search="true"  >
                            <option value="">เลือก</option>
                            <?php
                            $s_p=" SELECT * from tb_user order by firstname asc";
                            $q_p = $db->query($s_p);
                            $n_p = $db->db_num_rows($q_p);
                            while($r_p = $db->db_fetch_array($q_p)){?>
                              <option value="<?php echo $r_p['userID'];?>"<?php echo ($s_userID==$r_p['userID'])?"selected":"";?>> <?php echo $r_p['firstname'].' '.$r_p['lastname'];?></option>

                            <?php }  ?>
                          </select>
                        </div>
                      </div>                     
                    </div>
                    <div class="col-md-5" id="date" style="display: none;">
                      <div class="form-group">
                        <div class="form-line">
                          <input type="text" class="form-control datepicker" placeholder="DD/MM/YYYY  " name="date" id="date" value="<?php echo $date;?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-5" id="status" style="display: none;">
                      <div class="form-group">
                        <div class="form-group form-float">
                          <select name="status" id="s_userID" class="form-control show-tick" data-live-search="true"  >
                            <option value="">เลือก</option>
                            <?php
                            foreach ($arr_bill_status as $key => $value) { ?>
                              <option value="<?php echo $key ?>"<?php echo ($status==$key)?"selected":"";?>><?php echo $value ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>                     
                    </div>
                    <div class="col-sm-2">
                      <div class="icon-and-text-button-demo align-center">
                        <button  class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                      </div>
                    </div> 
                  </div>

                  <div class="icon-and-text-button-demo align-right">
                    <button type="button" style="<?php echo chk_role($page_key,'isAdd'); ?>" class="btn btn-primary waves-effect" onclick="addData();"><span>เพิ่มข้อมูล</span><i class="material-icons">add</i></button>
                  </div>
                  <div class="">
                    <table id="table1" width="100%" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th>ลำดับ</th>
                          <th align="center">เลขที่ใบรับสินค้า</th>
                          <th align="center">เลขที่ใบสั่งซื้อ</th>
                          <th align="center">ผู้รับเข้า</th>
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
                            $sql_emp = "SELECT * FROM tb_user WHERE userID = '".$rec["create_by"]."' ";
                            $query_emp = $db->query($sql_emp);
                            $rec_emp = $db->db_fetch_array($query_emp);
                            $empname = $rec_emp["firstname"]." ".$rec_emp["lastname"];
                                                //$del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect" onClick="cancelPO(\''.$rec["poID"].'\');">ยกเลิกเอกสาร</a>';
                            $info = ' <a style="'.chk_role($page_key,'isSearch').'" class="btn btn-info btn-xs waves-effect" onClick="infoReceive(\''.$rec["receiveID"].'\');" title="รายละเอียด">'.$img_info.'</a>';
                            ?>
                            <tr>
                              <td align="center"><?php echo ++$i; ?></td>
                              <td><?php echo $rec['receiveID']; ?></td>
                              <td><?php echo $rec['poID']; ?></td>
                              <td><?php echo $empname; ?></td>
                              <td><?php echo conv_date($rec['receiveDate']); ?></td>
                              <td><?php echo $arr_receive_status[$rec['receiveStatus']]; ?></td>
                              <td align="center"><?php echo $info; ?></td>
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
       "searching": false,
     })
     debugger
     if($("#ddl_search").val() == 1){
      $('#bill').show();
    }else if($("#ddl_search").val() == 2){
     $('#user').show();
   }else if($("#ddl_search").val() == 3){
     $('#date').show();
   }
// else if($("#ddl_search").val() == 4){
//  $('#status').show();
// }
});
    function searchData(){
      $('#frm-search').removeAttr('target');
      $("#frm-search").submit();
    }

    function addData(){
      $("#proc").val("add");
      $('#frm-search').removeAttr('target');
      $("#frm-search").attr("action","ReceiveInfo.php").submit();
    }

    function cancelPO(id){
      if(confirm("ต้องการยกเลิกเอกสารใช่หรือไม่ ?")){
        $("#proc").val("cancel");
        $("#receiveID").val(id);
        $('#frm-search').removeAttr('target');
        $("#frm-search").attr("action","process/receive_process.php").submit();
      }
    }

    function infoReceive(id){
      $.post( "process/ajax_response.php", { func: "getReceiveInfo", id: id  }, function( data ) {
        //console.log(data);
        var html = "";

        html += '<div class="modal fade" id="frm-modal" tabindex="-1" role="dialog">';
        html += '<div class="modal-dialog modal-lg" role="document">';
        html += '<div class="modal-content">';

        html += '<div class="modal-header">';
        html += '<div class="row">';

        html += '<div class="col-sm-12 text-right">';
        html += '<h1 class="modal-title" id="largeModalLabel">';
        html += 'ใบรับสินค้า<br/>';
        html += 'เลขที่ใบรับสินค้า : '+id+'<br/>';
        html += 'เลขที่ใบสั่งซื้อ : '+data["receive_head"].poID+'<br/>';
        html += 'วันที่รับสินค้า : '+data["receive_head"].receiveDate;

        html += '</h1>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="modal-body">';


        // html += '<div class="form-group">';
        // html += '<div class="row">';

        // html += '<div class="col-sm-12" style="border:1px dotted #ccc!important;border-radius: 10px;">';
        // html += '<div class="col-sm-offset-1">';
        // html += '<br/">';

        // html += '<div class="row clearfix">';

        // html += '<div class="col-sm-6">';
        // html += '<div class="form-group">';
        // html += '<b>บริษัทคู่ค้า : </b>'+data["receive_head"].sup_name;
        // html += '</div>';
        // html += '</div>';


        // html += '</div>';

        // html += '<div class="row clearfix">';

        // html += '<div class="col-sm-6">';
        // html += '<div class="form-group">';
        // html += 'ที่อยู่ : '+data["receive_head"].sup_address;
        // html += '</div>';
        // html += '</div>';


        // html += '</div>';

        // html += '<div class="row clearfix">';

        // html += '<div class="col-sm-6">';
        // html += '<div class="form-group">';
        // html += 'เบอร์โทรศัพท์บริษัท : '+data["receive_head"].sup_tel;
        // html += '</div>';
        // html += '</div>';

        // html += '<div class="col-sm-6">';
        // html += '<div class="form-group">';
        // html += '<b>สถานะ : </b>'+data["po_head"].poStatusName;
        // html += '</div>';
        // html += '</div>';

        // html += '</div>';


        // html += '</div>';
        // html += '</div>';

        // html += '</div>';
        // html += '</div>';

            // if(data["receive_head"].isCancel == 1 && data["receive_head"].receiveStatus == 1)
            // {
            //     html += '<div class="row">';
            //     html += '<div class="col-sm-12 text-right">';
            //     html += '<a class="btn btn-danger waves-effect" onClick="cancelPO(\''+id+'\');" >ยกเลิกเอกสาร</a>';
            //     html += '</div>';
            //     html += '</div>';
            // }

            // html += '</div>';

            // html += '<div class="modal-body">';
            html += '<table class="table table-bordered table-hover" id="tb-search" style="font-size:14px">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>ลำดับ</th>';
            html += '<th>รหัสสินค้า</th>';
            html += '<th width="15%">ชื่อสินค้า</th>';
            html += '<th width="10%">ประเภท</th>';
            html += '<th>ยี่ห้อ</th>';
            html += '<th width="15%">คุณลักษณะ</th>';
            html += '<th width="15%">ประเภทตำแหน่งเก็บ</th>';
            html += '<th width="10%">ตำแหน่งเก็บ</th>';
            html += '<th>จำนวน</th>';
            html += '<th>รับเข้า</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            if(data["receive_desc"]){
              for(var i = 0; i < data["receive_desc"].length; i++ ){
               html += '<tr>';
               html += '<td align="center">'+(i+1)+'</td>';
               html += '<td align="center">'+data["receive_desc"][i].productCode+'</td>';
               html += '<td>'+data["receive_desc"][i].productName+'</td>';
               html += '<td>'+data["receive_desc"][i].productTypeName+'</td>';
               html += '<td>'+data["receive_desc"][i].brandName+'</td>';
               html += '<td>'+data["receive_desc"][i].attr+'</td>';
               html += '<td>'+data["receive_desc"][i].locationTypeName+'</td>';
               html += '<td>'+data["receive_desc"][i].locationName+'</td>';
               html += '<td align="right">'+addCommas(data["receive_desc"][i].qty)+'</td>';
               html += '<td align="right">'+addCommas(data["receive_desc"][i].receive_qty)+'</td>';
               html += '</tr>';
             }
           }
           else {
            html += '<tr>';
            html += '<td colspan="6" align="center">ไม่พบข้อมูล</td>';
            html += '</tr>';
          }

          html += '</tbody>';

            // html += '<tfoot>';
            // html += '<tr>';
            // html += '<td colspan="7" align="center">รวมสุทธิ</td>';
            // html += '<td align="right">'+addCommas(data["receive_head"].total)+'</td>';
            // html += '</tr>';
            // html += '</tfoot>';

            html += '</table>';
            html += '</div>';

            html += '<div class="modal-footer">';
            html += '<div class="col-sm-12 text-center">';
            html += '<a class="btn btn-default waves-effect" onclick="printReceive(\''+id+'\');">พิมพ์</a>';
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

function printReceive(id){
  $('#receiveID').val(id);
  $('#frm-search').attr('action','report/print_receive.php');
  $('#frm-search').attr('target','_blank');
  $('#frm-search').submit();
}

$("#ddl_search").change(function() {
  $('#bill').hide();
  $('#user').hide();
  $('#date').hide();
  $('#status').hide();
  if($(this).val() == 1){
    $('#bill').show();
  }else if($(this).val() == 2){
   $('#user').show();
 }else if($(this).val() == 3){
   $('#date').show();
 }
// else if($(this).val() == 4){
//  $('#status').show();
// }
});

</script>
