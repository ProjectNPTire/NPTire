<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_2';

$filter = '';
if($s_brandName){
 $filter .= " and brandName like '%".$s_brandName."%'";
}

$field = "* ";
$table = "tb_brand";
$pk_id = "brandID";
$wh = "1=1  {$filter}";
$orderby = "order by ".$table.".productTypeID ASC";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$sql = "select ".$field." from ".$table."
where ".$wh ." ".$orderby; //.$limit;
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
            <h2>ยี่ห้อสินค้า</h2>
          </div>
          <div class="body">
            <form id="frm-search" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
              <input type="hidden" id="proc" name="proc" value="">
              <input type="hidden" id="form_page" name="form_page" value="BrandList.php">
              <input type="hidden" id="brandID" name="brandID" value="">
              <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size;?>">
              <input type="hidden" id="page" name="page" value="<?php echo $page;?>">
                         <!--      <div class="row clearfix">
                                  <div class="col-sm-10">
                                      <div class="form-group">
                                        <b>ยี่ห้อสินค้า </b>
                                          <div class="form-line">
                                              <input type="text " name="s_brandName" id="s_brandName" class="form-control" placeholder="ยี่ห้อสินค้า" value="<?php echo $s_brandName;?>">
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
                                  <th width="10%" style="text-align:center;">รหัสยี่ห้อสินค้า</th>
                                  <th width="35%" style="text-align:center;">ยี่ห้อสินค้า</th>
                                  <th width="20%" style="text-align:center;">ประเภทสินค้า</th>
                                  <th width="10%" style="text-align:center;">สถานะ</th>
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
                                    $edit = ' <a style="'.chk_role($page_key,'isEdit').'" class="btn bg-orange btn-xs waves-effect"  onClick="editData('.$rec['brandID'].');">'.$img_edit.'</a>';
                                    // $del = ' <a style="'.chk_role($page_key,'isDel').'" class="btn bg-red btn-xs waves-effect"  onClick="delData('.$rec['brandID'].');">'.$img_del.'</a>';
                                            //  $info = ' <a class="btn btn-info btn-xs waves-effect" onClick="infoData('.$rec['userID'].');">'.$img_info.'</a>';  //  data-toggle="modal" data-target="#largeModal" id="btn_info" data-toggle="tooltip" data-placement="top" title="ข้อมูล"
                                    ?>
                                    <tr>
                                      <td style="text-align: center;"><?php echo $i+$goto;?></td>
                                      <td><?php echo $rec['brandName_short'];?></td>
                                      <td><?php echo $rec['brandName'];?></td>
                                      <td><?php echo get_productType_name($rec['productTypeID']);?></td>
                                      <td><?php echo $arr_active[$rec['isEnabled']];?></td>
                                      <!--           <td><?php echo $rec['brandDetail'];?></td> -->
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
            $("#frm-search").attr("action","BrandInfo.php").submit();
          }
          function editData(id){
            $("#proc").val("edit");
            $("#brandID").val(id);
            $("#frm-search").attr("action","BrandInfo.php").submit();
          }
          function delData(id){
            var brandID = id;
            if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
              $.ajaxSetup({async: false});
              $.post('process/get_process.php',{proc:'chkDelData_Brand',brandID:brandID},function(data){
      //alert(data);
      if(data > 0){
        alert('ไม่สามารถลบข้อมูลได้ เนื่องจากยี่ห้อสินค้านี้มีการใช้ข้อมูลนี้อยู่');
        return false;
      }else{
        $("#proc").val("delete");
        $("#brandID").val(id);
        $("#frm-search").attr("action","process/brand_process.php").submit();
      }
    },'json');

            }
          }

        </script>
