<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_1';

$filter = '';

if($ddl_search == 1){
  if($s_billNo != ""){
    $filter .= " and attrName  like '%".$s_billNo."%'";
  }
}else if($ddl_search == 3){
  if($status != ""){
   $filter .= " and isEnabled = '".$status."'";
 }
}

$field = "* ";
$table = "tb_attribute";
$pk_id = "attrID";
$wh = "1=1  {$filter}";
// $orderby = "order by ".$table.".productTypeID ASC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table."
where ".$wh; //." ".$orderby; .$limit;
//join tb_producttype on tb_producttype.productTypeID = ".$table.".productTypeID


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
            <h2>คุณลักษณะสินค้า</h2>
          </div>
          <div class="body">
            <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
              <input type="hidden" id="proc" name="proc" value="">
              <input type="hidden" id="form_page" name="form_page" value="AttributeList.php">
              <input type="hidden" id="attrID" name="attrID" value="">
              <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
              <input type="hidden" id="page" name="page" value="<?php echo $page;?>">

              <div class="row clearfix">
                <div class="col-sm-5">
                  <div class="form-group">
                    <div class="form-group form-float">
                      <select name="ddl_search" id="ddl_search" class="form-control show-tick" data-live-search="true"  >
                        <option value=""<?php echo ($ddl_search=="")?"selected":"";?>>แสดงข้อมูลทั้งหมด</option>
                        <option value="1"<?php echo ($ddl_search==1)?"selected":"";?>>ชื่อคุณลักษณะสินค้า</option>
                        <option value="2"<?php echo ($ddl_search==2)?"selected":"";?>>สถานะ</option>
                      </select>
                    </div>
                  </div>                     
                </div>
                <div class="col-sm-5" id="name" style="display: none;">
                  <div class="form-group">
                    <div class="form-line">
                      <input type="text " name="s_billNo" id="s_billNo" class="form-control" placeholder="ชื่อคุณลักษณะสินค้า" value="<?php echo $s_billNo;?>">
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
              </div>

              <div class="icon-and-text-button-demo align-right">
               <button  class="btn btn-primary waves-effect" style="<?php echo chk_role($page_key,'isadd');?>" onClick="addData();"><span>เพิ่มข้อมูล</span><?php echo $img_add;?></button>
             </div>
             <div class="table-responsive">
              <table id="table1" width="100%" class="table table-bordered table-striped table-hover dataTable">
                <thead>
                  <tr>
                    <th width="5%">ลำดับ</th>
                    <th width="35%" style="text-align:center;">ชื่อคุณลักษณะ</th>
                    <th width="10%" style="text-align:center;">สถานะ</th>
                    <th width="10%"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if($nums>0){
                    $i=0;
                    while ($rec = $db->db_fetch_array($query)) {
                      $i++;
                      $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect"  onClick="editData('.$rec['attrID'].');">'.$img_edit.'</a>';
                      // $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect"  onClick="delData('.$rec['attrID'].');">'.$img_del.'</a>';
                              //  $info = ' <a class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['userID'].');">'.$img_info.'</a>';  //  data-toggle="modal" data-target="#largeModal" id="btn_info" data-toggle="tooltip" data-placement="top" title="ข้อมูล"
                      ?>
                      <tr>
                        <td style="text-align: center;"><?php echo $i+$goto;?></td>
                        <td><?php echo $rec['attrName'];?></td>
                        <td><?php echo $arr_active[$rec['isEnabled']];?></td>
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
   if($("#ddl_search").val() == 1 ){
    $('#name').show();
  }else if($("#ddl_search").val() == 2){
   $('#status').show();
 }
});


  function searchData(){
    $("#frm-search").submit();
  }

  function addData(){
    $("#proc").val("add");
    $("#frm-search").attr("action","AttributeInfo.php").submit();
  }
  function editData(id){
    $("#proc").val("edit");
    $("#attrID").val(id);
    $("#frm-search").attr("action","AttributeInfo.php").submit();
  }
  function delData(id){
    var attrID = id;
    if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
      $.ajaxSetup({async: false});
      $.post('process/get_process.php',{proc:'chkDelData_Attribute',attrID:attrID},function(data){
      //alert(data);
      if(data > 0){
        alert('ไม่สามารถลบข้อมูลได้ เนื่องจากคุณลักษณะสินค้านี้มีการใช้ข้อมูลนี้อยู่');
        return false;
      }else{
        $("#proc").val("delete");
        $("#attrID").val(id);
        $("#frm-search").attr("action","process/attr_process.php").submit();
      }
    },'json');

    }
  }

  $("#ddl_search").change(function() {
    $('#name').hide();
    $('#status').hide();
    if($(this).val() == 1){
      $('#name').show();
    }else if($(this).val() == 2){
     $('#status').show();
   }
 });

</script>
