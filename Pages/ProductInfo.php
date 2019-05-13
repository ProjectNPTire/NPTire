<!DOCTYPE html>
<html>
<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_4';
$form_page = $form_page;

$path_image = $path."file_productImg/";

$sql     = " SELECT *
FROM tb_product
where productID ='".$productID."' ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$rec = $db->db_fetch_array($query);
$proc = ($proc=='')?"add":$proc;
$txt =  ($proc=='add')?"เพิ่ม":"แก้ไข";
$locationTypeID =  $rec['locationTypeID'];

if ($locationTypeID == 1) {
  $s_location = "SELECT * from tb_location where locationTypeID = '".$locationTypeID."' and brandID = '".$rec["brandID"]."' ";
}else if ($locationTypeID == 2) {
  $s_location = "SELECT * FROM tb_location WHERE locationTypeID = '".$locationTypeID."' and productTypeID = '".$rec["productTypeID"]."' ";
}
$readonly = "readonly";
?>

<body class="theme-red">
  <?php include 'MasterPage.php';?>
  <section class="content">
    <div class="container-fluid">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2><?php echo $txt;?>ข้อมูลสินค้า</h2>
            </div>
            <form id="frm-input" method="post" enctype="multipart/form-data" action="process/Product_process.php" >
              <input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>">
              <input type="hidden" id="productID" name="productID" value="<?php echo $productID;?>">
              <input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page?>">
              <input type="hidden" id="chk" name="chk" value="0">
              <input type="hidden" id="chk1" name="chk1" value="0">
              <input type="hidden" id="chk2" name="chk2" value="0">
              <input type="hidden" id="chk3" name="chk3" value="0">
              <input type="hidden" id="chk4" name="chk4" value="0">
              <input type="hidden" id="chk5" name="chk5" value="0">
              <div class="body">
                <div class="row clearfix">
                  <div class="col-sm-12 align-right"><b><span style="color:red">* กรอกข้อมูลให้ครบทุกช่อง</span></b>
                  </div>
                </div>
                <div class="row clearfix">
                  <div class="col-sm-8">
                    <div class="row">
                      <div class="col-sm-6">
                        <b>รหัสสินค้า</b>
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" readonly name="productCode" id="productCode" class="form-control" placeholder="รหัสสินค้า" value="<?php echo $rec['productCode'];?>">
                          </div>
                          <label id="productCode-error" class="error" for="productName">มีรหัสสินค้านี้แล้ว</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <b>ชื่อสินค้า</b>
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" onkeyup="chkName();" class="form-control " placeholder="ชื่อสินค้า"  name="productName" id="productName"  value="<?php echo $rec['productName'];?>"<?php echo $_SESSION["userType"] == "2" ?"readonly":""?>>
                          </div>
                          <label id="productName-error" class="error" for="productName">กรุณาระบุ ชื่อสินค้า</label>
                          <label id="productName2-error" class="error" for="productName">มีประเภทสินค้านี้แล้ว</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <b>ประเภทตำแหน่งจัดเก็บ</b>
                        <div class="form-group form-float">
                          <select name="locationTypeID" id="locationTypeID" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>                   
                            <option value="">เลือก</option>
                            <?php   foreach ($arr_locationType as $key => $value) {?>
                              <option value="<?php echo $key;?>"  <?php echo ($rec['locationTypeID']==$key)?"selected":"";?>> <?php echo $value;?></option>
                            <?php }  ?>
                          </select>
                          <input type="hidden" name="hdflocationTypeID" id="hdflocationTypeID" value="<?php echo $rec['locationTypeID'] ?>">
                          <label id="locationTypeID-error" class="error" for="locationTypeID">กรุณาเลือก ประเภทตำแหน่งจัดเก็บ</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <b>ประเภทสินค้า</b>
                        <div class="form-group form-float">
                          <select name="productTypeID" id="productTypeID" class="form-control show-tick" data-live-search="true"  onchange="get_code();" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>
                            <option value="">เลือก</option>
                            <?php
                            $s_pdtype=" SELECT * from tb_producttype order by productTypeID asc";
                            $q_pdtype = $db->query($s_pdtype);
                            $n_pdtype = $db->db_num_rows($q_pdtype);
                            while($r_pdtype = $db->db_fetch_array($q_pdtype)){
                              ?>
                              <option value="<?php echo $r_pdtype['productTypeID'];?>" <?php echo ($rec['productTypeID']==$r_pdtype['productTypeID'])?"selected":"";?>> <?php echo $r_pdtype['productTypeName'];?></option>

                            <?php }  ?>
                          </select>
                          <input type="hidden" name="hdfproductTypeID" id="hdfproductTypeID" value="<?php echo $rec['productTypeID'] ?>">
                          <label id="productTypeID-error" class="error" for="productTypeID">กรุณาเลือก ประเภทสินค้า</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <b>ยี่ห้อสินค้า</b>
                        <div class="form-group form-float">
                          <select name="brandID" onchange="get_code2();" id="brandID" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>
                            <option value="">เลือก</option>
                            <?php
                            $s_brand=" SELECT * from tb_brand where productTypeID  ='".$rec['productTypeID']."' order by brandName asc";
                            $q_brand = $db->query($s_brand);
                            $n_brand = $db->db_num_rows($q_brand);
                            while($r_brand = $db->db_fetch_array($q_brand)){
                              ?>
                              <option value="<?php echo $r_brand['brandID'];?>"  <?php echo ($rec['brandID']==$r_brand['brandID'])?"selected":"";?>> <?php echo $r_brand['brandName'];?></option>
                            <?php }  ?>
                          </select>
                          <input type="hidden" name="hdfbrandID" id="hdfbrandID" value="<?php echo $rec['brandID'] ?>">
                          <label id="brandID-error" class="error" for="brandID">กรุณาเลือก ยี่ห้อสินค้า</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <b>ขนาดสินค้า</b>
                        <div class="form-group">
                          <div class="form-line">
                            <input type="text" maxlength="12" class="form-control " placeholder="ขนาด"  name="productSize" id="productSize"  onkeyup="get_code2();"  onblur="get_code2();"  value="<?php echo $rec['productSize'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                          </div>
                          <div class="help-info">กรอกได้ไม่เกิน12ตัวอักษร</div>
                          <label id="productSize-error" class="error" for="productSize">กรุณาระบุ ขนาดสินค้า</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <div class="col-sm-12">
                      <img id="blah" rc="<?php echo $proc == "add" ? '' : $path_image."/".$rec['productImg'];?>" class="img-responsive" />
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-sm-4">
                    <b>รุ่นสินค้า</b>
                    <div class="form-group">
                      <div class="form-line">
                        <input type="text" maxlength="6" class="form-control " placeholder="รุ่น"  name="modelName" id="modelName" onkeyup="get_code2();"  onblur="get_code2();"  value="<?php echo $rec['modelName'];?>" <?php  echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                      </div>
                      <div class="help-info">กรอกได้ไม่เกิน6ตัวอักษร</div>
                      <label id="modelName-error" class="error" for="modelName">กรุณาระบุ รุ่นสินค้า</label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <b>หน่วยนับ</b>
                    <div class="form-group form-float">
                      <select name="unitType" id="unitType" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>
                        <option value="">เลือก</option>
                        <?php   foreach ($arr_unitType as $key => $value) {?>
                          <option value="<?php echo $key;?>"  <?php echo ($rec['unitType']==$key)?"selected":"";?>> <?php echo $value;?></option>

                        <?php }  ?>
                      </select>
                      <input type="hidden" name="hdfunitType" id="hdfunitType" value="<?php echo $rec['unitType'] ?>">
                      <label id="unitType-error" class="error" for="unitType">กรุณาเลือก หน่วยนับ</label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <b>รูปภาพ</b>
                    <div class="form-group">
                      <div class="form-line">
                        <input type="file" class="form-control " name="productImg" id="productImg" accept="image/x-png, image/gif, image/jpeg" value="<?php echo $rec['productImg'];?>" onchange="ValidateSingleInput(this);" >
                        <input type="hidden" name="old_file" id="old_file" value="<?php echo $rec['productImg'];?>" >
                      </div>
                      <div class="help-info">อัพโหลดได้เฉพาะไฟล์JPEG,RAW,PSD,GIF,PNG,TIFF</div>
                      <label id="productImg-error" class="error" for="productImg">กรุณาเลือกรูปภาพ</label>
                    </div>
                  </div>
                </div>
                <!-- <div class="row clearfix">
                   <div class="col-sm-4">
                    <b>บริษัทคู่ค้า</b>
                    <div class="form-group form-float">
                      <select name="supID" id="supID" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2" ? 'disabled' : '';?>>
                        <option value="">เลือก</option>
                        <?php
                        $s_sup=" SELECT * from tb_supplier order by sup_name asc";
                        $q_sup = $db->query($s_sup);
                        $n_sup = $db->db_num_rows($q_sup);
                        while($r_sup = $db->db_fetch_array($q_sup)){
                          ?>
                          <option value="<?php echo $r_sup['supID'];?>"  <?php echo ($rec['supID']==$r_sup['supID'])?"selected":"";?>> <?php echo $r_sup['sup_name'];?></option>

                        <?php }  ?>
                      </select>
                      <input type="hidden" name="hdfsupID" id="hdfsupID" value="<?php echo $rec['supID'] ?>">
                      <label id="supID-error" class="error" for="supID">กรุณาเลือก บริษัทคู่ค้า</label>
                    </div>
                  </div> 
                </div>-->
                <div class="row clearfix">
                  <div class="col-sm-4">
                    <b>จุดสั่งซื้อ </b>
                    <div class="form-group">
                      <div class="form-line">
                        <input type="text " name="orderPoint" maxlength="2" id="orderPoint" class="form-control numb" value="<?php echo number_format($rec['orderPoint']);?>">
                      </div>
                      <div class="help-info">กรอกได้เฉพาะตัวเลขไม่เกิน2ตัวอักษร</div>
                      <label id="orderPoint_error" class="error" for="orderPoint">กรุณาระบุ จุดสั่งซื้อ</label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <b>จำนวนสินค้า </b>
                    <div class="form-group">
                      <div class="form-line">
                        <input type="text " readonly name="productUnit" id="productUnit" class="form-control " placeholder="จำนวนสินค้า" value="<?php echo number_format($rec['productUnit']);?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <b>การใช้งานข้อมูล</b>
                    <div class="form-group form-float">
                      <select name="status" id="status" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?> onchange="delData('status',this.value,'hdfstatus');">
                        <?php asort($arr_active);
                        foreach ($arr_active as $key => $value) {?>
                          <option value="<?php echo $key;?>"  
                            <?php 
                            if(($rec['isEnabled']  != "")){
                              echo ($rec['isEnabled']==$key)?"selected":"";
                            }
                            ?>><?php echo $value;?></option>
                          <?php }  ?>
                        </select>
                        <input type="hidden" name="hdfstatus" id="hdfstatus" value="<?php echo $proc == "edit"  ? $rec['isEnabled'] : '1';?>">
                      </div>
                    </div>
                  </div>

                  <div class="row clearfix">
                    <div class="col-sm-12">
                      <b>รายละเอียด </b>
                      <div class="form-group">
                        <div class="form-line">
                          <textarea  class="form-control" id="productDetail" name="productDetail"><?php echo $rec['productDetail'];?></textarea>
                        </div>
                        <label id="productDetail_error" class="error" for="productDetail">กรุณาระบุ ราบละเอียด</label>
                      </div>
                    </div>
                  </div>
                  <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#home" data-toggle="tab">คู่ค้า</a></li>
                    <li role="presentation"><a href="#profile" data-toggle="tab">ตำแหน่งจัดเก็บ</a></li>
                  </ul>
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                      <?php
                      $total=0; $a=1;
                      $sql_sub  = " SELECT * FROM tb_productsupplier  where productID ='".$productID."' and isDeleted != 1";

                      $query_sub = $db->query($sql_sub);
                      $nums_sub = $db->db_num_rows($query_sub);             
                      ?>
                      <div class="icon-and-text-button-demo align-right">
                        <a  class="btn btn-primary waves-effect" onClick="addRowsup();"><span>เพิ่มบริษัทคู่ค้า</span><?php echo $img_add;?></a>
                      </div>
                      <div class="form-group">
                        <table class="table table-bordered table-striped table-hover  dataTable " id="tb_datasup" >
                          <thead>
                            <tr>
                              <th width="90%">บริษัทคู่ค้า</th>
                              <th width="10%">จัดการ</th>   
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                            if($nums_sub>0){
                             while ($rec_sub = $db->db_fetch_array($query_sub)) {
                              $a++;
                              $del = ' <a class="btn bg-red btn-xs waves-effect"  href="javascript:void(0);" 
                              onClick="delDataTBsup(this,'.$rec_sub['supID'].','.$rec_sub['runID'].','.$a.');">'.$img_del.'</a>';
                              ?>
                              <tr>
                                <td>
                                  <input type="hidden" name="runID[]" id="runID<?php echo $a;?>" value="<?php echo $rec_sub['runID'];?>">
                                  <input type="hidden" name="isDeleted[]" id="isDeleted<?php echo $a;?>" value="0">
                                  <select name="supID[]" id="supID_<?php echo $a;?>" class="form-control show-tick" data-live-search="true" onchange="chk_sup(this,<?php echo $rec_sub['supID'];?>);">
                                    <option value="">เลือก</option>
                                    <?php
                                    $s_sup =" SELECT * from tb_supplier";
                                    $q_sup = $db->query($s_sup);
                                    $n_sup = $db->db_num_rows($q_sup);
                                    while($r_sup = $db->db_fetch_array($q_sup)){ ?>
                                      <option value="<?php echo $r_sup['supID'];?>"  <?php echo ($rec_sub['supID']==$r_sup['supID'])?"selected":"";?>> <?php echo $r_sup['sup_name'];?></option>
                                    <?php } ?>
                                  </select>
                                  <label id="supID<?php echo $a;?>-error" class="error" for="supID_<?php echo $a;?>">บริษัทคู่ค้านี้ถูกใช้แล้ว</label>
                                  <label id="supID<?php echo $a;?>-error2" class="error" for="supID_<?php echo $a;?>">กรุณาเลือกบริษัทคู่ค้า</label>
                                </td>
                                <td style="text-align: center;">
                                  <?php echo $del;?>
                                </td>
                              </tr>
                            <?php   }
                          }else{ ?>
                           <tr id="nodatasup">
                            <td>
                              <select name="supID[]" id="supID_1" class="form-control show-tick" data-live-search="true" onchange="chk_sup(this,0);">
                                <option value="">เลือก</option>
                                <?php
                                $s_sup =" SELECT * from tb_supplier";
                                $q_sup = $db->query($s_sup);
                                $n_sup = $db->db_num_rows($q_sup);
                                while($r_sup = $db->db_fetch_array($q_sup)){ ?>
                                  <option value="<?php echo $r_sup['supID'];?>"> <?php echo $r_sup['sup_name'];?></option>
                                <?php } ?>
                              </select>
                              <label id="supID1-error" class="error" for="supID_1">บริษัทคู่ค้านี้ถูกใช้แล้ว</label>
                              <label id="supID1-error2" class="error" for="supID_1">กรุณาเลือกบริษัทคู่ค้า</label>
                            </td>
                            <td style="text-align: center;">
                              <a class="btn bg-red btn-xs waves-effect"  href="javascript:void(0);" onClick="delDataTBsup(this,0,0,0);"><?php echo $img_del;?> </a>
                            </td>
                          </tr>
                          <!--                           echo '<tr id="nodatasup"><td align="center" colspan="7">ไม่พบข้อมูล</td></tr>'; -->                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="profile">
                    <?php
                    $i=0; $total=0;
                    $sql_location  = " SELECT * FROM tb_productstore  where productID ='".$productID."' and isDeleted != 1";

                    $query_location = $db->query($sql_location);
                    $nums_location = $db->db_num_rows($query_location);
                    if($nums_location>0){
                      ?>
                      <div class="icon-and-text-button-demo align-right">
                        <a  class="btn btn-primary waves-effect" onClick="addRow();"><span>เพิ่มสถานที่จัดเก็บ</span><?php echo $img_add;?></a>
                      </div>
                    <?php } ?>
                    <div class="form-group">
                      <table class="table table-bordered table-striped table-hover  dataTable " id="tb_data" >
                        <thead>
                          <tr>
                            <th width="70%">สถานที่จัดเก็บสินค้า</th>
                            <th width="20%">จำนวน</th>
                            <th width="10%">จัดการ</th> 	
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          if($nums_location>0){
                           while ($rec_location = $db->db_fetch_array($query_location)) {
                            $i++;
                            $del = '<a class="btn bg-red btn-xs waves-effect"  href="javascript:void(0);" onClick="delDataTB(this,'.$rec_location['locationID'].','.$i.');">'.$img_del.'</a>';
                            ?>
                            <tr>
                              <td>
                                <input type="hidden" name="ps_id[]" id="ps_id<?php echo $i;?>" value="<?php echo $rec_location['ps_id'];?>">
                                <input type="hidden" name="isDeleted1[]" id="isDeleted1<?php echo $i;?>" value="0">
                                <select name="locationID[]" id="locationID_<?php echo $i;?>" class="form-control show-tick" data-live-search="true" onchange="chk_location(this.value);">
                                  <option value="">เลือก</option>
                                  <?php
                                  $q_location = $db->query($s_location);
                                  while ($r_location = $db->db_fetch_array($q_location)) {?>
                                    <option value="<?php echo $r_location['locationID'];?>" <?php echo ($r_location['locationID']==$rec_location['locationID'])?"selected":"";?>><?php echo $r_location['locationName'];?></option>
                                  <?php } ?>
                                </select>
                                <label id="locationID<?php echo $i;?>-error" class="error" for="locationID_<?php echo $i;?>">ตำแหน่งนี้ถูกใช้แล้ว</label>
                              </td>
                              <td>
                                <div class="form-line">
                                  <input type="text"  style="text-align: right;" class="form-control numb"   name="ps_unit[]" id="ps_unit_<?php echo $i;?>" onBlur="NumberFormat(this); get_total();" value="<?php echo $rec_location['ps_unit'];?>" >
                                </div>
                              </td>
                              <td style="text-align: center;">
                                <?php echo $del;?>
                              </td>
                            </tr>
                          <?php   }
                        }else{
                          echo '<tr id="nodata"><td align="center" colspan="7">ไม่พบข้อมูล</td></tr>';
                        } ?>
                      </tbody>
                    </table>
                    <label id="tb_data-error" class="error" for="tb_data">จำนวนสินค้าในตำแหน่งจัดเก็บไม่เท่ากับจำนวนสินค้าทั้งหมด</label>
                    <label id="tb_data-error2" class="error" for="tb_data">กรุณาเลือกตำแหน่งจัดเก็บ</label>
                  </div>
                </div>
              </div>
              <input type="hidden" id="total_unit" value="<?php echo $total;?>">
              <input type="hidden" id="rowid" value="<?php echo $i;?>">
              <input type="hidden" id="rowid2" value="<?php echo $a;?>">
              <div class="align-center">
                <button type="button" class="btn btn-success waves-effect" onclick="chkinput();">บันทึก</button>
                <button type="button" class="btn btn-warning waves-effect" onclick="OnCancel();">ยกเลิก</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- #END# Advanced Form Example With Validation -->
    </div>
  </section>
  <?php include 'js.php';?>
</body>

</html>
<script>
  function OnCancel()
  {

    $(location).attr('href',"<?php echo  $form_page?>");
  }

  function chkinput(){

    if($('#chk2').val()==1){
      $('#productName2-error').show();
      $('#productName').focus();
      return false;
    }else{
      $('#productName2-error').hide();
    }

    if($('#productName').val()==''){
      $('#productName-error').show();
      $('#productName').focus();
      return false;
    }else{
      $('#productName-error').hide();
    }

    if($('#locationTypeID').val()==''){
      $('#locationTypeID-error').show();
      $('#locationTypeID').focus();
      return false;
    }else{
      $('#locationTypeID-error').hide();
    }

    if($('#chk2').val()==1){
      $('#productTypeName2-error').show();
      $('#productTypeName').focus();
      return false;
    }else{
      $('#productTypeName2-error').hide();
    }

    if($('#productTypeID').val()==''){
      $('#productTypeID-error').show();
      $('#productTypeID').focus();
      return false;
    }else{
      $('#productTypeID-error').hide();
    }

    if($('#brandID').val()==''){
      $('#brandID-error').show();
      $('#brandID').focus();
      return false;
    }else{
      $('#brandID-error').hide();
    }

    if($('#productSize').val()==''){
      $('#productSize-error').show();
      $('#productSize').focus();
      return false;
    }else{
      $('#productSize-error').hide();
    }

    if($('#modelName').val()==''){
      $('#modelName-error').show();
      $('#modelName').focus();
      return false;
    }else{
      $('#modelName-error').hide();
    }

    if($('#productTypeID').val()==''){
      $('#productTypeID-error').show();
      $('#productTypeID').focus();
      return false;
    }else{
      $('#productTypeID-error').hide();
    }

    if($('#unitType').val()==''){
      $('#unitType-error').show();
      $('#unitType').focus();
      return false;
    }else{
      $('#unitType-error').hide();
    }

    if($('#supID').val()==''){
      $('#supID-error').show();
      $('#supID').focus();
      return false;
    }else{
      $('#supID-error').hide();
    }

    if($('#proc').val()=='add'){
      if($('#productImg').val()==''){
        $('#productImg-error').show();
        $('#productImg').focus();
        return false;
      }else{
        $('#productImg-error').hide();
      }
    }

    if($('#orderPoint').val()==''){
      $('#orderPoint_error').show();
      $('#orderPoint').focus();
      return false;
    }else{
      $('#orderPoint_error').hide();
    }
    if($('#productDetail').val()==''){
      $('#productDetail_error').show();
      $('#productDetail').focus();
      return false;
    }else{
      $('#productDetail_error').hide();
    }

    if(parseInt($('#total_unit').val())!=parseInt($('#productUnit').val().trim().replace(/,/g,''))){
      $('#tb_data-error').show();
      return false;
    }
    if($('#chk').val()==1){
      return false;
    }
    if($('#chk4').val()==1){
      return false;
    }
    if($('#chk3').val()==1){
      return false;
    }
    if($('#chk5').val()==1){
      return false;
    }
    
    if($('#supID_'+$('#rowid2').val()).val() == ""){
      $('#supID'+$('#rowid2').val()+'-error2').show();
      $('#supID_'+$('#rowid2').val()).focus();
      return false;
    }
    
    if($('#locationID_'+$('#rowid').val()).val() == ""){
      $('#locationID'+$('#rowid').val()+'-error2').show();
      $('#locationID_'+$('#rowid').val()).focus();
      return false;
    }

    if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
      $("#frm-input").submit();
    }
  }

  $(document).ready(function() {
     //   $('.idcard').inputmask('9-9999-99999-99-9', { placeholder: '_-____-_____-__-_' });
     //   $('.mobile').inputmask('999-999-9999', { placeholder: '___-___-____' });
        //$('.focused').removeClass('focused');
        $('.form-line').removeClass('focused');
        $('.error').hide();

        // $('.datepickers').bootstrapMaterialDatePicker();
     //  $(".numb").keyup(function() {//Can Be {0-9,.}
    	// 		chkFormatNam($(this).val(), $(this).attr('id'));
    	// });
      $(".numb").inputFilter(function(value) {
        return /^\d*$/.test(value); });
      get_total();
    });

  function get_code(){
    // if($('#proc').val()=='add'){
      var html  = '<option value="">เลือก</option>';
      var productTypeID = $('#productTypeID').val();
      $.ajaxSetup({async: false});  
      $.post('process/get_process.php',{proc:'get_brand',productTypeID:productTypeID},function(data){

        $.each(data,function(index,value){
          html += "<option value='"+value['DATA_VALUE']+"'>"+value['DATA_NAME']+"</option>";
        });
        $('#hdfproductTypeID').val(productTypeID);
        $('#brandID').html(html);
        $('#brandID').selectpicker('refresh');
      },'json');


      if (productTypeID != 1) {
        var newcode ='';
        $.ajaxSetup({async: false});
        $.post('process/get_process.php',{proc:'get_productcoder_other',productTypeID:productTypeID},function(data){
         newcode =  data['name'];
         $('#productCode').val(newcode);
       },'json');

      }else{
        $('#productCode').val('');
      }
      chk();
      
    }

    function get_code2(){
      var brand = $('#brandID').val();
      $('#hdfbrandID').val(brand);
      if($('#proc').val()=='add'){
        var productTypeID = $('#productTypeID').val();
        if (productTypeID == 1) {
          var str_size = $('#productSize').val();
          var re_size =str_size.replace(/\D+/g, '');
          var modelName = $('#modelName').val().replace(/ /g,'');
          var short='';
          var newcode ='';
          $.ajaxSetup({async: false});
          $.post('process/get_process.php',{proc:'get_productcode',brand:brand},function(data){
           short =  data['name'];
         },'json');
          newcode = short+re_size+modelName;
          $('#productCode').val(newcode);
          chk();
        }
      }
    }

    function chk(){
      var productCode = $('#productCode').val();
      $.ajaxSetup({async: false});
      $.post('process/get_process.php',{proc:'chk_productCode',productCode:productCode},function(data){
       if(data==1){
        $('#productCode-error').show();
        $('#chk').val(1);
      }else{
       $('#productCode-error').hide();
       $('#chk').val(0);
     }
   },'json');
    }
    function addRow(){
      $('#nodata').hide();
      var html = '';
      var rowid = parseInt($('#rowid').val())+1;

      if($('#locationID'+$('#rowid').val()).val() == ""){
        $('#locationID'+$('#rowid').val()+'-error2').show();
        return false;
      }else{
        $('#locationID'+$('#rowid').val()+'-error2').hide();

        html += '<tr>';
        html += '<td>';
        html += '<select name="locationID[]" id="locationID_'+rowid+'" onchange="chk_location(this.value);" class="form-control show-tick" data-live-search="true" >';
        html += '<option value="">เลือก</option>';
        <?php
        $q_location = $db->query($s_location);
        while ($r_location = $db->db_fetch_array($q_location)) {?>
          html +='<option value="<?php echo $r_location['locationID'];?>"><?php echo $r_location['locationName'];?></option>';
        <?php } ?>
        html +='</select>';
        html +='<label id="locationID'+rowid+'-error" class="error" for="locationID_'+rowid+'">ตำแหน่งนี้ถูกใช้แล้ว</label>';
        html +='<label id="locationID'+rowid+'-error2" class="error" for="locationID_'+rowid+'">กรุณาเลือกตำแหน่งจัดเก็บ</label>'; 
        html +='</td>';
        html += '<td>';
        html += '    <div class="form-line">';
        html += '       <input type="text"  style="text-align: right;" class="form-control numb"   name="ps_unit[]" id="ps_unit_'+rowid+'" onBlur="NumberFormat(this); get_total();" value="0" >';
        html += '    </div>';
        html += '</td>';
        html += '<td style="text-align: center;">';
        html += '<a class=\"btn bg-red btn-xs waves-effect\"  href=\"javascript:void(0);\" onClick=\"delDataTB(this,0);\"><?php echo $img_del;?> </a>';
        html += '</td>';
        html += '</tr>';
        $('#tb_data tbody').append(html);
        $('#rowid').val(rowid);
        $('#locationID_'+rowid).selectpicker('refresh');
        $(".numb").inputFilter(function(value) {
          return /^\d*$/.test(value); });

        $('#locationID'+rowid+'-error').hide();
        $('#locationID'+rowid+'-error2').hide();
      }
   //  $(".numb").keyup(function() {//Can Be {0-9,.}
  	// 		chkFormatNam($(this).val(), $(this).attr('id'));
  	// });
  }

  function addRowsup(){
    //$('#nodatasup').hide();
    var html = '';
    var rowid = parseInt($('#rowid2').val())+1;

    if($('#supID_'+$('#rowid2').val()).val() == ""){
      $('#supID'+$('#rowid2').val()+'-error2').show();
      return false;
    }else{
      $('#supID'+$('#rowid2').val()+'-error2').hide();
      html += '<tr>';
      html += '<td>';
      html += '<select name="supID[]" id="supID_'+rowid+'" onchange="chk_sup(this,0);" class="form-control show-tick" data-live-search="true" >';
      html += '<option value="">เลือก</option>';
      <?php
      $s_sup =" SELECT * from tb_supplier";
      $q_sup = $db->query($s_sup);
      $n_sup = $db->db_num_rows($q_sup);
      while($r_sup = $db->db_fetch_array($q_sup)){
        ?>
        html +='<option value="<?php echo $r_sup['supID'];?>"><?php echo $r_sup['sup_name'];?></option>';
      <?php } ?>
      html +='</select>';
      html +='<label id="supID'+rowid+'-error" class="error" for="supID_'+rowid+'">บริษัทคู่ค้านี้ถูกใช้แล้ว</label>';
      html +='<label id="supID'+rowid+'-error2" class="error" for="supID_'+rowid+'">กรุณาเลือกบริษัทคู่ค้า</label>';             
      html +='</td>';
      html += '<td style="text-align: center;">';
      html += '<a class=\"btn bg-red btn-xs waves-effect\"  href=\"javascript:void(0);\" onClick=\"delDataTBsup(this,0,0,0);\"><?php echo $img_del;?> </a>';
      html += '</td>';
      html += '</tr>';
      $('#tb_datasup tbody').append(html);
      $('#rowid2').val(rowid);
      $('#supID_'+rowid).selectpicker('refresh');

      $('#supID'+rowid+'-error').hide();
      $('#supID'+rowid+'-error2').hide();
    }

   //  $(".numb").keyup(function() {//Can Be {0-9,.}
    //    chkFormatNam($(this).val(), $(this).attr('id'));
    // });
  }

  function delDataTB(obj,id,index){
    debugger
    var locationID = id;
    if(confirm("ยืนยันการลบตำแหน่งจัดเก็บ ?")){
      if (locationID != 0) {
        $.ajaxSetup({async: false});
        $.post('process/get_process.php',{proc:'chkDelData_locStrock',locationID:locationID},function(data){        
          if(data > 0){
            alert('ไม่สามารถลบข้อมูลได้ เนื่องจากมีสินค้านี้อยู่ในคลัง');
            return false;
          }else{
            $('#isDeleted1'+index).val(1);
            var row = parseInt($('#tb_data tbody tr').length);     
            if (row != 1) {
              //$('#nodatasup').show();
              $(obj).parent().parent().hide();
              get_total();
            }else{
              alert('ไม่สามารถลบข้อมูลได้ เนื่องจากต้องมีตำแหน่งจัดเก็บอย่างน้อย1รายการ');
            }
          }
        },'json');
      }else{
        var row = parseInt($('#tb_data tbody tr').length);
        if (row != 1) {
          //$('#nodata').show();
          $(obj).parent().parent().remove();
          get_total();
        }
      }
      // if($('#total_unit').val() != 0){
      //   alert("ไม่สามารถลบตำแหน่งจัดเก็บได้ เนื่องจากมีสินค้านี้อยู่ในคลัง");
      //   return;
      // }
    }


  }

  function delDataTBsup(obj,id,id2,index){

    var supID = id;
    if(confirm("ยืนยันการลบบริษัทคู่ค้า ?")){
      if (supID != 0) {
        $.ajaxSetup({async: false});
        $.post('process/get_process.php',{proc:'chkDelData_supPO',supID:supID},function(data){        
          if(data > 0){
            alert('ไม่สามารถลบข้อมูลได้ เนื่องจากมีการสั่งซื้อสินค้าจากบริษัทคู่ค้านี้อยู่');
            return false;
          }else{

            $('#isDeleted'+index).val(1);
            var row = parseInt($('#tb_datasup tbody tr').length);     
            if (row != 1) {
              //$('#nodatasup').show();
              $(obj).parent().parent().hide();
            }else{
              alert('ไม่สามารถลบข้อมูลได้ เนื่องจากต้องมีบริษัทคู่ค้าอย่างน้อย1รายการ');
            }
          }
        },'json');
      }else{
        var row = parseInt($('#tb_datasup tbody tr').length);     
        if (row != 1) {
          //$('#nodatasup').show();
          $(obj).parent().parent().remove();
        }else{
          alert('ไม่สามารถลบข้อมูลได้ เนื่องจากต้องมีบริษัทคู่ค้าอย่างน้อย1รายการ');
        }
      }
    }
  }

  function  get_total(){
    var arr = $('input[id^=ps_unit_]');
    var total = 0;
    for (var i = 0; i < arr.length; i++) {
     var num = parseInt($(arr[i]).val().trim().replace(/,/g,''));

     total = total+num;
   }
   $('#total_unit').val(total);
   //var arr = parseInt($('#rowid').val()replace(/,/g,''));
 }

 function  chk_location(){
  var arr = $('[id^=locationID_]');
  var total = 0;
  for (var i = 0; i < arr.length; i++) {
   var num = $(arr[i]).val().trim();
   if (i != 0) {
    var a = i-1;
    var x = i + 1;
    if(num == $(arr[a]).val().trim())
    {
      $('#locationID'+[x]+'-error').show();
      $('#chk3').val(1);
      return false;    
    }else{
      $('#locationID'+[x]+'-error').hide();
      $('#chk3').val(0);
    }
  }
}
}

