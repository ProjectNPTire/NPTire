<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$path_image = $path."file_productImg/";
$page_key ='2_3_1';
/*$sql     = " SELECT *
            FROM tb_user
            ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query); */


 $filter = '';
if($s_productCode){
    $filter .= " and productCode  like '%".$s_productCode."%'";
}
if($s_productName){
    $filter .= " and productName like '%".$s_productName."%'";
}
$field = "* ";
$table = "tb_product";
$pk_id = "productID";
$wh = "1=1 and productTypeID in (1,2) {$filter}";
$orderby = "order by productID DESC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." where ".$wh ." ".$orderby .$limit;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

chk_role('2_3','isSearch',1) ;

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
                            <h2>รายการยางและแม็กซ์</h2>
                        </div>
                        <div class="body">
                            <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                                <input type="hidden" id="proc" name="proc" value="">
                                <input type="hidden" id="form_page" name="form_page" value="ProductMainList.php">
                                <input type="hidden" id="productID" name="productID" value="">
                                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
                                <input type="hidden" id="page" name="page" value="<?php echo $page;?>">


                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                          <b>รหัสสินค้า </b>
                                            <div class="form-line">
                                                <input type="text " name="s_productCode" id="s_productCode" class="form-control" placeholder="รหัสสินค้า" value="<?php echo $s_productCode;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                         <div class="form-group">
                                          <b>ชื่อสินค้า </b>
                                            <div class="form-line">
                                                <input type="text " name="s_productName" id="s_productName" class="form-control" placeholder="ชื่อสินค้า" value="<?php echo $s_productName;?>">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                 <div class="icon-and-text-button-demo align-center">
                                    <button  class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                                </div>
                                <div class="icon-and-text-button-demo align-right">
                                    <button  class="btn btn-primary waves-effect" onClick="addData();" style="<?php echo chk_role('2_3','isadd');?>"> <span>เพิ่มข้อมูล</span><?php echo $img_add;?></button>
                                </div>
                                <div>
                                    <table class="table table-bordered table-striped table-hover  dataTable "> <!--js-basic-example-->
                                        <thead>
                                            <tr>
                                                <th width="5%">ลำดับ</th>
                                                <th width="10%">รหัสสินค้า</th>
                                                <th width="15%">ชื่อสินค้า</th>
                                                <th width="10%">ยี่ห้อ</th>
                                                <th width="10%">ขนาด</th>
                                                <th width="10%">รุ่น</th>
                                                <th width="5%">จำนวน</th>
                                                <th width="10%">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($nums>0){
                                                $i=0;
                                               while ($rec = $db->db_fetch_array($query)) {
                                                $i++;
                                                $edit = ' <a style="'.chk_role('2_3','isEdit').'" class="btn bg-orange btn-xs waves-effect"  onClick="editData('.$rec['productID'].');">'.$img_edit.'</a>';
                                                $del = ' <a style="'.chk_role('2_3','isDel').'" class="btn bg-red btn-xs waves-effect"  onClick="delData('.$rec['productID'].');">'.$img_del.'</a>';
                                                $info = ' <a style="'.chk_role('2_3','isSearch').'" class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['productID'].');">'.$img_info.'</a>';  //  data-toggle="modal" data-target="#largeModal" id="btn_info" data-toggle="tooltip" data-placement="top" title="ข้อมูล"
                                                  $location = "";
                                                 $sql_sub  = " SELECT * FROM tb_productstore  where productID ='".$rec['productID']."' ";
                                                 $query_sub = $db->query($sql_sub);
                                                 $nums_sub = $db->db_num_rows($query_sub);
                                                 while ($rec_sub = $db->db_fetch_array($query_sub)) {
                                                     $location .= get_location_name($rec_sub['locationID']).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.number_format($rec_sub['ps_unit']).' '.$arr_unitType[$rec['unitType']]."<br>";
                                                 }
                                            ?>
                                                <tr>
                                                    <td  style="text-align: center;"><?php echo $i+$goto;?></td>
                                                    <td style="text-align: center;"><?php echo $rec['productCode'];?></td>
                                                    <td><?php echo $rec['productName'];?></td>
                                                    <td style="text-align: center;"><?php echo get_brand_name($rec['brandID']);?></td>
                                                    <td style="text-align: center;"><?php echo $rec['productSize'];?></td>
                                                    <td style="text-align: center;"><?php echo $rec['modelName'];?></td>
                                                    <td style="text-align: center;"><?php echo number_format($rec['productUnit']).' '.$arr_unitType2[$rec['unitType']];?></td>
                                                    <td style="text-align: center;"><?php echo $info.$edit.$del;?>
                                                      <input type="hidden" id="show_code_<?php echo $rec['productID'];?>" value="<?php echo $rec['productCode'];?>" >
                                                      <input type="hidden" id="show_name_<?php echo $rec['productID'];?>" value="<?php echo $rec['productName'];?>" >
                                                      <input type="hidden" id="show_brand_<?php echo $rec['productID'];?>" value="<?php echo get_brand_name($rec['brandID']);?>" >
                                                      <input type="hidden" id="show_size_<?php echo $rec['productID'];?>" value="<?php echo $rec['productSize'];?>" >
                                                      <input type="hidden" id="show_model_<?php echo $rec['productID'];?>" value="<?php echo $rec['modelName'];?>" >
                                                      <input type="hidden" id="show_unit_<?php echo $rec['productID'];?>" value="<?php echo $rec['productUnit'].' '.$arr_unitType[$rec['unitType']];?>" >
                                                      <input type="hidden" id="show_location_<?php echo $rec['productID'];?>" value="<?php echo $location;?>" >
                                                      <input type="hidden" id="show_productImg_<?php echo $rec['productID'];?>" value="<?php echo $rec['productImg'];?>" >
                                                      <input type="hidden" id="show_detail_<?php echo $rec['productID'];?>" value="<?php echo $rec['productDetail'];?>" >

                                                         <!--  <span  data-toggle="modal" data-target="#largeModal">
                                                            <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                                <i class="material-icons">info_outline</i>
                                                            </button>
                                                        </span> -->
                                                    </td>
                                                </tr>
                                            <?php }
                                            }else{
                                                echo '<tr><td colspan="7">ไม่พบข้อมูล</td></tr>';
                                            }
                                            ?>


                                        </tbody>
                                    </table>
                                       <?php echo ($nums > 0) ? endPaging("frm-search", $total_record) : ""; ?>
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
                    <h4 class="modal-title" id="largeModalLabel">ข้อมูลสินค้า</h4>
                </div>
                <div class="modal-body">
                  <div class="align-center">
                      <div class="col-sm-12">
                           <div class="form-group" id="txt_img"></div>
                      </div>

                  </div>
                  <div class="row clearfix">
                      <div class="col-sm-4">
                            <b>รหัสสินค้า</b>
                           <div class="form-group" id="txt_code"></div>
                      </div>
                      <div class="col-sm-4">
                            <b>ชื่อสินค้า</b>
                           <div class="form-group" id="txt_name"></div>
                      </div>
                  </div>
                  <div class="row clearfix">
                      <div class="col-sm-4">
                            <b>ยี่ห้อ</b>
                           <div class="form-group" id="txt_brand"></div>
                      </div>
                      <div class="col-sm-4">
                            <b>รุ่น</b>
                           <div class="form-group" id="txt_model"></div>
                      </div>
                      <div class="col-sm-4">
                            <b>ขนาด</b>
                           <div class="form-group" id="txt_size"></div>
                      </div>
                      <div class="col-sm-4">
                            <b>จำนวน</b>
                           <div class="form-group" id="txt_unit"></div>
                      </div>
                  </div>
                  <div class="row clearfix">
                      <div class="col-sm-12">
                        <b>รายละเอียด</b>
                       <div class="form-group" id="txt_detail"></div>
                      </div>
                  </div>
                </div>
                <div class="align-left">
                    <div class="col-sm-12">
                       <b>ตำแหน่งจัดเก็บสินค้า</b>
                         <div class="form-group" id="txt_location"></div>
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

