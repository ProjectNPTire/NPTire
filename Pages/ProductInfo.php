<!DOCTYPE html>
<html>
<?php
$path = "../";
include($path."include/config_header_top.php");
 include 'css.php';
 $page_key ='2_3_2';
 $form_page = $form_page;

 $sql     = " SELECT *
            FROM tb_product
            where productID ='".$productID."' ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$rec = $db->db_fetch_array($query);
$proc = ($proc=='')?"add":$proc;
$txt =  ($proc=='add')?"เพิ่ม":"แก้ไข";
$s_location = "SELECT * from tb_location order by locationName ";
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
                            <h2><?php echo $txt;?>ข้อมูลสินค้าอื่นๆ</h2>
                        </div>
                         <form id="frm-input" method="post" enctype="multipart/form-data" action="process/Product_process.php" >
                                <input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>">
                                <input type="hidden" id="productID" name="productID" value="<?php echo $productID;?>">
                                <input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page?>">
                                <input type="hidden" id="chk" name="chk" value="0">
                                <input type="hidden" id="chk1" name="chk1" value="0">

              <input type="hidden" id="chk2" name="chk2" value="0">
                            <div class="body">
                              <div class="row clearfix">
                                <div class="col-sm-12 align-right"><b><span style="color:red">* กรอกข้อมูลให้ครบทุกช่อง</span></b>
                                </div>
                              </div>
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                          <b>รหัสสินค้า</b>
                                         <div class="input-group">
                                            <div class="form-line">
                                                <input type="text " readonly name="productCode" id="productCode" class="form-control" placeholder="รหัสสินค้า" value="<?php echo $rec['productCode'];?>">
                                            </div>
                                            <label id="productCode-error" class="error" for="productName">มีรหัสสินค้านี้แล้ว</label>
                                        </div>
									                  </div>
                                    <div class="col-sm-8">
                                         <b>ชื่อสินค้า</b>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" onkeyup="chkName();" class="form-control " placeholder="ชื่อสินค้า"  name="productName" id="productName"  value="<?php echo $rec['productName'];?>">
                                            </div>
                                            <label id="productName-error" class="error" for="productName">กรุณาระบุ ชื่อสินค้า</label>
                      <label id="productName2-error" class="error" for="productName">มีประเภทสินค้านี้แล้ว</label>
                                        </div>
                                    </div>
                                </div>
								               <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>ยี่ห้อสินค้า</b>

                                        <div class="form-group form-float">
                                            <select name="brandID" id="brandID" class="form-control show-tick" data-live-search="true" <?php echo $proc == "edit" ? 'disabled' : '';?>>
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
                                            <input type="hidden" name="hdfbrandID" id="hdfbrandID" value="<?php echo $rec['brandID'] ?>">
                                          <label id="brandID-error" class="error" for="brandID">กรุณาเลือก ยี่ห้อสินค้า</label>
                                        </div>
                                    </div>
																		<div class="col-sm-4">
																			<b>ประเภทสินค้า</b>

																			<div class="form-group form-float">
																				<select name="productTypeID" id="productTypeID" class="form-control show-tick" data-live-search="true"  onchange="get_code();" <?php echo $proc == "edit" ? 'disabled' : '';?>>
																					<option value="">เลือก</option>
																					<?php
																					$s_pdtype=" SELECT * from tb_producttype where productTypeID not in (1,2) order by productTypeName asc";
																					$q_pdtype = $db->query($s_pdtype);
																					$n_pdtype = $db->db_num_rows($q_pdtype);
																					while($r_pdtype = $db->db_fetch_array($q_pdtype)){

																						?>
																						<option value="<?php echo $r_pdtype['productTypeID'];?>"  <?php echo ($rec['productTypeID']==$r_pdtype['productTypeID'])?"selected":"";?>> <?php echo $r_pdtype['productTypeName'];?></option>

																					<?php }  ?>
																				</select>
                                            <input type="hidden" name="hdfproductTypeID" id="hdfproductTypeID" value="<?php echo $rec['productTypeID'] ?>">
																				<label id="productTypeID-error" class="error" for="productTypeID">กรุณาเลือก ประเภทสินค้า</label>
																			</div>
																		</div>
                                    <div class="col-sm-4">
                                        <b>หน่วยนับ <span style="color:red"> *</span></b>

                                        <div class="form-group form-float">
                                            <select name="unitType" id="unitType" class="form-control show-tick" data-live-search="true" <?php echo $proc == "edit" ? 'disabled' : '';?>>
                                                <option value="">เลือก</option>
                                            <?php   foreach ($arr_unitType as $key => $value) {?>
                                                <option value="<?php echo $key;?>"  <?php echo ($rec['unitType']==$key)?"selected":"";?>> <?php echo $value;?></option>

                                            <?php }  ?>
                                            </select>
                                            <input type="hidden" name="hdfunitType" id="hdfunitType" value="<?php echo $rec['unitType'] ?>">
                                          <label id="unitType-error" class="error" for="unitType">กรุณาเลือก หน่วยนับ</label>
                                        </div>
                                    </div>
                                    
																		
															</div>

                                <div class="row clearfix">
																	<div class="col-md-4">
                                     <b>รูปภาพ</b>
                                     <div class="form-group">
                                      <div class="form-line">
                                        <input type="file" class="form-control " name="productImg" id="productImg" accept="image/x-png, image/gif, image/jpeg" value="<?php echo $rec['productImg'];?>" onchange="ValidateSingleInput(this);" >
                                        <input type="hidden" name="old_file" id="old_file" value="<?php echo $rec['productImg'];?>" >
                                      </div>
                                      <label id="productImg-error" class="error" for="productImg">กรุณาเลือกรูปภาพ</label>
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
                                 
                    <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>บริษัทคู่ค้า</b>

                                        <div class="form-group form-float">
                                            <select name="supID" id="supID" class="form-control show-tick" data-live-search="true" <?php echo $proc == "edit" ? 'disabled' : '';?>>
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
                                            <input type="hidden" name="hdfsupID" id="hdfsupID" value="<?php echo $rec['supID'] ?>">
                                          <label id="supID-error" class="error" for="supID">กรุณาเลือก บรืษัทคู่ค้า</label>
                                        </div>
                    </div> 

                                <!--  <div class="row clearfix">
             												<div class="col-sm-12">
             															<b>รายละเอียด </b>
             														 <div class="form-group">
             																<div class="form-line">
             																	<textarea  class="form-control" placeholder="รายละเอียด" id="productDetail" name="productDetail"> <?php echo $rec['productDetail'];?> </textarea>
             																</div>
             															</div>
             													</div>
             											</div>
 -->

                               <div class="row clearfix">

                                   <!--
                                   <div class="col-sm-4">
                                      <b>สถานะการใช้งาน</b>
                                       <div class="form-group">
                                            <input type="radio" value="1" name="activeStatus" id="activeStatus1" class="with-gap" <?php echo ($rec['activeStatus']==1)?"checked":"";?>>
                                            <label for="activeStatus1">ใช้งาน</label>
                                            <input type="radio" value="0" name="activeStatus" id="activeStatus0" class="with-gap"  <?php echo ($rec['activeStatus']==0)?"checked":"";?>>
                                            <label for="activeStatus0" class="m-l-20">ไม่ใช้งาน</label>
                                        </div>

                                    </div>-->
                                </div>
                               <!--  <div class="icon-and-text-button-demo align-right">
                                    <a  class="btn btn-primary waves-effect" onClick="addRow();"><span>เพิ่มสถานที่จัดเก็บ</span><?php echo $img_add;?></a>
                                </div> -->
                                <div class="input-group">
                                <table class="table table-bordered table-striped table-hover  dataTable " id="tb_data"> <!--js-basic-example-->
                                    <thead>
                                        <tr>

                                            <th width="70%">สถานที่จัดเก็บสินค้า</th>
                                            <th width="20%">จำนวน</th>
                                            <!-- <th width="10%">จัดการ</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0; $total=0;
                                        $sql_sub  = " SELECT * FROM tb_productstore    where productID ='".$productID."' ";

                                       $query_sub = $db->query($sql_sub);
                                       $nums_sub = $db->db_num_rows($query_sub);
                                      if($nums_sub>0){
                                         while ($rec_sub = $db->db_fetch_array($query_sub)) {
                                            $i++;
                                    ?>
                                    <tr>
                                        <td>
                                          <select name="locationID[]" id="locationID_<?php echo $i;?>" class="form-control show-tick" data-live-search="true" >
                                            <option value="">เลือก</option>
                                              <?php
                                              $q_location = $db->query($s_location);
                                              while ($r_location = $db->db_fetch_array($q_location)) {?>
                                            <option value="<?php echo $r_location['locationID'];?>" <?php echo ($r_location['locationID']==$rec_sub['locationID'])?"selected":"";?>><?php echo $r_location['locationName'];?></option>
                                              <?php } ?>
                                          </select>
                                       </td>
                                        <td>
                                            <div class="form-line">
                                              <input type="text"  style="text-align: right;" class="form-control numb"   name="ps_unit[]" id="ps_unit_<?php echo $i;?>" onBlur="NumberFormat(this); get_total();" value="<?php echo $rec_sub['ps_unit'];?>" >
                                            </div>
                                          </td>
                                        <!--   <td style="text-align: center;">
                                            <a class="btn bg-red btn-xs waves-effect"  href="javascript:void(0);" onClick="delData(this);"><?php echo $img_del;?></a>
                                          </td> -->
                                        </tr>
                                      <?php   }
                                    }else{
                                      echo '<tr><td align="center" colspan="7">ไม่พบข้อมูล</td></tr>';
                                    }

                                       ?>



                                    </tbody>
                              </table>
                                <label id="tb_data-error" class="error" for="tb_data">จำนวนสินค้าในตำแหน่งจัดเก็บไม่เท่ากับจำนวนสินค้าทั้งหมด</label>
                              </div>
                              <input type="hidden" id="total_unit" value="<?php echo $total;?>">
                              <input type="hidden" id="rowid" value="<?php echo $i;?>">




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
  if($('#chk2').val()==1){
      $('#productTypeName2-error').show();
      $('#productTypeName').focus();
      return false;
    }else{
      $('#productTypeName2-error').hide();
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
    if($('#proc').val()=='add'){
      if($('#productImg').val()==''){
        $('#productImg-error').show();
        $('#productImg').focus();
        return false;
      }else{
        $('#productImg-error').hide();
      }
    }
	}
    if(parseInt($('#total_unit').val())!=parseInt($('#productUnit').val().trim().replace(/,/g,''))){
      $('#tb_data-error').show();
      return false;
    }
    if($('#chk').val()==1){
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

  if($('#proc').val()=='add'){
        var productTypeID = $('#productTypeID').val();

        var newcode ='';
        $.ajaxSetup({async: false});
        $.post('process/get_process.php',{proc:'get_productcoder_other',productTypeID:productTypeID},function(data){
             newcode =  data['name'];
        },'json');

        $('#productCode').val(newcode);
        chk();
  //
  }
    // var html  = '';
    //  $.post('process/get_process.php',{proc:'get_zipcode',parent_id:parent_id},function(data){
    //
    //           $.each(data,function(index,value){
    //               html += value['zipcode'];
    //           });
    //
    //     $('#zipcode').val(html);
    //
    // },'json');
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
    var html = '';
    var rowid = parseInt($('#rowid').val())+1;
    html += '<tr>';
      html += '<td>';
      html += '<select name="locationID[]" id="locationID_'+rowid+'" class="form-control show-tick" data-live-search="true" >';
      html += '<option value="">เลือก</option>';
      <?php
      $q_location = $db->query($s_location);
      while ($r_location = $db->db_fetch_array($q_location)) {?>
          html +='<option value="<?php echo $r_location['locationID'];?>"><?php echo $r_location['locationName'];?></option>';
      <?php } ?>
      html +='</select>';
      html +='</td>';
      html += '<td>';
      html += '    <div class="form-line">';
      html += '       <input type="text"  style="text-align: right;" class="form-control numb"   name="ps_unit[]" id="ps_unit_'+rowid+'" onBlur="NumberFormat(this); get_total();" value="0" >';
      html += '    </div>';
      html += '</td>';
      html += '<td style="text-align: center;">';
      html += '<a class=\"btn bg-red btn-xs waves-effect\"  href=\"javascript:void(0);\" onClick=\"delData(this);\"><?php echo $img_del;?> </a>';
      html += '</td>';
    html += '</tr>';
    $('#tb_data tbody').append(html);
    $('#rowid').val(rowid);
    $('#locationID_'+rowid).selectpicker('refresh');
    $(".numb").inputFilter(function(value) {
        return /^\d*$/.test(value); });
   //  $(".numb").keyup(function() {//Can Be {0-9,.}
  	// 		chkFormatNam($(this).val(), $(this).attr('id'));
  	// });
}
function delData(obj){
    if(confirm("ยืนยันการลบข้อมูล ?")){
     $(obj).parent().parent().remove();
     get_total();
    }
 }
 function  get_total(){
  debugger
   var arr = $('input[id^=ps_unit_]');
   var total = 0;
   for (var i = 0; i < arr.length; i++) {
       var num = parseInt($(arr[i]).val().trim().replace(/,/g,''));

       total = total+num;
   }
   $('#total_unit').val(total);
   //var arr = parseInt($('#rowid').val()replace(/,/g,''));
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
debugger
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
</script>