function  chk_sup(obj,id){
  debugger
  var supID = id;
  if (supID != 0) {
    $.ajaxSetup({async: false});
    $.post('process/get_process.php',{proc:'chkDelData_supPO',supID:supID},function(data){        
      if(data > 0){
        alert('ไม่สามารถเปลี่ยนบริษัทคู่ค้าได้ เนื่องจากมีการสั่งซื้อสินค้าจากบริษัทคู่ค้านี้อยู่');   
        $('#'+obj.id).val(supID);
        return false;
      }else{
        var arr = $('[id^=supID_]');
        var total = 0;
        for (var i = 0; i < arr.length; i++) {
         var num = $(arr[i]).val().trim();
         if (i != 0) {
          var a = i-1;
          var x = i + 1;
          if(num == $(arr[a]).val().trim())
          {
            $('#supID'+[x]+'-error').show();
            $('#chk4').val(1);
            return false;    
          }else{
            $('#supID'+[x]+'-error').hide();
            $('#chk4').val(0);
          }
        }
      }
    }
  },'json');
  }

}

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
function ValidateSingleInput(oInput) {
  if (oInput.type == "file") {
    var sFileName = oInput.value;
    if (sFileName.length > 0) {
      var blnValid = false;
      for (var j = 0; j < _validFileExtensions.length; j++) {
        var sCurExtension = _validFileExtensions[j];
        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
          blnValid = true;
          break;
        }
      }

      if (!blnValid) {
              // alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
              alert("กรุณาตรวจสอบไฟล์อัพโหลด");
              //$('#img-error').show();
              oInput.value = "";
              return false;
            }
          }
        }
        return true;
      }

      function chkName(){
        var productName= $('#productName').val();
        var productID= $('#productID').val();
        $.ajaxSetup({async: false});
        $.post('process/get_process.php',{proc:'chk_productName',productName:productName,productID:productID},function(data){
          if(data==1){
            $('#productName2-error').show();
            $('#chk1').val(1);
          }else{
            $('#productName2-error').hide();
            $('#chk1').val(0);

          }

        },'json');
      }

      function delData(parent_id,id,hdf_id){
        var productID = $('#productID').val();
        $.ajaxSetup({async: false});
        $.post('process/get_process.php',{proc:'chkDelData_Product',productID:productID},function(data){
          if(data > 0){
            alert('ไม่สามารถยกเลิกข้อมูลได้ เนื่องจากมีสินค้านี้อยู่ในคลัง');
            $('#'+parent_id).val(1);
            return false;
          }else{
            $('#'+hdf_id).val(id);
          }
        },'json');

      }
       function readURL(input) {

        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#productImg").change(function() {
        readURL(this);
      });
    </script>
