<!DOCTYPE html>
<html>

<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';

$page_key = "2_1";

$form_page = $form_page;

$sql     = " SELECT *
FROM tb_supplier
where supID ='".$supID."' ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$rec = $db->db_fetch_array($query);
$proc = ($proc=='')?"add":$proc;
$txt =  ($proc=='add')?"เพิ่ม":"แก้ไข";
$readonly = "readonly";
chk_role($page_key,'isAdd',1);
?>

<body class="theme-red">
    <?php include 'MasterPage.php';?>
    <section class="content">
        <div class="container-fluid">
            <!-- Advanced Form Example With Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2><?php echo $txt;?>ข้อมูลคู่ค้า</h2>
                        </div>
                        <div class="body">
                            <form id="frm-input" action="process/sup_process.php" method="POST">
                                <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                                <input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page; ?>">
                                <input type="hidden" id="supID" name="supID" value="<?php echo $supID; ?>">
                                <input type="hidden" id="chksup" name="chksup" value="0">
                                <div class="row clearfix">
                                    <div class="col-sm-12 align-right"><b><span style="color:red">* กรอกข้อมูลให้ครบทุกช่อง</span></b>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                      <b>รหัสบริษัทคู่ค้า</b>
                                      <div class="form-group">
                                        <div class="form-line">
                                            <input type="text " name="supCode" id="supCode" class="form-control" value="<?php echo $rec['supCode'];?>" readOnly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <b>บริษัทคู่ค้า</b>
                                        <div class="form-line">
                                            <input type="text" id="sup_name" name="sup_name" class="form-control" placeholder="ชือบริษัทคู่ค้า" value="<?php echo $rec['sup_name'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?> onkeyup="chk_sup();">
                                        </div>
                                        <label id="sup_name_error" class="error" for="sup_name">กรุณาระบุ ชื่อคู่ค้า/บริษัท</label>
                                        <label id="sup_name2_error" class="error" for="sup_name">มีชื่อบริษัทนี้แล้ว</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <b>เบอร์โทรศัพท์บริษัท</b>
                                        <div class="form-line">
                                            <input type="text" id="sup_tel" onchange="isPhoneNo(this,1);return false;" name="sup_tel" class="form-control tel" placeholder="Ex: 02-000-0000" value="<?php echo $rec['sup_tel'];?>"  <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                        </div>
                                        <div class="help-info">กรอกได้เฉพาะตัวเลข9ตัวอักษร</div>
                                        <label id="sup_tel_error" class="error" for="sup_name">กรุณาระบุ เบอร์โทรศัพท์บริษัท</label>
                                        <label id="sup_tel_error2" class="error" for="sup_name">รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง</label>
                                    </div>
                                </div>
                            </div>
                            <h2 class="card-inside-title">ที่อยู่</h2><hr />
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <b>ที่อยู่</b>
                                        <div class="form-line">
                                            <input type="text" class="form-control " placeholder="กรอก/ บ้านเลขที่ ซอย ถนน"  name="sup_address" id="sup_address"  value="<?php echo $rec['sup_address'];?>"  <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                        </div>
                                        <label id="sup_address_error" class="error" for="sup_address">กรุณาระบุ ที่อยู่</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>จังหวัด</b>
                                        <div class="form-group form-float">
                                            <select name="provinceID" id="provinceID" class="form-control show-tick" data-live-search="true" onchange="get_area(this.value,'districtID','hdfProvinceID',1);" <?php echo $_SESSION["userType"] == "2" ? 'disabled' : '';?>>
                                                <option value="">เลือก</option>
                                                <?php
                                                $s_p=" SELECT * from setup_prov order by province_name_th asc";
                                                $q_p = $db->query($s_p);
                                                $n_p = $db->db_num_rows($q_p);
                                                while($r_p = $db->db_fetch_array($q_p)){?>
                                                    <option value="<?php echo $r_p['provinceID'];?>"  <?php echo ($rec['provinceID']==$r_p['provinceID'])?"selected":"";?>> <?php echo $r_p['province_name_th'];?></option>

                                                <?php }  ?>
                                            </select>
                                            <input type="hidden" name="hdfProvinceID" id="hdfProvinceID" value="<?php echo $rec['provinceID'] ?>">
                                            <label id="provinceID-error" class="error" for="provinceID">กรุณาเลือก จังหวัด</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>เขต/อำเภอ</b>
                                        <div class="form-group form-float">
                                            <select name="districtID" id="districtID" class="form-control show-tick" data-live-search="true" onchange="get_area(this.value,'subDistrictID','hdfDistrictID',2);"<?php echo $_SESSION["userType"] == "2" ? 'disabled' : '';?>>
                                             <option value="">เลือก</option>
                                             <?php
                                             $s_d=" SELECT * from setup_district where provinceID ='".$rec['provinceID']."' order by district_name_th asc";
                                             $q_d = $db->query($s_d);
                                             $n_d = $db->db_num_rows($q_d);
                                             while($r_d = $db->db_fetch_array($q_d)){?>
                                                <option value="<?php echo $r_d['districtID'];?>" <?php echo ($rec['districtID']==$r_d['districtID'])?"selected":"";?>><?php echo $r_d['district_name_th'];?></option>
                                            <?php }  ?>
                                        </select>
                                        <input type="hidden" name="hdfDistrictID" id="hdfDistrictID" value="<?php echo $rec['districtID'] ?>">
                                        <label id="districtID-error" class="error" for="districtID">กรุณาเลือก เขต/อำเภอ</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-4">                                   
                                <div class="form-group">
                                    <b>แขวง/ตำบล</b>
                                    <div class="form-group form-float">
                                        <select name="subDistrictID" id="subDistrictID" class="form-control show-tick" data-live-search="true" onchange="get_zipcode(this.value,'zipcode','hdfSubDistrictID');"
                                        <?php echo $_SESSION["userType"] == "2" ? 'disabled' : '';?>>
                                        <option value="">เลือก</option>
                                        <?php
                                        $s_s=" SELECT * from setup_subDistrict where districtID ='".$rec['districtID']."' order by subDistrict_name_th asc";
                                        $q_s = $db->query($s_s);
                                        $n_s = $db->db_num_rows($q_s);
                                        while($r_s = $db->db_fetch_array($q_s)){?>
                                            <option value="<?php echo $r_s['subDistrictID'];?>"  <?php echo ($rec['subDistrictID']==$r_s['subDistrictID'])?"selected":"";?> ><?php echo $r_s['subDistrict_name_th'];?></option>

                                        <?php }  ?>
                                    </select>
                                    <input type="hidden" name="hdfSubDistrictID" id="hdfSubDistrictID" value="<?php echo $rec['subDistrictID'] ?>">
                                    <label id="subDistrictID-error" class="error" for="subDistrictID">กรุณาเลือก แขวง/ตำบล</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <b>รหัสไปรษณีย์</b>
                                <div class="form-line">
                                 <input type="text" class="form-control" name="zipcode" id="zipcode"  value="<?php echo $rec['zipcode'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                             </div>
                             <label id="zipcode_error" class="error" for="zipcode">กรุณาระบุ รหัสไปรษณีย์</label>
                         </div>
                     </div>
                 </div>
                 <h2 class="card-inside-title">พนักงานที่ติดต่อ</h2><hr />
                 <div class="row clearfix">
                    <div class="col-sm-4">
                      <b>ชื่อพนักงานที่ติดต่อ</b>
                      <div class="form-group">
                        <div class="form-line">
                            <input type="text" oninput="this.value=this.value.replace(/[^\u0E00-\u0E7Fa-zA-Z']/g,'');" name="namesale" id="namesale" class="form-control" placeholder="ชื่อ" value="<?php echo $rec['namesale'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                        </div>
                        <label id="namesale_error" class="error" for="namesale">กรุณาระบุ ชื่อพนักงาน</label>
                    </div>
                </div>
                <div class="col-sm-4">
                  <b>นามสกุล</b>
                  <div class="form-group">
                    <div class="form-line">
                        <input type="text" oninput="this.value=this.value.replace(/[^\u0E00-\u0E7Fa-zA-Z']/g,'');" name="lastnamesale" id="lastnamesale" class="form-control" placeholder="นามสกุล" value="<?php echo $rec['lastnamesale'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                    </div>
                    <label id="lastnamesale_error" class="error" for="lastnamesale">กรุณาระบุ นามสกุลพนักงาน</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <b>เบอร์โทรศัพท์มือถือ</b>
                    <div class="form-line">
                        <input type="text" id="mobilesale" onchange="isPhoneNo(this,2);return false;" name="mobilesale" class="form-control mobile" placeholder="Ex: 080-000-0000" value="<?php echo $rec['mobilesale'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                    </div>
                    <div class="help-info">กรอกได้เฉพาะตัวเลข10ตัวอักษร</div>
                    <label id="mobilesale_error" class="error" for="mobilesale">กรุณาระบุ เบอร์โทรศัพท์มือถือพนักงาน</label>
                    <label id="mobilesale_error2" class="error" for="mobilesale">รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง</label>
                </div>
            </div>
        </div> 
          <!--                                         
                <div class="col-md-4">
                    <div class="form-group">
                        <b>อีเมล</b>
                        <div class="form-line">
                            <input type="email" id="sup_email" name="sup_email" class="form-control email" placeholder="Ex: example@example.com" value="<?php echo $rec['sup_email'];?>">
                        </div>
                        <label id="sup_email_error" class="error" for="sup_email">กรุณาระบุ</label>
                    </div>
                </div>-->
                <div class="row clearfix">  
                    <div class="col-md-4">
                        <div class="form-group">
                            <b>ID Line</b>
                            <div class="form-line">
                                <input type="text" id="idline" name="idline" class="form-control" placeholder="" value="<?php echo $rec['idline'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                            </div>
                            <label id="idline_error" class="error" for="idline">กรุณาระบุ ID Line</label>
                        </div>
                    </div> 
                </div> 
                <h2 class="card-inside-title">สถานะ</h2><hr />
                <div class="row clearfix"> 
                    <div class="col-md-4">
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
                                <!--   <div class="row clearfix">                               
                                <div class="col-md-12">
                                <div class="form-group">
                                <b>หมายเหตุ</b>
                                <div class="form-line">
                                <textarea rows="1" id="note" name="note" class="form-control no-resize auto-growth"><?php echo $rec['note'];?></textarea>
                                </div>
                                </div>
                                </div>
                            </div> -->
                            <div class="align-center">
                                <button class="btn btn-success waves-effect" type="button" onclick="chkinput();">บันทึก</button>
                                <button class="btn btn-default waves-effect" type="button" onclick="OnCancel();">ยกเลิก</button>
                            </div>
                        </form>
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

    $(document).ready(function() {
        //$('.idcard').inputmask('9-9999-99999-99-9', { placeholder: '_-____-_____-__-_' });
        $('.mobile').inputmask('999-999-9999', { placeholder: '___-___-____' });
        $('.tel').inputmask('99-999-9999', { placeholder: '__-___-____' });
        $('.form-line').removeClass('focused');
        //$('.focused').removeClass('focused');
        $('.error').hide();

        if($('#proc').val()=='add'){
          var supCode ='';
          $.ajaxSetup({async: false});
          $.post('process/get_process.php',{proc:'get_supCode'},function(data){
             userName =  data['name'];
         },'json');
          $('#supCode').val(userName);
      }

        // $('.datepickers').bootstrapMaterialDatePicker();
    });

    function OnCancel(){
        $(location).attr('href',"<?php echo  $form_page?>");
    }

    function chkinput(){

        if($('#sup_name').val()==''){
            $('#sup_name_error').show();
            $('#sup_name').focus();
            return false;
        }else{
            $('#sup_name_error').hide();
        }

        if($('#chksup').val()==1){
            $('#sup_name2_error').show();
            $('#sup_name').focus();
            return false;
        }else{
            $('#sup_name2_error').hide();
        }

        if($('#sup_tel').val()==''){
            $('#sup_tel_error').show();
            $('#sup_tel').focus();
            return false;
        }else{
            $('#sup_tel_error').hide();
        }

        if($("#sup_tel").val().replace(/[^0-9\.]/g,'').length < 9){
            $('#sup_tel_error2').show();
            $('#sup_tel').focus();
            return false;
        }else{
            $('#sup_tel_error2').hide();
        }

        if($('#sup_address').val()==''){
            $('#sup_address_error').show();
            $('#sup_address').focus();
            return false;
        }else{
            $('#sup_address_error').hide();
        }

        if($('#provinceID').val()==0){
            $('#provinceID-error').show();
            $('#provinceID').focus();
            return false;
        }else{
            $('#provinceID-error').hide();
        }

        if($('#districtID').val()==0){
            $('#districtID-error').show();
            $('#districtID').focus();
            return false;
        }else{
            $('#districtID-error').hide();
        }

        if($('#subDistrictID').val()==0){
            $('#subDistrictID-error').show();
            $('#subDistrictID').focus();
            return false;
        }else{
            $('#subDistrictID-error').hide();
        }
        if($('#zipcode').val()==''){
            $('#zipcode_error').show();
            $('#zipcode').focus();
            return false;
        }else{
            $('#zipcode-error').hide();
        }

        if($('#namesale').val()==''){
            $('#namesale_error').show();
            $('#namesale').focus();
            return false;
        }else{
            $('#namesale_error').hide();
        }

        if($('#lastnamesale').val()==''){
            $('#lastnamesale_error').show();
            $('#lastnamesale').focus();
            return false;
        }else{
            $('#lastnamesale_error').hide();
        }

        if($('#mobilesale').val()==''){
            $('#mobilesale_error').show();
            $('#mobilesale').focus();
            return false;
        }else{
            $('#mobilesale_error').hide();
        }

        if($("#mobilesale").val().replace(/[^0-9\.]/g,'').length < 10){
            $('#mobilesale_error2').show();
            $('#mobilesale').focus();
            return false;
        }else{
            $('#mobilesale_error2').hide();
        }

        if($('#idline').val()==''){
            $('#idline_error').show();
            $('#idline').focus();
            return false;
        }else{
            $('#idline_error').hide();
        }

        if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
          $("#frm-input").submit();
      }
  }

  function get_area(parent_id,id,hdf_id,type){
    var html  = '<option value="">เลือก</option>';
    $.ajaxSetup({async: false});
    $.post('process/get_process.php',{proc:'get_area',parent_id:parent_id,type:type},function(data){

      $.each(data,function(index,value){
          html += "<option value='"+value['DATA_VALUE']+"'>"+value['DATA_NAME']+"</option>";
      });
      if(+hdf_id != 0){
        $('#'+hdf_id).val(parent_id);
    }
    $('#'+id).html(html);
    $('#'+id).selectpicker('refresh');

},'json');
}
function get_zipcode(parent_id,id,hdf_id){
    var html  = '';
    $.ajaxSetup({async: false});
    $.post('process/get_process.php',{proc:'get_zipcode',parent_id:parent_id},function(data){

      $.each(data,function(index,value){
          html += value['zipcode'];
      });
      if(+hdf_id != 0){
          $('#'+hdf_id).val(parent_id);
      } 
      $('#'+id).val(html);

  },'json');
}

