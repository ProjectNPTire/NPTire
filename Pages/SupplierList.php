<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='2_2';


$field = "* ";
$table = "tb_supplier";
$pk_id = "supID";
//$wh = "1=1  {$filter}";
$orderby = "order by supID DESC";
//$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." ".$orderby;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
//$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));
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
              <h2>รายการบริษัทคู่ค้า</h2>

            </div>
            <div class="body">
              <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                <input type="hidden" id="proc" name="proc" value="">
                <input type="hidden" id="form_page" name="form_page" value="SupplierList.php">
                <input type="hidden" id="supID" name="supID" value="">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page;?>">
                <div class="icon-and-text-button-demo align-right">
                  <button type="button" class="btn btn-primary waves-effect" style="<?php echo chk_role($page_key,'isadd');?>" onClick="addData();"><span>เพิ่มข้อมูล</span><?php echo $img_add;?></button>
                </div>
                <div>
                  <table id="table1" class="table table-bordered table-striped table-hover dataTable"> <!--js-basic-example-->
                    <thead>
                      <tr>
                        <th width="5%">ลำดับ</th>
                        <th>รหัสคู่ค้า</th>
                        <th width="25%">ชื่อบริษัทคู่ค้า</th>
                        <!--      <th><div style="text-align:left">ที่อยู่/การติดต่อ</div></th> -->
                        <th>เบอร์โทรศัพท์</th> 
                        <th width="15%">ชื่อ-สกุล<br>พนักงานที่ติดต่อ</th> 
                        <th width="15%">เบอร์โทรศัพท์พนักงาน</th>
                        <th>สถานะ</th>
                        <th width="10%"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($nums>0){
                        $i=0;
                        while ($rec = $db->db_fetch_array($query)) {
                          $i++;
                                            // $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect" onClick="delData('.$rec['supID'].');">'.$img_del.'</a>';
                          $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect" onClick="editData('.$rec['supID'].');">'.$img_edit.'</a>';
                          $info = ' <a style="'.chk_role($page_key,'isSearch').'" class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['supID'].');">'.$img_info.'</a>';
                          ?>
                          <tr>
                            <td><?php echo $i;?></td>
                            <td style="text-align: left;"><?php echo $rec['supCode'];?></td>
                            <td style="text-align: left;"><?php echo $rec['sup_name'];?></td>
                            <!--          <td><?php echo $rec['sup_address'];?></td> -->
                            <td style="text-align: left;"><?php echo $rec['sup_tel'];?></td>
                            <td style="text-align: left;"><?php echo $rec['namesale']." ".$rec['lastnamesale'];?></td>
                            <td style="text-align: left;"><?php echo $rec['mobilesale'];?></td>
                            <td><?php 
                            if ($rec['isEnabled'] == 1) { ?>
                              <i class="material-icons" style="color: green">check_circle</i>
                            <?php } else{ ?>                                 
                              <i class="material-icons" style="color: red">remove_circle</i>
                            <?php } ?>
                          </td>

                          <td><?php echo  $info.$edit.$del;?>
                          <input type="hidden" id="show_sup_name_<?php echo $rec['supID'];?>" value="<?php echo $rec['sup_name'];?>" >
                          <input type="hidden" id="show_sup_tel_<?php echo $rec['supID'];?>" value="<?php echo $rec['sup_tel'];?>" >
                          <input type="hidden" id="show_sup_address_<?php echo $rec['supID'];?>" value="<?php echo $rec['sup_address'].' '.' ตำบล/แขวง '.get_subDistrictID_name($rec['subDistrictID']).' อำเภอ/เขต '.get_district_name($rec['districtID']).' จังหวัด '.get_prov_name($rec['provinceID']).' '.$rec['zipcode'];?>" >
                          <input type="hidden" id="show_namesale_<?php echo $rec['supID'];?>" value="<?php echo $rec['namesale']." ".$rec['lastnamesale'];?>" >
                          <input type="hidden" id="show_mobilesale_<?php echo $rec['supID'];?>" value="<?php echo $rec['mobilesale'];?>" >
                          <input type="hidden" id="show_idline_<?php echo $rec['supID'];?>" value="<?php echo $rec['idline'];?>" >
                          <input type="hidden" id="show_note_<?php echo $rec['supID'];?>" value="<?php echo $rec['note'];?>" >

                        </td>
                      </tr>
                    <?php }
                  } ?>
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
</div>
</section>

