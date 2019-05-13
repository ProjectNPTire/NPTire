<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_3';
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
$orderby = "order by ".$table.".productTypeID ASC";
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
            <h2>รายการตำแหน่งจัดเก็บ</h2>
          </div>
          <div class="body">
            <form id="frm-search" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <input type="hidden" id="proc" name="proc" value="">
              <input type="hidden" id="form_page" name="form_page" value="LocationList.php">
              <input type="hidden" id="locationID" name="locationID" value="">
              <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
              <input type="hidden" id="page" name="page" value="<?php echo $page;?>">
                             <!--    <div class="row clearfix">
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
                                </div> -->



                                <div class="icon-and-text-button-demo align-right">
                                  <button type="button" style="<?php echo chk_role($page_key,'isadd');?>" class="btn btn-primary waves-effect" onClick="addData();"><span>เพิ่มข้อมูล</span><i class="material-icons">add</i></button>
                                </div>
                                <div>
                                  <table id="table1" class="table table-bordered table-striped table-hover dataTable"> <!--js-basic-example-->
                                    <thead>
                                      <tr>
                                        <th width="5%">ลำดับ</th>
                                        <th width="10%" style="text-align:center;">รหัสตำแหน่งจัดเก็บ</th>
                                        <th width="15%" style="text-align:center;">ตำแหน่งจัดเก็บ</th>
                                        <th width="10%" style="text-align:center;">ประเภทตำแหน่งจัดเก็บ</th>
                                        <th width="10%" style="text-align:center;">ประเภทสินค้า</th>
                                        <th width="10%" style="text-align:center;">ยี่ห้อสินค้า</th>
                                         <!--  <th width="5%" style="text-align:center;">ฐาน</th>
                                          <th width="5%" style="text-align:center;">สูง</th> -->
                                          <th width="10%" style="text-align:center;">จำนวนจัดเก็บ</th>
                                          <th width="10%" style="text-align:center;">จำนวนที่จัดเก็บได้</th>
                                          <th width="10%" style="text-align:center;">สถานะ</th>
                                          <!-- <th width="5%" style="text-align:center;">ว่าง</th> -->
                                          <!--       <th width="15%" style="text-align:left">อักษรประเภทสินค้า</th> -->
                                          <!--   <th style="text-align:left">รายละเอียด</th> -->
                                          <th width="8%"></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php
                                        if($nums>0){
                                          $i=0;
                                          while ($rec = $db->db_fetch_array($query)) {
                                            $sqllocation = "select SUM(ps_unit) as total
                                            from tb_productstore a
                                            join tb_location b on a.locationID = b.locationID
                                            where a.locationID = '".$rec['locationID']."'
                                            GROUP BY a.locationID";
                                            $querylocation = $db->query($sqllocation);
                                            $numslocation = $db->db_num_rows($querylocation);
                                            $reclocation = $db->db_fetch_array($querylocation);

                                            $i++;
                                            $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect" onClick="editData('.$rec['locationID'].');">'.$img_edit.'</a>';
                                            // $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect" onClick="delData('.$rec['locationID'].');">'.$img_del.'</a>';
                                            $productTypeName = get_productType_name($rec['productTypeID']) != null ? get_productType_name($rec['productTypeID']) : '-';
                                            $brandName = get_brand_name($rec['brandID']) != null ? get_brand_name($rec['brandID']) : '-';
                                            $total = $rec['width']*$rec['high'];
                                            ?>
                                            <tr>
                                              <td align="center"><?php echo $i;?></td>
                                              <td><?php echo $rec['locationCode'];?></td> 
                                              <td><?php echo $rec['locationName'];?></td>
                                              <td><?php echo $arr_locationType[$rec['locationTypeID']];?></td>
                                              <td><?php echo $productTypeName;?></td>
                                              <td><?php echo $brandName;?></td>
                                              <td style="text-align:right;"><?php echo $total;?></td>
                                              <td style="text-align:right;"><?php echo $reclocation['total'] != null ? $total-$reclocation['total'] : $total;?></td>
                                              <td><?php echo $arr_active[$rec['isEnabled']];?></td>
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
                  $(document).ready(function() {
                   $("#table1").DataTable({
                     "ordering": false,
                   })
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
        $("#frm-search").attr("action","process/location_process.php").submit();
      }
    },'json');

    }
  }

</script>
