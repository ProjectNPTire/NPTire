<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$path_image = $path."file_productImg/";
$page_key ='0';
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
$wh = "productUnit >0 {$filter}";
$orderby = "order by productID DESC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." where ".$wh ." ".$orderby;

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
              <h2>แจ้งเตือนสินค้า</h2>
            </div>
            <div class="body">
             <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ลำดับ</th>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ยี่ห้อสินค้า</th>
                    <th>รุ่นสินค้า</th>
                    <th>ขนาดสินค้า</th>
                    <th>จำนวน</th>
                    <!--    <th></th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql2 ="SELECT * from tb_product where productUnit < orderPoint";
                  $query2 = $db->query($sql2);
                  $nums2 = $db->db_num_rows($query2);
                  if($nums2>0){
                    echo "<script>alert('มีสินค้าที่ต้องสั่งซื้อ".$nums2."รายการ')</script>";
                    $i2=0;
                    while ($rec2 = $db->db_fetch_array($query2)) { $i2++;
                      ?>
                      <tr>
                        <td style="text-align: center;"><?php echo $i2;?></td>
                        <td style="text-align: center;"><?php echo $rec2['productCode'];?></td>
                        <td style="text-align: center;"><?php echo $rec2['productName'];?></td>
                        <td style="text-align: center;"><?php echo get_brand_name($rec2['brandID']);?></td>
                        <td style="text-align: center;"><?php echo $rec2['modelName'];?></td>
                        <td style="text-align: center;"><?php echo $rec2['productSize'];?></td>
                        <td style="text-align: center;"><span class="badge bg-red"><?php echo number_format($rec2['productUnit']).' '.$arr_unitType[$rec2['unitType']];?></span></td>
                      <!--   <td style="text-align: center;">
                         <a  href="OrderInfo.php?supID=<?php echo $rec2['supID'];?>&productID=<?php echo $rec2['productID'];?>&productCode=<?php echo $rec2['productCode'];?>&productName=<?php echo $rec2['productName'];?>&brandName=<?php echo get_brand_name($rec2['brandID']);?>&modelName=<?php echo $rec2['modelName'];?>&productSize=<?php echo $rec2['productSize'];?>" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                          <i class="material-icons">input</i>
                        </a>
                      </td> -->
                    </tr>
                  <?php }
                }else{
                  echo '<tr><td align="center" colspan="7">ไม่พบข้อมูล</td></tr>';
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
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
                </script>
