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
$wh = "1=1 and productUnit >0 {$filter}";
$orderby = "order by productID DESC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." where ".$wh ." ".$orderby .$limit;

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
                            <h2>ตำแหน่งสินค้า</h2>
                        </div>
                        <form id="" method="POST">
                            <div class="body">
                              <div class="row clearfix">
                                  <div class="col-sm-4">
                                      <div class="form-group">
                                        <b>รหัสสินค้า </b>
                                          <div class="form-line">
                                              <input type="text " name="s_productCode" id="s_productCode" class="form-control" placeholder="รหัสสินค้า" value="<?php echo $s_productCode;?>">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-4">
                                       <div class="form-group">
                                        <b>ชื่อสินค้า </b>
                                          <div class="form-line">
                                              <input type="text " name="s_productName" id="s_productName" class="form-control" placeholder="ชื่อสินค้า" value="<?php echo $s_productName;?>">
                                          </div>

                                      </div>
                                  </div>
                                    <div class="col-sm-4">
                                      <button  class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                                    </div>
                              </div>

                               <div class="icon-and-text-button-demo align-center">
                              </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">ลำดับ</th>
                                                <th width="10%">รหัสสินค้า</th>
                                                <th width="15%">ชื่อสินค้า</th>
                                                <th width="10%">ยี่ห้อ</th>
                                                <th width="10%">ขนาด</th>
                                                <th width="10%">รุ่น</th>
                                                <th width="5%">จำนวน</th>
                                                <th width="15%">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($nums>0){
                                                $i=0;
                                               while ($rec = $db->db_fetch_array($query)) {
                                                $i++;
                                               $info = ' <a  class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['productID'].');" title="รายละเอียดสินค้า">'.$img_info.'</a>';  //  data-toggle="modal" data-target="#largeModal" id="btn_info" data-toggle="tooltip" data-placement="top" title="ข้อมูล"
                                                  $location = "";
                                                  // $sql_sub  = " SELECT tb_productstore.*, GROUP_CONCAT(`locationName`) as locationName FROM tb_productstore  
                                                  // join tb_location on tb_productstore.locationID = tb_location.locationID  where productID ='".$rec['productID']."' ";
                                                  $sql_sub  = " SELECT tb_productstore.*,locationName FROM tb_productstore join tb_location on tb_productstore.locationID = tb_location.locationID where productID ='".$rec['productID']."' ";
                                                 $query_sub = $db->query($sql_sub);
                                                 $nums_sub = $db->db_num_rows($query_sub);
                                                 while ($rec_sub = $db->db_fetch_array($query_sub)) {
                                                     // $location .= get_location_name($rec_sub['locationID']).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.number_format($rec_sub['ps_unit']).' '.$arr_unitType2[$rec['unitType']]."<br>";
                                                  $location .= $rec_sub['locationName'].",";
                                                 }
                                                 $location = rtrim($location, ',')
                                            ?>
                                                <tr>
                                                    <td  style="text-align: center;"><?php echo $i+$goto;?></td>
                                                    <td><?php echo $rec['productCode'];?></td>
                                                    <td><?php echo $rec['productName'];?></td>
                                                    <td><?php echo get_brand_name($rec['brandID']);?></td>
                                                    <td><?php echo $rec['productSize'];?></td>
                                                    <td><?php echo $rec['modelName'];?></td>
                                                    <td><?php echo number_format($rec['productUnit']);?></td>
                                                    <td><b><?php echo $location;?></b></td>

                                                    <!-- <td style="text-align: center;"><?php echo $info;?>
                                                      <input type="hidden" id="show_code_<?php echo $rec['productID'];?>" value="<?php echo $rec['productCode'];?>" >
                                                      <input type="hidden" id="show_name_<?php echo $rec['productID'];?>" value="<?php echo $rec['productName'];?>" >
                                                      <input type="hidden" id="show_brand_<?php echo $rec['productID'];?>" value="<?php echo get_brand_name($rec['brandID']);?>" >
                                                      <input type="hidden" id="show_unit_<?php echo $rec['productID'];?>" value="<?php echo $rec['productUnit'].' '.$arr_unitType[$rec['unitType']];?>" >
                                                      <input type="hidden" id="show_location_<?php echo $rec['productID'];?>" value="<?php echo $location;?>" >
                                                      <input type="hidden" id="show_productImg_<?php echo $rec['productID'];?>" value="<?php echo $rec['productImg'];?>" >
                                                      <?php //if()?>
                                                      <input type="hidden" id="show_detail_<?php echo $rec['productID'];?>" value="<?php echo $rec['productDetail'];?>" > -->

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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                         $sql2 ="SELECT * from tb_product where productUnit < 10";
                                        $query2 = $db->query($sql2);
                                        $nums2 = $db->db_num_rows($query2);
                                        if($nums2>0){
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
                                            <td style="text-align: center;">
                                               <a  href="OrderList.php" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                                                    <i class="material-icons">input</i>
                                                </a>
                                            </td>
                                        </tr>
                                     <?php }
                                        }else{
                                            echo '<tr><td colspan="8">ไม่พบข้อมูล</td></tr>';
                                        }
                                    ?>

                                    <!-- <tr>
                                        <td>1</td>
                                        <td>TY2156516H20</td>
                                        <td>TOYO H20 215/65R16</td>
                                        <td>TOYO</td>
                                        <td>H20</td>
                                        <td>215/65R16</td>
                                        <td><span class="badge bg-red">1 ชุด</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                                                <i class="material-icons">input</i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>YK195515AE50</td>
                                        <td>YOKOHAMA AE50 195/55R15</td>
                                        <td>YOKOHAMA</td>
                                        <td>AE50</td>
                                        <td>195/55R15</td>
                                        <td><span class="badge bg-red">1 ชุด</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                                                <i class="material-icons">input</i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>BS2057015DUELERH/T684</td>
                                        <td>BRIDGESTONE DUELER H/T 684 205/70R15</td>
                                        <td>BRIDGESTONE</td>
                                        <td>DUELER H/T 684</td>
                                        <td>205/70R15</td>
                                        <td><span class="badge bg-red">1 ชุด</span></td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="สั่งซื้อ">
                                                <i class="material-icons">input</i>
                                            </button>
                                        </td>
                                    </tr> -->
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
