<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$path_image = $path."file_productImg/";
$page_key ='1';
$filter = '';


if($typeID != ""){
  $filter .= " and productTypeID ='".$typeID."'";
}
if($brandID != ""){
 $filter .= " and brandID ='".$brandID."'";
}
if($attrID != ""){
 $filter .= " and attrID ='".$attrID."'";
}
if($txt_value != ""){
  $filter .= " and value like '%".$txt_value."%'";
}

$field = "* ";
$table = "tb_product
join tb_productattr on tb_product.productID = tb_productattr.productID";
$pk_id = "productID";
$wh = " where 1 {$filter}";
$limit =" LIMIT ".$goto ." , ".$page_size ;
$group =" group by tb_productattr.productID";
$sql = "select ".$field." from ".$table .$wh.$group;

if ($chk != 0) {
  $query = $db->query($sql);
  $nums = $db->db_num_rows($query);
  $total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));
}

?>

<body class="theme-red">
  <?php include 'MasterPage.php';?>

  <section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2>ค้นหาสินค้า</h2>
            </div>
            <form id="frm-search" method="POST">
              <div class="body">
                <input type="hidden" id="chk" name="chk" value="0">
                <!-- <?php echo isset($btn_search); ?> -->
                <div class="row clearfix">               
                  <div class="col-lg-1 form-control-label">
                    <label for="email_address_2">ประเภท</label>
                  </div>                 
                  <div class="col-lg-4" id="type">
                    <div class="form-group">
                      <div class="form-group form-float">
                        <select name="typeID" id="typeID" class="form-control show-tick" data-live-search="true"  >
                          <option value="">เลือก</option>
                          <?php
                          $s_p=" SELECT * from tb_producttype where isEnabled = 1";
                          $q_p = $db->query($s_p);
                          $n_p = $db->db_num_rows($q_p);
                          while($r_p = $db->db_fetch_array($q_p)){?>
                            <option value="<?php echo $r_p['productTypeID'];?>"<?php echo ($typeID==$r_p['productTypeID'])?"selected":"";?>> <?php echo $r_p['productTypeName'];?></option>

                          <?php }  ?>
                        </select>
                      </div>
                    </div>                     
                  </div>
                  <div class="col-lg-2 form-control-label">
                    <label for="email_address_2">ยี่ห้อ</label>
                  </div>
                  <div class="col-lg-4" id="brand">
                    <div class="form-group">
                      <div class="form-group form-float">
                        <select name="brandID" id="brandID" class="form-control show-tick" data-live-search="true"  >
                          <option value="">เลือก</option>
                          <?php
                          $s_p=" SELECT * from tb_brand where isEnabled = 1";
                          $q_p = $db->query($s_p);
                          $n_p = $db->db_num_rows($q_p);
                          while($r_p = $db->db_fetch_array($q_p)){?>
                            <option value="<?php echo $r_p['brandID'];?>"<?php echo ($brandID==$r_p['brandID'])?"selected":"";?>> <?php echo $r_p['brandName'];?></option>

                          <?php }  ?>
                        </select>
                      </div>
                    </div>                     
                  </div> 
                </div>
                <div class="row clearfix">
                  <div class="col-lg-1 form-control-label">
                    <label for="email_address_2">คุณลักษณะ</label>
                  </div>
                  <div class="col-lg-4" id="brand">
                    <div class="form-group">
                      <div class="form-group form-float">
                        <select name="attrID" id="attrID" onchange="get_value(this.value,'txt_value',);" class="form-control show-tick" data-live-search="true"  >
                          <option value="">เลือก</option>
                          <?php
                          $s_p=" SELECT * from tb_attribute
                          join tb_productattr on tb_attribute.attrID = tb_productattr.attrID
                          where isEnabled = 1";
                          $q_p = $db->query($s_p);
                          $n_p = $db->db_num_rows($q_p);
                          while($r_p = $db->db_fetch_array($q_p)){?>
                            <option value="<?php echo $r_p['attrID'];?>"<?php echo ($attrID==$r_p['attrID'])?"selected":"";?>> <?php echo $r_p['attrName'];?></option>

                          <?php }  ?>
                        </select>
                      </div>
                    </div>                     
                  </div>
                  <div class="col-lg-2 form-control-label">
                    <label for="email_address_2">รายละเอียด</label>
                  </div>
                  <div class="col-lg-4" id="brand">
                    <div class="form-group">
                      <div class="form-group form-float">
                        <select name="txt_value" id="txt_value" class="form-control show-tick" data-live-search="true"  >
                          <option value="">เลือก</option>
                          <?php
                          $s_p=" SELECT value as DATA_VALUE ,value as DATA_NAME from tb_productattr
                          where attrID ='".$attrID."' group by value order by value asc";
                          $q_p = $db->query($s_p);
                          $n_p = $db->db_num_rows($q_p);
                          while($r_p = $db->db_fetch_array($q_p)){?>
                            <option value="<?php echo $r_p['DATA_VALUE'];?>"<?php echo ($txt_value==$r_p['DATA_VALUE'])?"selected":"";?>> <?php echo $r_p['DATA_NAME'];?></option>

                          <?php }  ?>
                        </select>
                        <label id="value-error" class="error" for="txt_value">กรุณาระบุ</label>
                      </div>
                    </div>                     
                  </div> 
                </div>
                <div class="icon-and-text-button-demo align-center">
                  <button type="button" class="btn btn-success waves-effect" id="btn_search" onClick="searchData();"><span>ค้นหา</span><?php echo $img_view;?></button>
                </div>

                <div class="table-responsive">
                  <table id="tb_data" class="table table-hover">
                    <thead>
                      <tr>
                        <th>ลำดับ</th>
                        <th>รหัสสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>ประเภทสินค้า</th>
                        <th>ยี่ห้อสินค้า</th>
                        <th>ประเภทตำแหน่งจัดเก็บ</th>
                        <th>ตำแหน่งจัดเก็บ</th>
                        <th><?php echo get_attr_name($attrID);?></th>
                        <th>จำนวน</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($nums>0){
                        $i=0;
                        while ($rec = $db->db_fetch_array($query)) { 
                          $i++;
                          ?>
                          <tr>
                            <td style="text-align: center;"><?php echo $i;?></td>
                            <td style="text-align: center;"><?php echo $rec['productCode'];?></td>
                            <td style="text-align: center;"><?php echo $rec['productName'];?></td>
                            <td style="text-align: center;"><?php echo get_productType_name($rec['productTypeID']);?></td>
                            <td style="text-align: center;"><?php echo get_brand_name($rec['brandID']);?></td>
                            <td style="text-align: center;"><?php echo get_locationType_name($rec['locationTypeID']);?></td>
                            <td style="text-align: center;"><?php echo get_location_name($rec['locationID']);?></td>
                            <td style="text-align: center;"><?php echo $txt_value;?></td>
                            <td style="text-align: center;"><span class="badge bg-green"><?php echo number_format($rec['ps_unit']).' '.$arr_unitType[$rec['unitType']];?></span></td>
                          </tr>
                        <?php }
                      }else{
                        echo '<tr><td align="center" colspan="9">ไม่พบข้อมูล</td></tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
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
    $('.error').hide();
    //$('#tb_data').hide();
  });
  function searchData(){
    
    if ($('#attrID').val() != "") {
      if ($('#txt_value').val() == "") {
        $('#value-error').show();
        return false;
      }
    }
    $('#chk').val(1);
    $("#frm-search").submit();
    //$('#tb_data').show();
  }

  function get_value(parent_id,id){
    
    var html  = '<option value="">เลือก</option>';
    $.ajaxSetup({async: false});  
    $.post('process/get_process.php',{proc:'get_value',parent_id:parent_id},function(data){

      $.each(data,function(index,value){
        html += "<option value='"+value['DATA_VALUE']+"'>"+value['DATA_NAME']+"</option>";
      });
      $('#'+id).html(html);
      $('#'+id).selectpicker('refresh');

    },'json');
  }
</script>
