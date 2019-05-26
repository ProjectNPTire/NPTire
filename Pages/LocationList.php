<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_5';
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
    $filter .= " and locationName  like '%".$s_billNo."%'";
  }
}else if($ddl_search == 2){
  if($type != ""){
   $filter .= " and locationTypeID ='".$type."'";
 }
}else if($ddl_search == 3){
  if($status != ""){
   $filter .= " and isEnabled = '".$status."'";
 }
}

$field = "  tb_location.locationID,locationCode,locationName,locationTypeName,tb_location.isEnabled,productName,locationType";
$table = "tb_location";
$pk_id = "locationID";
$join = " JOIN tb_locationtype on tb_location.locationTypeID = tb_locationtype.locationTypeID
LEFT JOIN tb_productstore on tb_location.locationID = tb_productstore.locationID
LEFT JOIN tb_product on tb_product.productID = tb_productstore.productID";
$wh = "1=1  {$filter}";
$groupby = " GROUP by tb_location.locationID";
$orderby = " order by tb_location.locationID ASC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table.$join." where ".$wh .$groupby.$orderby; //.$limit;
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
              <input type="hidden" id="form_page" name="form_page" value="LocationList.php">
              <input type="hidden" id="locationID" name="locationID" value="">
              <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
              <input type="hidden" id="page" name="page" value="<?php echo $page;?>">
<!--              <?php echo $sql; ?>
-->
<div class="row clearfix">
  <div class="col-sm-5">
    <div class="form-group">
      <div class="form-group form-float">
        <select name="ddl_search" id="ddl_search" class="form-control show-tick" data-live-search="true"  >
          <option value=""<?php echo ($ddl_search=="")?"selected":"";?>>แสดงข้อมูลทั้งหมด</option>
          <option value="1"<?php echo ($ddl_search==1)?"selected":"";?>>ชื่อตำแหน่ง</option>
          <option value="2"<?php echo ($ddl_search==2)?"selected":"";?>>ประเภทตำแหน่ง</option>
          <option value="3"<?php echo ($ddl_search==5)?"selected":"";?>>สถานะ</option>
        </select>
      </div>
    </div>                     
  </div>
  <div class="col-sm-5" id="name" style="display: none;">
    <div class="form-group">
      <div class="form-line">
        <input type="text " name="s_name" id="s_name" class="form-control" placeholder="ชื่อตำแหน่ง" value="<?php echo $s_name;?>">
      </div>
    </div>
  </div>
  <div class="col-sm-5" id="status" style="display: none;">
    <div class="form-group">
      <div class="form-group form-float">
        <select name="s_status" id="s_status" class="form-control show-tick" data-live-search="true"  >
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
  <div class="col-sm-5" id="type" style="display: none;">
    <div class="form-group">
      <div class="form-group form-float">
        <select name="s_locationType" id="s_locationType" class="form-control show-tick" data-live-search="true"  >
          <option value="">เลือก</option>
          <?php
          $s_p=" SELECT * from tb_locationtype where isEnabled = 1";
          $q_p = $db->query($s_p);
          $n_p = $db->db_num_rows($q_p);
          while($r_p = $db->db_fetch_array($q_p)){?>
            <option value="<?php echo $r_p['locationTypeID'];?>"<?php echo ($s_locationType==$r_p['locationTypeID'])?"selected":"";?>> <?php echo $r_p['locationTypeName'];?></option>
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
        <th width="10%" style="text-align:center;">รหัสตำแหน่งจัดเก็บ</th>
        <th width="15%" style="text-align:center;">ชื่อตำแหน่งจัดเก็บ</th>
        <th width="10%" style="text-align:center;">ชื่อประเภทตำแหน่งจัดเก็บ</th>
        <th width="10%" style="text-align:center;">สินค้า</th>
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
          $status='';
          $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect" onClick="editData('.$rec['locationID'].');">'.$img_edit.'</a>';
                        // $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect" onClick="delData('.$rec['locationID'].');">'.$img_del.'</a>';
          if ($rec['locationType'] != 3) {
            if($rec['productName'] != ''){
              $status = $rec['productName'];
            }
          }

          ?>
          <tr>
            <td align="center"><?php echo $i;?></td>
            <td><?php echo $rec['locationCode'];?></td> 
            <td><?php echo $rec['locationName'];?></td>
            <td><?php echo $rec['locationTypeName'];?></td>
            <td><?php echo $status;?></td>
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
   $('#type').show();
 }else if($("#ddl_search").val() == 3){
   $('#status').show();
 }
});
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
    $('#status').hide();
    if($(this).val() == 1){
      $('#name').show();
    }else if($(this).val() == 2){
     $('#type').show();
   }else if($(this).val() == 3){
     $('#status').show();
   }
 });

</script>
