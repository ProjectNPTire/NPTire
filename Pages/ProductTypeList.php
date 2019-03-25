<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='2_1';

$filter = '';
if($s_productTypeName){
   $filter .= " and productTypeName like '%".$s_productTypeName."%'";
}

$field = "* ";
$table = "tb_producttype";
$pk_id = "productTypeID";
$wh = "1=1   {$filter}";
$orderby = "order by productTypeID DESC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." where ".$wh ." ".$orderby .$limit;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

chk_role($page_key,'isSearch',1) ;
?>

<body class="theme-red">
    <?php include 'MasterPage.php';?>

    <section class="content">
        <div class="container-fluid">
        	<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>รายการประเภทสินค้า</h2>
                        </div>
                        <div class="body">
                          <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                              <input type="hidden" id="proc" name="proc" value="">
                              <input type="hidden" id="form_page" name="form_page" value="ProductTypeList.php">
                              <input type="hidden" id="productTypeID" name="productTypeID" value="">
                              <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
                              <input type="hidden" id="page" name="page" value="<?php echo $page;?>">

                              <!-- <div class="row clearfix">
                                  <div class="col-sm-10">
                                      <div class="form-group">
                                        <b>ประเภทสินค้า </b>
                                          <div class="form-line">
                                              <input type="text " name="s_productTypeName" id="s_productTypeName" class="form-control" placeholder="ประเภทสินค้า" value="<?php echo $s_productTypeName;?>">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-2">
                                    <div class="icon-and-text-button-demo">
                                     <button  class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                                   </div>
                                  </div>
                              </div> -->

                              

                             <div class="icon-and-text-button-demo align-right">
                                 <button  class="btn btn-primary waves-effect" style="<?php echo chk_role($page_key,'isadd');?>" onClick="addData();"><span>เพิ่มข้อมูล</span><?php echo $img_add;?></button>
                             </div>
                                <div class="table-responsive">
                                    <table id="table1" width="100%" class="table table-bordered table-striped table-hover dataTable">
                                        <thead>
                                            <tr>
                                                <th width="5%">ลำดับ</th>
                                                <th width="20%" style="text-align:center;">รหัสประเภทสินค้า</th>
                                                <th width="60%" style="text-align:center;">ประเภทสินค้า</th>
                                          <!--       <th width="15%" style="text-align:left">อักษรประเภทสินค้า</th> -->
                                              <!--   <th style="text-align:left">รายละเอียด</th> -->
                                                <th width="15%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          if($nums>0){
                                              $i=0;
                                              while ($rec = $db->db_fetch_array($query)) {
                                                $i++;
                                                $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect"  onClick="editData('.$rec['productTypeID'].');">'.$img_edit.'</a>';
                                                if($rec['productTypeID']!=1){
                                                  $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect"  onClick="delData('.$rec['productTypeID'].');">'.$img_del.'</a>';
                                                }else{
                                                 $del = '';
                                               }
                                              
                                            //  $info = ' <a class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['userID'].');">'.$img_info.'</a>';  //  data-toggle="modal" data-target="#largeModal" id="btn_info" data-toggle="tooltip" data-placement="top" title="ข้อมูล"
                                          ?>
                                              <tr>
                                                  <td style="text-align: center;"><?php echo $i+$goto;?></td>
                                                  <td><?php echo $rec['productTypeNameShort'];?></td>
                                           <!--        <td><?php echo $rec['productTypeCode'];?></td> -->
                                                  <td><?php echo $rec['productTypeName'];?></td>
                                                  <!-- <td><?php echo $rec['productTypeNameShort'];?></td> -->
                                                  <!-- <td><?php echo $rec['productTypeDetail'];?></td> -->
                                                  <td style="text-align: center;"><?php echo $edit.$del;?></td>
                                              </tr>
                                          <?php }
                                          }else{
                                              echo '<tr><td colspan="5">ไม่พบข้อมูล</td></tr>';
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
        </div>
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
  $("#frm-search").submit();
}

function addData(){
  $("#proc").val("add");
  $("#frm-search").attr("action","ProductTypeInfo.php").submit();
}
function editData(id){
  $("#proc").val("edit");
  $("#productTypeID").val(id);
  $("#frm-search").attr("action","ProductTypeInfo.php").submit();
}

function delData(id){
  debugger
  var productTypeID = id;
  if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
    $.ajaxSetup({async: false});
    $.post('process/get_process.php',{proc:'chkDelData_ProductType',productTypeID:productTypeID},function(data){
      if(data > 1){
        alert('ไม่สามารถลบข้อมูลได้');
        return false;
      }else{
        $("#proc").val("delete");
        $("#productTypeID").val(productTypeID);
        $("#frm-search").attr("action","process/ProductType_process.php").submit();      
      }
    },'json');

  }
}

</script>
