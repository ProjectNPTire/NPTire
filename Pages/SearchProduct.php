<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$path_image = $path."file_productImg/";
$page_key ='1';
$filter = '';
if($ddl_location == 1){
  $filter .= " where locationName  like '%".$txt_search."%'";
}
else if($ddl_location == 2){
  $filter .= " where productTypeName like '%".$txt_search."%'";
}
else if($ddl_location == 3){
  $filter .= " where brandName like '%".$txt_search."%'";
}
else if($ddl_location == 4){
  $filter .= " where productName like '%".$txt_search."%'";
}else{
  $txt_search = "";
}
$field = "* ";
$table = "tb_product
join tb_producttype on tb_product.productTypeID = tb_producttype.productTypeID
join tb_brand on tb_product.brandID = tb_brand.brandID
join tb_productstore on tb_product.productID =  tb_productstore.productID
join tb_location on tb_productstore.locationID = tb_location.locationID";
$pk_id = "productID";
$wh = " {$filter} and tb_productstore.isDeleted != 1";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table .$wh;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

?>

<body class="theme-red">
  <?php include 'MasterPage.php';?>

  <section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2>ค้นหาสินค้า</h2>
            </div>
            <form id="" method="POST">
              <div class="body">
                <!--  <?php echo $ddl_location; ?> -->
                <div class="row clearfix">                
                  <div class="col-md-5">
                    <div class="form-float">
                      <select class="form-control show-tick" data-live-search="true" id="ddl_location" name="ddl_location">
                        <option value=""<?php echo ($ddl_location=="")?"selected":"";?>>ทั้งหมด</option>
                        <option value="1"<?php echo ($ddl_location==1)?"selected":"";?>>ตำแหน่ง</option>
                        <option value="2"<?php echo ($ddl_location==2)?"selected":"";?>>ประเภทสินค้า</option>
                        <option value="3"<?php echo ($ddl_location==3)?"selected":"";?>>ยี่ห้อสินค้า</option>
                        <option value="4"<?php echo ($ddl_location==4)?"selected":"";?>>ชื่อสินค้า</option>
                      </select>  
                    </div>
                  </div>
                  <div class="col-md-5" id="hide">
                    <div class="form-group">
                      <div class="form-line">
                        <input type="text " name="txt_search" id="txt_search" class="form-control" value="<?php echo $txt_search;?>">
                      </div>
                    </div>
                  </div>            
                  <div class="col-md-2">
                    <div class="icon-and-text-button-demo">
                      <button  class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>ลำดับ</th>
                        <th>รหัสสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>ประเภทสินค้า</th>
                        <th>ยี่ห้อสินค้า</th>
                        <th>รุ่นสินค้า</th>
                        <th>ขนาดสินค้า</th>
                        <th>ตำแหน่งจัดเก็บ</th>
                        <th>จำนวน</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($nums>0){
                        $i=0;
                        while ($rec = $db->db_fetch_array($query)) { 
                          $i++;
                          ?>
                          <tr>
                            <td style="text-align: center;"><?php echo $i;?></td>
                            <td style="text-align: center;"><?php echo $rec['productCode'];?></td>
                            <td style="text-align: center;"><?php echo $rec['productName'];?></td>
                            <td style="text-align: center;"><?php echo $rec['productTypeName'];?></td>
                            <td style="text-align: center;"><?php echo get_brand_name($rec['brandID']);?></td>
                            <td style="text-align: center;"><?php echo $rec['modelName'];?></td>
                            <td style="text-align: center;"><?php echo $rec['productSize'];?></td>
                            <td style="text-align: center;"><?php echo $rec['locationName'];?></td>
                            <td style="text-align: center;"><span class="badge bg-green"><?php echo number_format($rec['ps_unit']).' '.$arr_unitType[$rec['unitType']];?></span></td>
                          </tr>
                        <?php }
                      }else{
                        echo '<tr><td colspan="8">ไม่พบข้อมูล</td></tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
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
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
   $("#table1").DataTable({
     "ordering": false,
   });
   if( $("#ddl_location").val() != ""){
      $('#hide').show();
   }else{
     $('#hide').hide();
   }
   //debugger
  //  if ($("#ddl_location").val() == "") {
  //   $(this).attr("selected","selected");
  // }else if ($("#ddl_location").val() == 1) {
  //   $(this).attr("selected","selected");
  // }else if ($("#ddl_location").val() == 2) {
  //   $(this).attr("selected","selected");
  // }else if ($("#ddl_location").val() == 3) {
  //   $(this).attr("selected","selected");
  // }else if ($("#ddl_location").val() == 4) {
  //   $(this).attr("selected","selected");
  // }
});
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


    $('#ModalDetail').modal('show');
  }
  $("#ddl_location").change(function() {
    if($(this).val() != ""){
     $('#hide').show();
   }else{
     $('#hide').hide();
   }
 });
</script>
