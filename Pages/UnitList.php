<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_3';

$field = "* ";
$table = "tb_unit";
$pk_id = "unitID";
//$wh = "1=1   {$filter}";
$orderby = "order by unitID ASC";
//$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." ".$orderby;

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
//$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

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
            <h2>รายการหน่วยสินค้า</h2>
          </div>
          <div class="body">
            <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
              <input type="hidden" id="proc" name="proc" value="">
              <input type="hidden" id="form_page" name="form_page" value="UnitList.php">
              <input type="hidden" id="unitID" name="unitID" value="">
              <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
              <input type="hidden" id="page" name="page" value="<?php echo $page;?>">
              <div class="icon-and-text-button-demo align-right">
               <button  class="btn btn-primary waves-effect" style="<?php echo chk_role($page_key,'isadd');?>" onClick="addData();"><span>เพิ่มข้อมูล</span><?php echo $img_add;?></button>
             </div>
             <div class="table-responsive">
              <table width="100%" id="table1" class="table table-bordered table-striped table-hover dataTable">
                <thead>
                  <tr>
                    <th width="5%">ลำดับ</th>
                    <th width="20%">รหัสหน่วยสินค้า</th>
                    <th width="60%">ชื่อหน่วยสินค้า</th>
                    <th width="5%">สถานะ</th>
                    <!--       <th width="15%" style="text-align:left">อักษรประเภทสินค้า</th> -->
                    <!--   <th style="text-align:left">รายละเอียด</th> -->
                    <th width="10%"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if($nums>0){
                    $i=0;
                    while ($rec = $db->db_fetch_array($query)) {
                      $i++;
                      $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect"  onClick="editData('.$rec['unitID'].');">'.$img_edit.'</a>';
                                                // if($rec['UnitID']!=1){
                                                  // $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect"  onClick="delData('.$rec['UnitID'].');">'.$img_del.'</a>';
                                               //  }else{
                                               //   $del = '';
                                               // }

                                            //  $info = ' <a class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['userID'].');">'.$img_info.'</a>';  //  data-toggle="modal" data-target="#largeModal" id="btn_info" data-toggle="tooltip" data-placement="top" title="ข้อมูล"
                      ?>
                      <tr>
                        <td><?php echo $i+$goto;?></td>
                        <td style="text-align: left;"><?php echo $rec['unitCode'];?></td>
                        <td style="text-align: left;"><?php echo $rec['unitName'];?></td>
                        <td><?php 
                        if ($rec['isEnabled'] == 1) { ?>
                          <i class="material-icons" style="color: green">check_circle</i>
                        <?php } else{ ?>                                 
                          <i class="material-icons" style="color: red">remove_circle</i>
                        <?php } ?>
                      </td>
                      <td style="text-align: center;"><?php echo $edit.$del;?></td>
                    </tr>
                  <?php }
                } ?>
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
  $(document).ready(function() {
   $("#table1").DataTable({
     "ordering": false,
   })
   if($('#ddl_search').val() == 1){
     $('#UnitName').show();
   }else if($('#ddl_search').val() == 2){
     $('#status').show();
   }
 });

  function searchData(){
    $("#frm-search").submit();
  }

  function addData(){
    $("#proc").val("add");
    $("#frm-search").attr("action","UnitInfo.php").submit();
  }
  function editData(id){
    $("#proc").val("edit");
    $("#unitID").val(id);
    $("#frm-search").attr("action","UnitInfo.php").submit();
  }

  function delData(id){
    var UnitID = id;
    if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
      $.ajaxSetup({async: false});
      $.post('process/get_process.php',{proc:'chkDelData_Unit',UnitID:UnitID},function(data){
      //alert(data);
      if(data > 0){
        alert('ไม่สามารถลบข้อมูลได้ เนื่องจากประเภทสินค้านี้มีการใช้ข้อมูลนี้อยู่');
        return false;
      }else{
        $("#proc").val("delete");
        $("#unitID").val(unitID);
        $("#frm-search").attr("action","process/Unit_process.php").submit();      
      }
    },'json');

    }
  }
  $("#ddl_search").change(function() {
    $('#UnitName').hide();
    $('#status').hide();
    if($(this).val() == 1){
     $('#UnitName').show();
   }else if($(this).val() == 2){
     $('#status').show();
   }
 });
</script>
