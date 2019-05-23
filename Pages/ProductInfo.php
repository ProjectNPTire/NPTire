<!DOCTYPE html>
<html>
<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='3_6';
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
// $locationTypeID =  $rec['locationTypeID'];

// if ($locationTypeID == 1) {
//   $s_location = "SELECT * from tb_location where locationTypeID = '".$locationTypeID."' and brandID = '".$rec["brandID"]."' ";
// }else if ($locationTypeID == 2) {
//   $s_location = "SELECT * FROM tb_location WHERE locationTypeID = '".$locationTypeID."' and productTypeID = '".$rec["productTypeID"]."' ";
// }
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
                          <div class="help-info">กรอกอัติโนมัติ</div>
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
                          <label id="productName-error2" class="error" for="productName">มีชื่อฆสินค้านี้แล้ว</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <b>ประเภทสินค้า</b>
                        <div class="form-group form-float">
                          <select name="productTypeID" id="productTypeID" class="form-control show-tick" data-live-search="true" onchange="get_code();" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>
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
                      <div class="col-sm-6">
                        <b>ยี่ห้อสินค้า</b>
                        <div class="form-group form-float">
                          <select name="brandID" id="brandID" onchange="get_hdfbrand(this.value,'hdfbrandID');" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>
                            <option value="">เลือก</option>
                            <?php
                            $s_brand=" SELECT * from tb_brand order by brandName asc";
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
                    </div>
                  </div>
                  <div class="col-md-4"> 
                    <div class="col-sm-12" style="text-align: center;">
                      <img id="blah" src="<?php echo $proc == "add" ? '' : $path_image."/".$rec['productImg'];?>" height="183.8" />
                    </div>
                  </div>
                </div>

                <div class="row clearfix">
                  <div class="col-sm-4">
                    <b>ประเภทตำแหน่งจัดเก็บ</b>
                    <div class="form-group form-float">
                      <select name="locationTypeID" id="locationTypeID" onchange="get_hdflocationType(this.value,'locationID,hdflocationTypeID');" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>                   
                        <option value="">เลือก</option>a                 
                        <?php
                        $s_pdtype=" SELECT * from tb_locationtype order by locationTypeID asc";
                        $q_pdtype = $db->query($s_pdtype);
                        $n_pdtype = $db->db_num_rows($q_pdtype);
                        while($r_pdtype = $db->db_fetch_array($q_pdtype)){
                          ?>
                          <option value="<?php echo $r_pdtype['locationTypeID'];?>" <?php echo ($rec['locationTypeID']==$r_pdtype['locationTypeID'])?"selected":"";?>> <?php echo $r_pdtype['locationTypeName'];?></option>
                        <?php }  ?>
                      </select>
                      <input type="hidden" name="hdflocationTypeID" id="hdflocationTypeID" value="<?php echo $rec['locationTypeID'] ?>">
                      <label id="locationTypeID-error" class="error" for="locationTypeID">กรุณาเลือก ประเภทตำแหน่งจัดเก็บ</label>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <b>ตำแหน่งจัดเก็บ</b>
                    <div class="form-group form-float">
                      <select name="locationID" id="locationID" onchange="get_hdflocation(this.value,'hdflocationID');" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>                   
                        <option value="">เลือก</option>a                 
                        <?php
                        $s_pdtype=" SELECT * FROM tb_location WHERE locationTypeID ='".$rec['locationTypeID']."' AND productID IN ('".$rec["productID"]."',0)";
                        $q_pdtype = $db->query($s_pdtype);
                        $n_pdtype = $db->db_num_rows($q_pdtype);
                        while($r_pdtype = $db->db_fetch_array($q_pdtype)){
                          ?>
                          <option value="<?php echo $r_pdtype['locationID'];?>" <?php echo ($rec['locationID']==$r_pdtype['locationID'])?"selected":"";?>> <?php echo $r_pdtype['locationName'];?></option>
                        <?php }  ?>
                      </select>
                      <input type="hidden" name="hdflocationID" id="hdflocationID" value="<?php echo $rec['locationTypeID'] ?>">
                      <label id="locationID-error" class="error" for="locationID">กรุณาเลือก ตำแหน่งจัดเก็บ</label>
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
                <div class="row clearfix">
                  <div class="col-sm-4">
                    <b>หน่วยนับ</b>
                    <div class="form-group form-float">
                      <select name="unitType" id="unitType" onchange="getunit(this.value,'hdfunitType');" class="form-control show-tick" data-live-search="true" <?php echo $_SESSION["userType"] == "2"  ? 'disabled' : '';?>>
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
                </div>
                <div class="row clearfix">
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
                            } ?>><?php echo $value;?>
                          </option>
                        <?php }  ?>
                      </select>
                      <input type="hidden" name="hdfstatus" id="hdfstatus" value="<?php echo $proc == "edit"  ? $rec['isEnabled'] : '1';?>">
                    </div>
                  </div>
                  <div class="col-sm-8">
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
                  <li role="presentation" class="active"><a href="#home" data-toggle="tab">คุณลักษณะ</a></li>
                  <li role="presentation"><a href="#messages" data-toggle="tab">คู่ค้า</a></li>
                  <!--              <li role="presentation"><a href="#profile" data-toggle="tab">ตำแหน่งจัดเก็บ</a></li> -->
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade in active" id="home">
                    <div class="icon-and-text-button-demo align-right">
                      <?php
                      $i=0;
                      $sql_attr  = " SELECT tb_productattr.*,tb_attribute.attrName FROM tb_productattr join tb_attribute
                      on tb_productattr.attrID = tb_attribute.attrID
                      where productID ='".$productID."'";

                      $query_attr = $db->query($sql_attr);
                      $nums_attr = $db->db_num_rows($query_attr);             
                      ?>
                      <!--     <a  class="btn btn-primary waves-effect" onClick="popup();"><span>เลือกคุณลักษณะ</span><i class="material-icons">add_box</i></a> -->
                    </div>
                    <div class="form-group">
                      <table class="table table-bordered table-striped table-hover  dataTable " id="tb_data_attr" >
                        <thead>
                          <tr>
                            <th width="10%">ลำดับ</th>
                            <th width="50%">คุณลักษณะ</th>
                            <th width="30%"></th>   
                          </tr>
                        </thead>
                        <?php 
                        if($nums_attr>0){
                          ?>
                          <tbody>
                           <?php while ($rec_attr = $db->db_fetch_array($query_attr)) {
                            $i++;
                            $del = '<a class="btn bg-red btn-xs waves-effect"  href="javascript:void(0);" onClick="delDataTB(this,'.$rec_attr['attrID'].');">'.$img_del.'</a>';
                            ?>
                            <tr>
                              <td align="center"><?php echo $i; ?>
                              <input type="hidden" name="attrID[]" id="attrID_<?php echo $i;?>" value="<?php echo $rec_attr['attrID'];?>"></td>                               
                              <td><?php echo $rec_attr['attrName']; ?></td>
                              <td>
                                <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="valuetxt[]" id="valuetxt_<?php echo $i;?>" value="<?php echo $rec_attr['value'];?>" >
                                  </div>
                                  <label id="valuetxt_<?php echo $i;?>-error" class="error" for="valuetxt_<?php echo $i;?>">กรุณาเลือก</label>
                                </div> 
                              </td>
                             <!--    <td style="text-align: center;">
                                  <?php echo $del;?>
                                </td> -->
                              </tr>

                            <?php   } ?>
                          </tbody>
                        <?php }else{
                          echo '<tbody  id="ModalDATA"><tr><td colspan="3" align="center">ไม่พบข้อมูล</td></tr></tbody>';
                        } ?>
                      </table>
                      <label id="tb_data_attr-error" class="error" for="tb_data_attr">กรุณาเพิ่มคุณลักษณะ</label>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="messages">
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
                              $del = ' <a class="btn bg-red btn-xs waves-effect"  href="javascript:void(0);" onClick="delDataTBsup(this,'.$rec_sub['supID'].','.$rec_sub['runID'].','.$a.');">'.$img_del.'</a>';
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
                                <td style="text-align: center;"><?php echo $del;?></td>
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
                          <?php } ?>
                        </tbody>
                      </table>
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
            </form>
          </div>
        </div>
      </div>

    </div>
  </section>
  <?php include 'js.php';?>
