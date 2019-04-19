<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='2_1';
/*$sql     = " SELECT *
            FROM tb_supplier";*/

/*$query = $db->query($sql);
$nums = $db->db_num_rows($query);*/

$filter = '';
if($s_sup_name){
   $filter .= " and sup_name like '%".$s_sup_name."%'";
}
if($s_sup_email){
   $filter .= " and sup_email like '%".$s_sup_email."%'";
}
if($s_sup_tel){
   $filter .= " and sup_tel like '%".$s_sup_tel."%'";
}
if($s_sup_mobile){
   $filter .= " and sup_mobile like '%".$s_sup_mobile."%'";
}

$field = "* ";
$table = "tb_supplier";
$pk_id = "supID";
$wh = "1=1  {$filter}";
$orderby = "order by supID DESC";
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
                            <h2>รายการคู่ค้า</h2>

                        </div>
                        <div class="body">
                            <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                                <input type="hidden" id="proc" name="proc" value="">
                                <input type="hidden" id="form_page" name="form_page" value="SupplierList.php">
                                <input type="hidden" id="supID" name="supID" value="">
                                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
                                <input type="hidden" id="page" name="page" value="<?php echo $page;?>">

                                <!-- <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                          <b>ชื่อคู่ค้า/บริษัท </b>
                                            <div class="form-line">
                                                <input type="text " name="s_sup_name" id="s_sup_name" class="form-control" placeholder="ชื่อคู่ค้า/บริษัท" value="<?php echo $s_sup_name;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                         <div class="form-group">
                                          <b>E-mail </b>
                                            <div class="form-line">
                                                <input type="text " name="s_sup_email" id="s_sup_email" class="form-control" placeholder="E-mail" value="<?php echo $s_sup_email;?>">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                          <b>เบอร์โทรศัพท์ </b>
                                            <div class="form-line">
                                                <input type="text " name="s_sup_tel" id="s_sup_tel" class="form-control" placeholder="เบอร์โทรศัพท์" value="<?php echo $s_sup_tel;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                         <div class="form-group">
                                          <b>เบอร์มือถือ </b>
                                            <div class="form-line">
                                                <input type="text " name="s_sup_mobile" id="s_sup_mobile" class="form-control" placeholder="เบอร์มือถือ" value="<?php echo $s_sup_mobile;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <div class="icon-and-text-button-demo align-center">
                                    <button type="button" class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                                </div> -->

                                <div class="icon-and-text-button-demo align-right">
                                    <button type="button" class="btn btn-primary waves-effect" style="<?php echo chk_role($page_key,'isadd');?>" onClick="addData();"><span>เพิ่มข้อมูล</span><?php echo $img_add;?></button>
                                </div>
                                <div>
                                    <table id="table1" class="table table-bordered table-striped table-hover dataTable"> <!--js-basic-example-->
                                        <thead>
                                            <tr>
                                                <th width="5%">ลำดับ</th>
                                                <th width="10%" style="text-align:center;">รหัสคู่ค้า</th>
                                                <th width="20%" style="text-align:center;">ชื่อคู่ค้า/บริษัท</th>
                                           <!--      <th><div style="text-align:left">ที่อยู่/การติดต่อ</div></th> -->
                                                <th width="10%" style="text-align:center;">เบอร์โทรศัพท์</th> 
                                                <th width="15%" style="text-align:center;">ชื่อ-สกุล พนักงานที่ติดต่อ</th> 
                                                <th width="10%" style="text-align:center;">เบอร์โทรศัพท์พนักงาน</th>
                                                <th width="10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($nums>0){
                                                $i=0;
                                                while ($rec = $db->db_fetch_array($query)) {
                                                $i++;
                                                $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect" onClick="delData('.$rec['supID'].');">'.$img_del.'</a>';
                                                $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect" onClick="editData('.$rec['supID'].');">'.$img_edit.'</a>';
												$info = ' <a style="'.chk_role($page_key,'isSearch').'" class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['supID'].');">'.$img_info.'</a>';
                                            ?>
                                                <tr>
                                                    <td align="center"><?php echo $i;?></td>
                                                    <td><?php echo $rec['supCode'];?></td>
                                                    <td><?php echo $rec['sup_name'];?></td>
                                           <!--          <td><?php echo $rec['sup_address'];?></td> -->
                                                    <td><?php echo $rec['sup_tel'];?></td>
													 <td><?php echo $rec['namesale']." ".$rec['lastnamesale'];?></td>
                                                    <td><?php echo $rec['mobilesale'];?></td>
                                                    <!--<td><?php echo $rec['sup_email'];?></td> -->
                                                    
													<td style="text-align: center;"><?php echo  $info.$edit.$del;?>
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
				  <div class="row clearfix">
                      <div class="col-sm-12">
                            <b>หมายเหตุ  </b>
                           <span class="form-group" id="txt_note"></span>
                      </div>
				  </div>
                  
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
  if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
    $("#proc").val("delete");
    $("#supID").val(id);
    $("#frm-search").attr("action","process/sup_process.php").submit();
  }
}

</script>
