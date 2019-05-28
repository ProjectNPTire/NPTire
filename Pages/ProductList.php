<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$path_image = $path."file_productImg/";
$page_key ='3_6';
/*$sql     = " SELECT *
            FROM tb_user
            ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query); */


$filter = '';
// if($s_productCode){
//   $filter .= " and productCode  like '%".$s_productCode."%'";
// }
// if($s_productName){
//   $filter .= " and productName like '%".$s_productName."%'";
// }

if($ddl_search == 1){
  if($s_billNo != ""){
    $filter .= " and productName like '%".$s_billNo."%'";
  }
}else if($ddl_search == 2){
  if($s_userID != ""){
   $filter .= " and productTypeID ='".$s_userID."'";
 }
}else if($ddl_search == 3){
  if($s_sup_id != ""){
   $filter .= " and brandID ='".$s_sup_id."'";
 }
}else if($ddl_search == 4){
  if($s_billNo != ""){
    $filter .= " and modelName like '%".$s_billNo."%'";
  }
}else if($ddl_search == 5){
  if($s_billNo != ""){
   $filter .= " and productSize like '%".$s_billNo."%'";
 }
}else if($ddl_search == 6){
  if($status != ""){
   $filter .= " and isEnabled = '".$status."'";
 }
}

$field = "* ";
$table = "tb_product";
$pk_id = "productID";
$wh = "1=1 {$filter}";
$orderby = "order by productTypeID ASC,productID DESC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." where ".$wh ." ".$orderby;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