</body>

</html>

<!-- <div class="modal fade" id="ModalAttribute" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="largeModalLabel">คุณลักษณะ</h4>
        <form>
          <br><br><br>
          <div class="row">
            <div class="col-sm-9 col-sm-offset-1">
              <div class="form-group">
                <div class="input-group">
                 <div class="form-line">
                   <input type="text " name="s_attrName" id="s_attrName" class="form-control" placeholder="ชื่อคุณลักษณะ" value="<?php echo $s_attrName;?>">
                 </div>
               </div>
             </div>
           </div>
           <div class="col-sm-2">
            <div class="form-group">
              <div class="text-center">
                <a  class="btn btn-success waves-effect"onclick="get_search();" ><span>ค้นหา</span><?php echo $img_view;?></a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-body">
     <table class="table table-bordered table-striped table-hover  dataTable "> 
       <thead>
         <tr>
           <th align="center" width="10%">ลำดับ</th>
           <th width="45%">ชื่อคุณลักษณะ</th>
           <th width="35%"></th>
           <th width="10%"></th>
         </tr>
       </thead>
       <tbody  id="ModalDATA">
       </tbody>
     </table>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-success waves-effect" onclick="onsubmitModal();">เลือก</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ปิด</button>
  </div>
</div>
</div>
</div> -->

