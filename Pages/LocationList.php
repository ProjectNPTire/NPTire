<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='2_4';
/*$sql     = " SELECT *
            FROM tb_location
            ";*/

/*$query = $db->query($sql);
$nums = $db->db_num_rows($query);*/

$filter = '';
if($s_location_name){
   $filter .= " and locationName like '%".$s_location_name."%'";
}

$field = "* ";
$table = "tb_location";
$pk_id = "locationID";
$wh = "1=1  {$filter}";
$orderby = "order by locationID DESC";
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
                            <h2>รายการตำแหน่งจัดเก็บ</h2>
                        </div>
                        <div class="body">
                            <form id="frm-search" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" id="proc" name="proc" value="">
                                <input type="hidden" id="form_page" name="form_page" value="LocationList.php">
                                <input type="hidden" id="locationID" name="locationID" value="">
                                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
                                <input type="hidden" id="page" name="page" value="<?php echo $page;?>">

                                <div class="row clearfix">
                                  <div class="col-sm-10">
                                    <div class="form-group">
                                      <b>ชื่อตำแหน่งจัดเก็บสินค้า </b>
                                      <div class="form-line">
                                        <input type="text " name="s_location_name" id="s_location_name" class="form-control" placeholder="ชื่อตำแหน่งจัดเก็บสินค้า" value="<?php echo $s_location_name;?>">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-2">
                                    <div class="icon-and-text-button-demo">
                                      <button type="button" class="btn btn-success waves-effect" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                                    </div>
                                  </div>
                                </div>

                                 

                                <div class="icon-and-text-button-demo align-right">
                                    <button type="button" style="<?php echo chk_role($page_key,'isadd');?>" class="btn btn-primary waves-effect" onClick="addData();"><span>เพิ่มข้อมูล</span><i class="material-icons">add</i></button>
                                </div>
                                <div>
                                  <table class="table table-bordered table-striped table-hover dataTable"> <!--js-basic-example-->
                                      <thead>
                                          <tr>
                                              <th><div align="center">ลำดับ</div></th>
                                              <th><div align="center">ชื่อตำแหน่งจัดเก็บ</div></th>
                                              <th><div align="center">รายละเอียด</div></th>
                                              <th><div align="center">จัดการ</div></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                          if($nums>0){
                                              $i=0;
                                              while ($rec = $db->db_fetch_array($query)) {
                                              $i++;
                                              $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect" onClick="editData('.$rec['locationID'].');">'.$img_edit.'</a>';
                                              $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect" onClick="delData('.$rec['locationID'].');">'.$img_del.'</a>';
                                          ?>
                                              <tr>
                                                  <td align="center"><?php echo $i;?></td>
                                                  <td><?php echo $rec['locationName'];?></td>
                                                  <td><?php echo $rec['locationDetail'];?></td> 
                                                  <td align="center"><?php echo $edit.$del;?></td>
                                              </tr>
                                          <?php }
                                          }else{
                                              echo '<tr><td align="center" colspan="3">ไม่พบข้อมูล</td></tr>';
                                          }
                                          ?>
                                      </tbody>
                                  </table>
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

function searchData(){
    //alert("1234");
    $("#frm-search").submit();
}

function addData(){
  $("#proc").val("add");
  $("#frm-search").attr("action","LocationInfo.php").submit();
}
function editData(id){
  $("#proc").val("edit");
  $("#locationID").val(id);
  $("#frm-search").attr("action","LocationInfo.php").submit();
}
function delData(id){
  if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
    $("#proc").val("delete");
    $("#locationID").val(id);
    $("#frm-search").attr("action","process/location_process.php").submit();
  }
}

</script>