<?php include 'js.php';?>
</body>

</html>

<!-- Large Size -->
<div class="modal fade" id="ModalDetail" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="largeModalLabel">ข้อมูลคู่ค้า</h4>
      </div>
      <div class="modal-body">

        <div class="row clearfix">
          <div class="col-sm-12"  style="float:left">
            <b>ชื่อบริษัท </b>
            <span class="form-group" id="txt_subname"></span>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <b>เบอร์โทรศัพท์บริษัท</b>
            <span class="form-group" id="txt_suptel"></span>
          </div>

        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <b>ที่อยู่</b>
            <span class="form-group" id="txt_supaddress"></span>
          </div>

        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <b>ชื่อ-สกุลพนักงานขาย  </b>
            <span class="form-group" id="txt_namesale"></span>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <b>เบอร์โทรศัพท์มือถือ  </b>
            <span class="form-group" id="txt_mobilesale"></span>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <b>IDLine  </b>
            <span class="form-group" id="txt_idline"></span>
          </div>
        </div>
                      <!--<div class="row clearfix">
                        <div class="col-sm-12">
                          <b>หมายเหตุ  </b>
                          <span class="form-group" id="txt_note"></span>
                        </div>
                      </div> -->

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ปิด</button>
                    </div>
                     <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                      </div> -->
                    </div>
                  </div>
                </div>
                <script>
                  $(document).ready(function() {
                   $("#table1").DataTable({
                     "ordering": false,
                   })
                   if($('#ddl_search').val() == 1){
                     $('#sup').show();
                   }else if($('#ddl_search').val() == 2){
                     $('#user').show();
                   }else if($('#ddl_search').val() == 3){
                     $('#status').show();
                   }
                 });
                  function searchData(){
                    $("#frm-search").submit();
                  }

                  function infoData(id){  
                   $('#txt_subname').html($('#show_sup_name_'+id).val());
                   $('#txt_suptel').html($('#show_sup_tel_'+id).val());
                   $('#txt_supaddress').html($('#show_sup_address_'+id).val());
                   $('#txt_namesale').html($('#show_namesale_'+id).val());
                   $('#txt_mobilesale').html($('#show_mobilesale_'+id).val());
                   $('#txt_idline').html($('#show_idline_'+id).val());
                   $('#txt_note').html($('#show_note_'+id).val());


                   $('#ModalDetail').modal('show');
                 }
                 function addData(){
                  $("#proc").val("add");
                  $("#frm-search").attr("action","SupplierInfo.php").submit();
                }
                function editData(id){
                  $("#proc").val("edit");
                  $("#supID").val(id);
                  $("#frm-search").attr("action","SupplierInfo.php").submit();
                }
                function delData(id){
                  var suppliernID = id;
                  if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
                   $.ajaxSetup({async: false});
                   $.post('process/get_process.php',{proc:'chkDelData_Supplier',suppliernID:suppliernID},function(data){
                    if(data > 0){
                      alert('ไม่สามารถลบข้อมูลได้ เนื่องจากบริษัทคู่ค้านี้มีการใช้ข้อมูลอยู่');
                      return false;
                    }else{
                      $("#proc").val("delete");
                      $("#supID").val(id);
                      $("#frm-search").attr("action","process/sup_process.php").submit();
                    }
                  },'json');
                 }

               }

               $("#ddl_search").change(function() {

                $('#sup').hide();
                $('#user').hide();
                $('#status').hide();
                if($(this).val() == 1){
                 $('#sup').show();
               }else if($(this).val() == 2){
                 $('#user').show();
               }else if($(this).val() == 3){
                 $('#status').show();
               }
             });
           </script>