function searchData(){
  $("#frm-search").submit();
}
function infoData(id){

  var img = '<img width="410px" height="307px" src="<?php echo $path_image;?>'+$('#show_productImg_'+id).val()+'">';
  $('#txt_img').html(img);
  $('#txt_name').html($('#show_name_'+id).val());
  $('#txt_code').html($('#show_code_'+id).val());
  $('#txt_brand').html($('#show_brand_'+id).val());
  $('#txt_size').html($('#show_size_'+id).val());
  $('#txt_model').html($('#show_model_'+id).val());
  $('#txt_unit').html($('#show_unit_'+id).val());
  $('#txt_location').html($('#show_location_'+id).val());
  $('#txt_detail').html($('#show_detail_'+id).val());



   // $('#txt_id').html($('#show_idcard_'+id).val());
   // $('#txt_birthday').html($('#show_birthday_'+id).val());
   // $('#txt_address').html($('#show_address_'+id).val());
   // $('#txt_mobile').html($('#show_mobile_'+id).val());
   // $('#txt_email').html($('#show_email_'+id).val());

  $('#ModalDetail').modal('show');
}
function addData(){
  $("#proc").val("add");
  $("#frm-search").attr("action","ProductMainInfo.php").submit();
}
function editData(id){
  $("#proc").val("edit");
  $("#productID").val(id);
  $("#frm-search").attr("action","ProductMainInfo.php").submit();
}
function delData(id){
  if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
    $("#proc").val("delete");
    $("#productID").val(id);
    $("#frm-search").attr("action","process/ProductMain_process.php").submit();
  }
}

</script>