function delData(parent_id,id,hdf_id){
  var supID = $('#supID').val();
  $.ajaxSetup({async: false});
  $.post('process/get_process.php',{proc:'chkDelData_Supplier',supID:supID},function(data){
      if(data > 0){
        alert('ไม่สามารถยกเลิกข้อมูลได้ เนื่องจากบริษัทคู่ค้านี้มีการใช้ข้อมูลนี้อยู่');
        $('#'+parent_id).val(1);
        return false;
    }else{
        $('#'+hdf_id).val(id);
    }
},'json');

}

function chk_sup(){
    var html  = 1;
    var sup_name= $('#sup_name').val();
    // sup_name = sup_name.replace(/ /g, "");
    var supID= $('#supID').val();
    $.ajaxSetup({async: false});
    $.post('process/get_process.php',{proc:'chk_sup',sup_name:sup_name,supID:supID},function(data){
        if(data==1){
           $('#sup_name2_error').show();
           $('#chksup').val(1);
       }else{
           $('#sup_name2_error').hide();
           $('#chksup').val(0);

       }
        //alert(data);
           //$('#chkuser').val()


       },'json');
}

function isPhoneNo(input,type){
    debugger
    var res = input.value.replace(/-/g, "");
    if (type == 1) {
        var regExp = /^02([0-9]{7})$/i;
        if (!regExp.test(res)) {
            $('#sup_tel_error2').show();
            $('#sup_tel').focus();
            return false;
        }
        else{
            $('#sup_tel_error2').hide();
        }
    }else{
        var regExp = /^0([0-9]{1})([0-9]{8})$/i;
        if (!regExp.test(res)) {
            $('#mobilesale_error2').show();
            $('#mobilesale').focus();
            return false;
        }else{
            $('#mobilesale_error2').hide();
        }
    }
}
</script>