chk_role($page_key,'isSearch',1) ;

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
              <h2>รายการสินค้าอื่น</h2>
            </div>
            <div class="body">
              <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >

                <input type="hidden" id="proc" name="proc" value="">
                <input type="hidden" id="form_page" name="form_page" value="ProductList.php">
                <input type="hidden" id="productID" name="productID" value="">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page;?>">

              <!--   <div class="row clearfix">
                  <div class="col-sm-5">
                    <div class="form-group">
                      <div class="form-group form-float">
                        <select name="ddl_search" id="ddl_search" class="form-control show-tick" data-live-search="true"  >
                          <option value=""<?php echo ($ddl_search=="")?"selected":"";?>>แสดงข้อมูลทั้งหมด</option>
                          <option value="1"<?php echo ($ddl_search==1)?"selected":"";?>>ชื่อสินค้า</option>
                          <option value="2"<?php echo ($ddl_search==2)?"selected":"";?>>ประเภทสินค้า</option>
                          <option value="3"<?php echo ($ddl_search==3)?"selected":"";?>>ยี่ห้อสินค้า</option>
                          <option value="6"<?php echo ($ddl_search==6)?"selected":"";?>>สถานะ</option>
                        </select>
                      </div>
                    </div>                     
                  </div>
                  <div class="col-sm-5" id="name" style="display: none;">
                    <div class="form-group">
                      <div class="form-line">
                        <input type="text " name="s_billNo" id="s_billNo" class="form-control" placeholder="ชื่อ" value="<?php echo $s_billNo;?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-5" id="type" style="display: none;">
                    <div class="form-group">
                      <div class="form-group form-float">
                        <select name="s_userID" id="s_userID" class="form-control show-tick" data-live-search="true"  >
                          <option value="">เลือก</option>
                          <?php
                          $s_p=" SELECT * from tb_producttype where isEnabled = 1";
                          $q_p = $db->query($s_p);
                          $n_p = $db->db_num_rows($q_p);
                          while($r_p = $db->db_fetch_array($q_p)){?>
                            <option value="<?php echo $r_p['productTypeID'];?>"<?php echo ($s_userID==$r_p['productTypeID'])?"selected":"";?>> <?php echo $r_p['productTypeName'];?></option>

                          <?php }  ?>
                        </select>
                      </div>
                    </div>                     
                  </div>
                  <div class="col-sm-5" id="brand" style="display: none;">
                    <div class="form-group">
                      <div class="form-group form-float">
                        <select name="s_sup_id" id="s_sup_id" class="form-control show-tick" data-live-search="true"  >
                          <option value="">เลือก</option>
                          <?php
                          $s_p=" SELECT * from tb_brand where isEnabled = 1";
                          $q_p = $db->query($s_p);
                          $n_p = $db->db_num_rows($q_p);
                          while($r_p = $db->db_fetch_array($q_p)){?>
                            <option value="<?php echo $r_p['brandID'];?>"<?php echo ($s_sup_id==$r_p['brandID'])?"selected":"";?>> <?php echo $r_p['brandName'];?></option>

                          <?php }  ?>
                        </select>
                      </div>
                    </div>                     
                  </div>
                  <div class="col-sm-5" id="status" style="display: none;">
                    <div class="form-group">
                      <div class="form-group form-float">
                        <select name="status" id="s_userID" class="form-control show-tick" data-live-search="true"  >
                          <?php asort($arr_active);
                          foreach ($arr_active as $key => $value) { ?>
                           <option value="<?php echo $key;?>"  
                            <?php 
                            if(($rec['isEnabled']  != "")){
                              echo ($rec['isEnabled']==$key)?"selected":"";
                            }
                            ?>><?php echo $value;?></option>
                          <?php }  ?>
                        </select>
                      </div>
                    </div>                     
                  </div>
                  <div class="col-sm-2">
                    <div class="icon-and-text-button-demo align-center">
                      <button  class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                    </div>
                  </div> 
                </div> -->
                <div class="icon-and-text-button-demo align-right">
                  <button  class="btn btn-primary waves-effect" onClick="addData();" style="<?php echo chk_role($page_key,'isadd');?>"> <span>เพิ่มข้อมูล</span><?php echo $img_add;?></button>
                </div>
                <div>
                  <table id="table1" class="table table-bordered table-striped table-hover  dataTable "> <!--js-basic-example-->
                    <thead>
                      <tr>
                        <th width="5%">ลำดับ</th>
                        <th width="5%" style="text-align: center;">รหัสสินค้า</th>
                        <th width="20%" style="text-align:center;">ชื่อสินค้า</th>
                        <th width="10%" style="text-align:center;">ประเภทสินค้า</th>
                        <th width="5%" style="text-align:center;">ยี่ห้อ</th>
                        <th width="5%" style="text-align:center;">คุณลักษณะ</th>
                        <th width="5%" style="text-align:center;">จำนวน</th>
                        <th width="5%" style="text-align:center;">หน่วย</th>
                        <th width="10%" style="text-align:center;">สถานะ</th>
                        <th width="15%" style="text-align:center;"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($nums>0){
                        $i=0;
                        while ($rec = $db->db_fetch_array($query)) {
                          $i++;
                          $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect"  onClick="editData('.$rec['productID'].');">'.$img_edit.'</a>';
                            // $del = ' <a style="'.chk_role('2_3','isDel').'" class="btn bg-red btn-xs waves-effect"  onClick="delData('.$rec['productID'].');">'.$img_del.'</a>';
                            $info = ' <a style="'.chk_role($page_key,'isSearch').'" class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['productID'].');">'.$img_info.'</a>';  //  data-toggle="modal" data-target="#largeModal" id="btn_info" data-toggle="tooltip" data-placement="top" title="ข้อมูล"
                            $location = "";
                            $sql_loc  = " SELECT * FROM tb_productstore  where productID ='".$rec['productID']."' ";
                            $query_loc = $db->query($sql_loc);
                            $nums_loc = $db->db_num_rows($query_loc);
                            while ($rec_loc = $db->db_fetch_array($query_loc)) {
                             $location .= get_location_name($rec_loc['locationID']).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.number_format($rec_loc['ps_unit']).' '.$arr_unitType[$rec['unitType']]."<br>";
                           }

                           $week = "";
                           $sql_week  = " SELECT * FROM tb_week  where productID ='".$rec['productID']."' ";
                           $query_week = $db->query($sql_week);
                           $nums_week = $db->db_num_rows($query_week);
                           while ($rec_week = $db->db_fetch_array($query_week)) {
                             $week .= number_format($rec_week['week']).' สัปดาห์&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.number_format($rec_week['unit'])." เส้น <br>";
                           }

                           $supplier = "";
                           $sql_sub  = " SELECT * FROM tb_productsupplier  where productID ='".$rec['productID']."' ";
                           $query_sub = $db->query($sql_sub);
                           $nums_sub = $db->db_num_rows($query_sub);
                           while ($rec_sub = $db->db_fetch_array($query_sub)) {
                            $supplier .= get_sup_name($rec_sub['supID'])."<br>";
                          }

                          $sql_attr = "SELECT tb_attribute.attrName, tb_productattr.value
                          FROM tb_productattr JOIN tb_attribute ON tb_productattr.attrID = tb_attribute.attrID
                          WHERE productID = '".$rec["productID"]."'";
                          $query_attr = $db->query($sql_attr);
                          $nums_attr = $db->db_num_rows($query_attr);

                          $attr = '';

                          if($nums_attr > 0){
                            while($rec_attr = $db->db_fetch_array($query_attr))
                            {
                              $attr .= $rec_attr['attrName'].": ".$rec_attr['value']."<br>";
                            }
                          }else{
                            $attr = '-';
                          }

                          ?>
                          <tr>
                            <td align="center"><?php echo $i+$goto;?></td>
                            <td><?php echo $rec['productCode'];?></td>
                            <td><?php echo $rec['productName'];?></td>
                            <td><?php echo get_productType_name($rec['productTypeID']);?></td>
                            <td><?php echo get_brand_name($rec['brandID']);?></td>
                            <td><?php echo $attr;?></td>
                            <td style="text-align:right;"><?php echo number_format($rec['productUnit']);?></td>
                            <td><?php echo $arr_unitType[$rec['unitType']];?></td>
                            <td><?php echo $arr_active[$rec['isEnabled']];?></td>
                            <td style="text-align:center;"><?php echo $info.$edit.$del;?>
                            <input type="hidden" id="show_code_<?php echo $rec['productID'];?>" value="<?php echo $rec['productCode'];?>" >
                            <input type="hidden" id="show_name_<?php echo $rec['productID'];?>" value="<?php echo $rec['productName'];?>" >
                            <input type="hidden" id="show_type_<?php echo $rec['productID'];?>" value="<?php echo get_productType_name($rec['productTypeID']);?>" >
                            <input type="hidden" id="show_brand_<?php echo $rec['productID'];?>" value="<?php echo get_brand_name($rec['brandID']);?>" >
                            <input type="hidden" id="show_size_<?php echo $rec['productID'];?>" value="<?php echo $rec['productSize'];?>" >
                            <input type="hidden" id="show_model_<?php echo $rec['productID'];?>" value="<?php echo $rec['modelName'];?>" >
                            <input type="hidden" id="show_unit_<?php echo $rec['productID'];?>" value="<?php echo $rec['productUnit'].' '.$arr_unitType[$rec['unitType']];?>" >
                            <input type="hidden" id="show_location_<?php echo $rec['productID'];?>" value="<?php echo $location;?>" >
                            <input type="hidden" id="show_supplier_<?php echo $rec['productID'];?>" value="<?php echo $supplier;?>" >
                            <input type="hidden" id="show_productImg_<?php echo $rec['productID'];?>" value="<?php echo $rec['productImg'];?>" >
                            <input type="hidden" id="show_detail_<?php echo $rec['productID'];?>" value="<?php echo $rec['productDetail'];?>" >
                            <input type="hidden" id="show_week_<?php echo $rec['productID'];?>" value="<?php echo $week;?>" >

                                     <!--  <span  data-toggle="modal" data-target="#largeModal">
                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                            <i class="material-icons">info_outline</i>
                                        </button>
                                      </span> -->
                                    </td>
                                  </tr>
                                <?php }
                              }else{
                                echo '<tr><td align="center" colspan="11">ไม่พบข้อมูล</td></tr>';
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
                <div class="col-sm-4">
                  <b>ประเภทสินค้า</b>
                  <div class="form-group" id="txt_type"></div>
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
              </div>
              <div class="row clearfix">
                <div class="col-sm-4">
                  <b>จำนวน</b>
                  <div class="form-group" id="txt_unit"></div>
                </div>
                <div class="col-sm-8">
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

           <div class="align-left">
            <div class="col-sm-12">
             <b>บริษัทคู่ค้า</b>
             <div class="form-group" id="txt_supplier"></div>
           </div>
         </div>
         <div class="align-left">
          <div class="col-sm-12">
           <b>สัปดาห์ยาง</b>
           <div class="form-group" id="txt_week"></div>
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
   if($("#ddl_search").val() == 1 || $("#ddl_search").val() == 4 || $("#ddl_search").val() == 5){
    $('#name').show();
  }else if($("#ddl_search").val() == 2){
   $('#type').show();
 }else if($("#ddl_search").val() == 3){
   $('#brand').show();
 }else if($("#ddl_search").val() == 6){
   $('#status').show();
 }
});

  function searchData(){
    $("#frm-search").submit();
  }
  function infoData(id){

    var img = '<img width="410px" height="307px" src="<?php echo $path_image;?>'+$('#show_productImg_'+id).val()+'">';
    $('#txt_img').html(img);
    $('#txt_name').html($('#show_name_'+id).val());
    $('#txt_code').html($('#show_code_'+id).val());
    $('#txt_type').html($('#show_type_'+id).val());
    $('#txt_brand').html($('#show_brand_'+id).val());
    $('#txt_model').html($('#show_model_'+id).val());
    $('#txt_size').html($('#show_size_'+id).val());
    $('#txt_unit').html($('#show_unit_'+id).val());
    $('#txt_location').html($('#show_location_'+id).val());
    $('#txt_detail').html($('#show_detail_'+id).val());
    $('#txt_supplier').html($('#show_supplier_'+id).val());
    $('#txt_week').html($('#show_week_'+id).val());




   // $('#txt_id').html($('#show_idcard_'+id).val());
   // $('#txt_birthday').html($('#show_birthday_'+id).val());
   // $('#txt_address').html($('#show_address_'+id).val());
   // $('#txt_mobile').html($('#show_mobile_'+id).val());
   // $('#txt_email').html($('#show_email_'+id).val());

   $('#ModalDetail').modal('show');
 }
 function addData(){
  $("#proc").val("add");
  $("#frm-search").attr("action","ProductInfo.php").submit();
}
function editData(id){
  $("#proc").val("edit");
  $("#productID").val(id);
  $("#frm-search").attr("action","ProductInfo.php").submit();
}
function delData(id){
  var productID = id;
  if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
    $.ajaxSetup({async: false});
    $.post('process/get_process.php',{proc:'chkDelData_Product',productID:productID},function(data){
      //alert(data);
      if(data > 0){
        alert('ไม่สามารถลบข้อมูลได้ เนื่องจากมีสินค้านี้อยู่ในคลัง');
        return false;
      }else{
        $("#proc").val("delete");
        $("#productID").val(id);
        $("#frm-search").attr("action","process/Product_process.php").submit();
      }
    },'json');
  }
}

$("#ddl_search").change(function() {
  $('#name').hide();
  $('#type').hide();
  $('#brand').hide();
  $('#other1').hide();
  $('#status').hide();
  if($(this).val() == 1 || $(this).val() == 4 || $(this).val() == 5){
    $('#name').show();
  }else if($(this).val() == 2){
   $('#type').show();
 }else if($(this).val() == 3){
   $('#brand').show();
 }else if($(this).val() == 6){
   $('#status').show();
 }
});

</script>