<script>
  function OnCancel()
  {
    $(location).attr('href',"<?php echo  $form_page?>");
  }

  function chkinput(){

    if($('#chk2').val()==1){
      $('#productName-error2').show();
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

    if($('#locationTypeID').val()==''){
      $('#locationTypeID-error').show();
      $('#locationTypeID').focus();
      return false;
    }else{
      $('#locationTypeID-error').hide();
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

    if($('#unitType').val()==''){
      $('#unitType-error').show();
      $('#unitType').focus();
      return false;
    }else{
      $('#unitType-error').hide();
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

    // if(parseInt($('#total_unit').val())!=parseInt($('#productUnit').val().trim().replace(/,/g,''))){
    //   $('#tb_data-error').show();
    //   return false;
    // }
    if($('#chk').val()==1){
      $('#productCode-error').show();
      $('#productCode').focus();
      return false;
    }else{
      $('#productCode-error').hide();
    }

    if($('#chk4').val()==1){
      return false;
    }
    if($('#chk3').val()==1){
      return false;
    }

    var obj_id = $("#tb_data_attr tbody tr");
    if($('#rowid').val() == 0){
      $('#tb_data_attr-error').show();
      return false;
    }else{
      $('#tb_data_attr-error').hide();
      $.each(obj_id, function(){
        if(($(this).find('td:eq(2)').find('input').val()).toString() == ""){
          $(this).find('td:eq(2)').find('.error').show();
          $('#chk5').val(1);
        }else{
          $(this).find('td:eq(2)').find('.error').hide();
          $('#chk5').val(0);
        }
      });
    }

    if($('#chk5').val()==1){
      return false;
    }

    if($('#supID_'+$('#rowid2').val()).val() == ""){
      $('#supID'+$('#rowid2').val()+'-error2').show();
      $('.nav-tabs > .active').next('li').find('a').trigger('click');
      $('#supID_'+$('#rowid2').val()).focus();
      return false;
    }else{
      $('#supID'+$('#rowid2').val()+'-error2').hide();
    }

    if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
      $("#frm-input").submit();
    }
  }

  $(document).ready(function() {
    $('.form-line').removeClass('focused');
    $('.error').hide();

    $(".numb").inputFilter(function(value) {
      return /^\d*$/.test(value); });
    get_total();
  });

  // function popup(){
  //   $('#ModalAttribute').modal('show');
  //   get_search();
  // }

  // function get_search() {
  //   $('#ModalDATA').html('');
  //   var name  =  $('#s_attrName').val();
  //   var html ='';
  //   $.ajaxSetup({async: false});
  //   $.post('process/get_process.php',{proc:'get_attribute',name:name},function(data){
  //     if(data != ''){
  //       $.each(data,function(index,value){
  //        html += '<tr>';
  //        html += '<td align="center">'+value['order']+'</td>';
  //        html += '<td>'+value['attrName']+'</td>';
  //        html += '<td><div class="form-group"><div class="form-line"><input type="text" class="form-control" id="F_valuetxt_'+index+'" ></div></div></td>';
  //        html += '<td align="center">';
  //        html += '<input type="checkbox" id="F_attrID_'+index+'"  value="'+value['attrID']+'"  class="filled-in" >';
  //        html += '<label for="F_attrID_'+index+'"></label>';
  //        html += '<input type="hidden" id="F_attrName_'+index+'" value="'+value['attrName']+'">';
  //        html += '</td>';
  //        html += '</tr>';
  //      });
  //     }else{
  //       html += '<tr>';
  //       html += '<td colspan="3" align="center">ไม่พบข้อมูล</td>';
  //       html += '</tr>';
  //     }
  //   },'json');
  //   $('#ModalDATA').html(html);
  // }

//   function onsubmitModal(){
//     var html = '';
//     var rowid = parseInt($('#rowid').val());

//     if (rowid == 0) {
//       $("#tb_data_attr tbody").html("");
//     }

//     var arr_attr_id = $('input[id^=F_attrID_]');
//     var arr_attr_name = $('input[id^=F_attrName_]');
//     var arr_attr_vaue = $('input[id^=F_valuetxt_]');
//     if(arr_attr_id.length>0){
//       for (var i = 0; i < arr_attr_id.length; i++) {

//        if (arr_attr_id[i].checked){
//         rowid = rowid+1;
//         html += '<tr>';
//         html += '<td style="text-align:center">'+rowid+'<input type="hidden" name="attrID[]" id="attrID_'+rowid+'" value="'+arr_attr_id[i].value+'"></td>';
//         html += '<td>'+arr_attr_name[i].value+'</td>';
//         html += '<td>';
//         html += '<div class="form-line">';
//         html += '   <input type="text" class="form-control" name="valuetxt[]" id="valuetxt_'+rowid+'" value="'+arr_attr_vaue[i].value+'" >';
//         html += '</div>';
//         html += '</td>';
//         html += '<td style="text-align: center;">';
//         html += '<a class=\"btn bg-red btn-xs waves-effect\"  href=\"javascript:void(0);\" onClick=\"delDataTB(this,0,0);\"><?php echo $img_del;?> </a>';
//         html += '</td>';
//         html += '</tr>';
//       }
//     }
//   }

//   var obj_id = $("#tb_data_attr tbody tr");
//   $.each(obj_id, function(){
//     if(($(this).find('td:eq(1)').text()).toString() == (arr_attr_name[arr_attr_name.length-1].value).toString()){
//       html = "";
//       alert("มีคุณลักษณะนี้แล้ว");
//       return false;
//     }
//   });

//   if(html != ""){
//     $('#ModalAttribute').modal('hide');
//     $('#tb_data_attr tbody').append(html);
//     $('#rowid').val(rowid);
//   }

// }

function get_hdfbrand(id,hdf_id){
  $('#'+hdf_id).val(id);
  var productTypeID = $('#productTypeID').val();
  if (productTypeID == 1) {
    var brandID = $('#brandID').val();
    $.ajaxSetup({async: false});
    $.post('process/get_process.php',{proc:'get_productcode',brandID:brandID},function(data){
     short =  data['name'];
   },'json');
    var old = $('#productCode').val().substring(0, 2);
    var txt = $('#productCode').val().substring(2);
    var newcode = short+txt;
    $('#productCode').val(newcode);
    chk();
  }
}
function get_hdflocationType(arent_id,id,hdf_id){
  var locationTypeID = arent_id;
  var html  = '<option value="">เลือก</option>';
  $.ajaxSetup({async: false});  
  $.post('process/get_process.php',{proc:'get_location',locationTypeID:locationTypeID},function(data){

    $.each(data,function(index,value){
      html += "<option value='"+value['DATA_VALUE']+"'>"+value['DATA_NAME']+"</option>";
    });

  $('#'+hdf_id).val(locationTypeID);
    $('#'+id).html(html);
    $('#'+id).selectpicker('refresh');

  },'json');
}

function get_code(){
  var productTypeID = $('#productTypeID').val();
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
  $('#hdfproductTypeID').val(productTypeID);
  chk();

  $('#ModalDATA').html('');
  var html ='';
  var i = 1;
  $.ajaxSetup({async: false});
  $.post('process/get_process.php',{proc:'get_typeattr',productTypeID:productTypeID},function(data){
    //console.log(data);
    if(data != ''){
      $.each(data,function(index,value){
        html += '<tr>';
        html += '<td align="center">'+i+'</td>';
        html += '<td>'+value['attrName'];
        html += '<input type="hidden" id="F_attrName_'+index+'" value="'+value['attrName']+'">';
        html += '</td>';
        html += '<td align="center">';
        html += '<div class="form-group"><div class="form-line"><input type="text" onkeyup="get_code2();"  onblur="get_code2();" class="form-control" id="F_valuetxt_'+index+'" value="" ></div><label id="valuetxt_'+index+'-error" class="error" for="F_valuetxt_'+index+'">กรุณาเลือก</label></div>';
        html += '</td>';
        html += '</tr>';
        i++;
      });
    }else{
      html += '<tr>';
      html += '<td colspan="3" align="center">ไม่พบข้อมูล</td>';
      html += '</tr>';
    }
  },'json');
  $('#ModalDATA').html(html);

  $('#tb_data_attr-error').hide();

  $('#rowid').val(i-1);

  var obj_id = $("#tb_data_attr tbody tr");
  $.each(obj_id, function(){
    $(this).find('td:eq(2)').find('.error').hide();
  });
}

function get_code2(){
  if($('#proc').val()=='add'){
    var productTypeID = $('#productTypeID').val();
    if (productTypeID == 1) {    
      var brandID = $('#brandID').val();
      if(brandID != ""){
        $('#brandID-error').hide();
        var newcode ='';
        var short='';
        var txtvalue='';
        $.ajaxSetup({async: false});
        $.post('process/get_process.php',{proc:'get_productcode',brandID:brandID},function(data){
         short =  data['name'];
       },'json');

        var obj_id = $("#tb_data_attr tbody tr");
        $.each(obj_id, function(){
          if(($(this).find('td:eq(1)').text()).toString() == "หน้ากว้าง" || ($(this).find('td:eq(1)').text()).toString() == "ซีรี่ย์" || ($(this).find('td:eq(1)').text()).toString() == "รุ่น" || ($(this).find('td:eq(1)').text()).toString() == "ขอบล้อ"){
            txtvalue += $(this).find('td:eq(2)').find('input').val().toString();
          }
        });


        newcode = short+txtvalue.toUpperCase();
        $('#productCode').val(newcode);
        chk();
      }else{
        $('#brandID-error').show();
        $('#brandID').focus();
        var obj_id = $("#tb_data_attr tbody tr");
        $.each(obj_id, function(){ 
           $(this).find('td:eq(2)').find('input').val('');
        });
        return false;
      }
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

  function delDataTB(obj,id){
    var attrID = id;
    if(confirm("ยืนยันการลบตำแหน่งจัดเก็บ ?")){
      if (attrID != 0) {
        $.ajaxSetup({async: false});
        $.post('process/get_process.php',{proc:'chkDelData_locStrock',locationID:locationID},function(data){        
          if(data > 0){
            alert('ไม่สามารถลบข้อมูลได้ เนื่องจากมีสินค้านี้อยู่ในคลัง');
            return false;
          }else{
            //$('#isDeleted1'+index).val(1);
            var row = parseInt($('#tb_data_attr tbody tr').length);     
            if (row != 1) {
              $(obj).parent().parent().hide();
              get_total();
            }else{
              alert('ไม่สามารถลบข้อมูลได้ เนื่องจากต้องมีคุณลักษณะอย่างน้อย1รายการ');
            }
          }
        },'json');
      }else{
        var row = parseInt($('#tb_data_attr tbody tr').length);
        if (row != 1) {
          //$('#nodata').show();
          $(obj).parent().parent().remove();
          get_total();
        }
      }
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
          if(data>1){
            $('#productName-error2').show();
            $('#chk1').val(1);
          }else{
            $('#productName-error2').hide();
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

      function getunit(id,hdf_id){
        var unitID = $('#unitID').val();
        $('#'+hdf_id).val(id);
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
