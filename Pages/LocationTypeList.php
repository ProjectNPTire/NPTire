<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_4';
/*$sql     = " SELECT *
            FROM tb_location
            ";*/

/*$query = $db->query($sql);
$nums = $db->db_num_rows($query);*/

// $filter = '';
// if($s_location_name){
//  $filter .= " and locationName like '%".$s_location_name."%'";
// }

if($ddl_search == 1){
  if($s_billNo != ""){
    $filter .= " and locationTypeName  like '%".$s_billNo."%'";
  }
}else if($ddl_search == 2){
  if($type != ""){
   $filter .= " and locationType ='".$type."'";
 }
}else if($ddl_search == 6){
  if($status != ""){
   $filter .= " and isEnabled = '".$status."'";
 }
}

$field = "* ";
$table = "tb_locationtype";
$pk_id = "locationTypeID";
$wh = "1=1  {$filter}";
$orderby = "order by locationTypeID ASC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table." 
where ".$wh ." ".$orderby; //.$limit;
// join tb_producttype on tb_producttype.productTypeID = ".$table.".productTypeID
// join tb_brand on tb_brand.brandID = ".$table.".brandID


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
            <h2>รายการประเภทตำแหน่งจัดเก็บ</h2>
          </div>
          <div class="body">
            <form id="frm-search" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <input type="hidden" id="proc" name="proc" value="">
              <input type="hidden" id="form_page" name="form_page" value="LocationTypeList.php">
              <input type="hidden" id="locationTypeID" name="locationTypeID" value="">
              <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
              <input type="hidden" id="page" name="page" value="<?php echo $page;?>">
              

              <div class="row clearfix">
                <div class="col-sm-5">
                  <div class="form-group">
                    <div class="form-group form-float">
                      <select name="ddl_search" id="ddl_search" class="form-control show-tick" data-live-search="true"  >
                        <option value=""<?php echo ($ddl_search=="")?"selected":"";?>>แสดงข้อมูลทั้งหมด</option>
                        <option value="1"<?php echo ($ddl_search==1)?"selected":"";?>>ชื่อตำแหน่ง</option>
                        <option value="2"<?php echo ($ddl_search==2)?"selected":"";?>>ประเภทตำแหน่ง</option>
                        <option value="5"<?php echo ($ddl_search==5)?"selected":"";?>>สถานะ</option>
                      </select>
                    </div>
                  </div>                     
                </div>
                <div class="col-sm-5" id="name" style="display: none;">
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text " name="s_billNo" id="s_billNo" class="form-control" placeholder="ชื่อตำแหน่ง" value="<?php echo $s_billNo;?>">
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
                <div class="col-sm-5" id="typeloc" style="display: none;">
                  <div class="form-group">
                    <div class="form-group form-float">
                      <select name="type" id="s_userID" class="form-control show-tick" data-live-search="true"  >
                        <?php   foreach ($arr_locationType as $key => $value) {?>
                          <option value="<?php echo $key;?>"  <?php echo ($rec['locationTypeID']==$key)?"selected":"";?>> <?php echo $value;?></option>
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
              </div>


              <div class="icon-and-text-button-demo align-right">
                <button type="button" style="<?php echo chk_role($page_key,'isadd');?>" class="btn btn-primary waves-effect" onClick="addData();"><span>เพิ่มข้อมูล</span><i class="material-icons">add</i></button>
              </div>
              <div>
                <table id="table1" class="table table-bordered table-striped table-hover dataTable"> <!--js-basic-example-->
                  <thead>
                    <tr>
                      <th width="5%">ลำดับ</th>
                      <th width="10%" style="text-align:center;">รหัสประเภทตำแหน่งจัดเก็บ</th>
                      <th width="15%" style="text-align:center;">ชื่อประเภทตำแหน่งจัดเก็บ</th>
                      <th width="10%" style="text-align:center;">ประเภทตำแหน่งจัดเก็บ</th>
                      <th width="5%" style="text-align:center;">สถานะ</th>
                      <th width="5%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($nums>0){
                      $i=0;
                      while ($rec = $db->db_fetch_array($query)) {
                        $i++;
                        $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect" onClick="editData('.$rec['locationTypeID'].');">'.$img_edit.'</a>';
                        // $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect" onClick="delData('.$rec['locationID'].');">'.$img_del.'</a>';
                        ?>
                        <tr>
                          <td align="center"><?php echo $i;?></td>
                          <td><?php echo $rec['locationTypeCode'];?></td> 
                          <td><?php echo $rec['locationTypeName'];?></td>
                          <td><?php echo $arr_locationType[$rec['locationType']];?></td>
                          <td><?php echo $arr_active[$rec['isEnabled']];?></td>
                          <td align="center"><?php echo $edit.$del;?></td>
                        </tr>
                      <?php }
                    }else{
                      echo '<tr><td align="center" colspan="6">ไม่พบข้อมูล</td></tr>';
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
  $(document).ready(function() {
   $("#table1").DataTable({
     "ordering": false,
   })
   if($("#ddl_search").val() == 1 ){
    $('#name').show();
  }else if($("#ddl_search").val() == 2){
   $('#typeloc').show();
 }else if($("#ddl_search").val() == 3){
   $('#type').show();
 }else if($("#ddl_search").val() == 4){
   $('#brand').show();
 }else if($("#ddl_search").val() == 5){
   $('#status').show();
 }
});
  function searchData(){
    //alert("1234");
    $("#frm-search").submit();
  }

  function addData(){
    $("#proc").val("add");
    $("#frm-search").attr("action","LocationTypeInfo.php").submit();
  }
  function editData(id){
    $("#proc").val("edit");
    $("#locationTypeID").val(id);
    $("#frm-search").attr("action","LocationTypeInfo.php").submit();
  }
  function delData(id){
    var locationID = id;
    if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
      $.ajaxSetup({async: false});
      $.post('process/get_process.php',{proc:'chkDelData_Location',locationID:locationID},function(data){
      //alert(data);
      if(data > 0){
        alert('ไม่สามารถลบข้อมูลได้ เนื่องจากตำแหน่งนี้มีสินค้าอยู่');
        return false;
      }else{
        $("#proc").val("delete");
        $("#locationID").val(id);
        $("#frm-search").attr("action","process/locationtpye_process.php").submit();
      }
    },'json');

    }
  }

  $("#ddl_search").change(function() {
    $('#name').hide();
    $('#type').hide();
    $('#brand').hide();
    $('#typeloc').hide();
    $('#status').hide();
    if($(this).val() == 1){
      $('#name').show();
    }else if($(this).val() == 2){
     $('#typeloc').show();
   }else if($(this).val() == 3){
     $('#type').show();
   }else if($(this).val() == 4){
     $('#brand').show();
   }else if($(this).val() == 5){
     $('#status').show();
   }
 });

</script>
