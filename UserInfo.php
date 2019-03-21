<!DOCTYPE html>
<html>
<?php
$path = "../";
include($path."include/config_header_top.php");
 include 'css.php';
 $page_key ='1_1';
 $form_page = $form_page;

 $sql     = " SELECT *
            FROM tb_user
            where userID ='".$userID."' ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$rec = $db->db_fetch_array($query);
$proc = ($proc=='')?"add":$proc;
$txt =  ($proc=='add')?"เพิ่ม":"แก้ไข";
if($proc=='edit'){
    $userType =$rec['userType'];
}else{
    $userType =2;
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
                            <h2><?php echo $txt;?>ข้อมูลพนักงาน</h2>
                        </div>
                         <form id="frm-input" method="post" enctype="multipart/form-data" action="process/profile_process.php" >
                                <input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>">
                                <input type="hidden" id="userID" name="userID" value="<?php echo $userID;?>">
                                <input type="hidden" id="form_page" name="form_page" value="<?php echo  $form_page?>">
                                <input type="hidden" id="chkuser" name="chkuser" value="0">
                                <input type="hidden" id="userType" name="userType" value="<?php echo $userType;?>">

                            <div class="body">
                                <div class="row clearfix">
                                   <div class="col-sm-4">
                                          <b>รหัส <span style="color:red"> *</span></b>
                                         <div class="form-group">
                                            <div class="form-line">
                                                <input type="text " name="userCode" id="userCode" class="form-control" value="<?php echo $rec['userCode'];?>" <?php echo $readonly; ?> >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                          <b>ชื่อ <span style="color:red"> *</span></b>
                                         <div class="form-group">
                                            <div class="form-line">
                                                <input type="text " name="firstname" id="firstname" class="form-control" placeholder="ชื่อ" value="<?php echo $rec['firstname'];?>" <?php echo $proc == "edit" ? $readonly : '';?>>
                                            </div>
                                            <label id="firstname-error" class="error" for="firstname">กรุณาระบุ</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                          <b>นามสกุล <span style="color:red"> *</span></b>
                                         <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="นามสกุล" value="<?php echo $rec['lastname'];?>" <?php echo $proc == "edit" ? $readonly : '';?>>
                                            </div>
                                            <label id="lastname-error" class="error" for="lastname">กรุณาระบุ</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                         <b>วันเดือนปี เกิด <span style="color:red"> *</span></b>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" name="birthday" id="birthday" placeholder="DD/MM/YYYY" value="<?php echo conv_date($rec['birthday']);?>" <?php echo $proc == "edit" ? $readonly : '';?>>
                                            </div>
                                             <label id="birthday-error" class="error" for="birthday">กรุณาระบุ</label>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <b>หมายเลขบัตรประชาชน <span style="color:red"> *</span></b>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control idcard" placeholder="9-9999-99999-99-9"  name="idcard" id="idcard"  value="<?php echo $rec['idcard'];?>" <?php echo $proc == "edit" ? $readonly : '';?>>
                                            </div>
                                            <label id="idcard-error" class="error" for="idcard">กรุณาระบุ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <b>เบอร์โทรศัพท์ <span style="color:red"> *</span></b>
                                        <div class="input-group">
                                          <div class="form-line">
                                            <input type="text" class="form-control mobile" placeholder="Ex: 080-000-0000"  name="mobile" id="mobile"  value="<?php echo $rec['mobile'];?>">
                                          </div>
                                          <label id="mobile-error" class="error" for="mobile">กรุณาระบุ</label>
                                        </div>
                                      </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-md-4">
                                        <b>อีเมล</b>
                                        <div class="input-group">
                                          <div class="form-line">
                                            <input type="text" class="form-control email" placeholder="Ex: example@example.com" name="email" id="email"  value="<?php echo $rec['email'];?>">
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                       <b>ที่อยู่ตามบัตรประชาชน <span style="color:red"> *</span></b>
                                       <div class="form-group">
                                         <div class="form-line">
                                            <input type="text" class="form-control " placeholder=""  name="address" id="address"  value="<?php echo $rec['address'];?>" <?php echo $proc == "edit" ? $readonly : '';?>>
                                          </div>
                                          <label id="address-error" class="error" for="address">กรุณาระบุ</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>จังหวัด <span style="color:red"> *</span></b>
                                        <div class="form-group form-float">
                                            <select name="provinceID" id="provinceID" class="form-control show-tick" data-live-search="true"  onchange="get_area(this.value,'districtID','hdfProvinceID',1);" <?php echo $proc == "edit" ? 'disabled' : '';?>>
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
                                            <label id="provinceID-error" class="error" for="provinceID">กรุณาเลือก</label>
                                          </div>
                                        </div>
                                </div>
                                <div class="row clearfix"><div class="col-sm-4">
                                       <b>อำเภอ/เขต <span style="color:red"> *</span></b>
                                       <div class="form-group form-float">
                                        <select name="districtID" id="districtID" class="form-control show-tick" data-live-search="true" onchange="get_area(this.value,'subDistrictID','hdfDistrictID',2);" <?php echo $proc == "edit" ? 'disabled' : '';?>>
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
                                      <label id="districtID-error" class="error" for="districtID">กรุณาเลือก</label>
                                    </div>
                                  </div>
                                    <div class="col-sm-4">
                                       <b>ตำบล/แขวง <span style="color:red"> *</span></b>
                                        <div class="form-group form-float">
                                            <select name="subDistrictID" id="subDistrictID" class="form-control show-tick" data-live-search="true" onchange="get_zipcode(this.value,'zipcode','hdfSubDistrictID');" <?php echo $proc == "edit" ? 'disabled' : '';?>>
                                                     <option value="">เลือก</option>
                                            <?php
                                                $s_s=" SELECT * from setup_subDistrict where districtID ='".$rec['districtID']."' order by subDistrict_name_th asc";
                                                $q_s = $db->query($s_s);
                                                $n_s = $db->db_num_rows($q_s);
                                               while($r_s = $db->db_fetch_array($q_s)){?>
                                                <option value="<?php echo $r_s['subDistrictID'];?>"  <?php echo ($rec['districtID']==$r_s['districtID'])?"selected":"";?> ><?php echo $r_s['subDistrict_name_th'];?></option>
                                              <?php }  ?>
                                            </select>
                                            <input type="hidden" name="hdfSubDistrictID" id="hdfSubDistrictID" value="<?php echo $rec['subDistrictID'] ?>">
                                            <label id="subDistrictID-error" class="error" for="subDistrictID">กรุณาเลือก</label>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                         <b>รหัสไปรษณีย์ <span style="color:red"> *</span></b>
                                         <div class="form-group">
                                          <div class="form-line">
                                            <input type="text" class="form-control " placeholder=""  name="zipcode" id="zipcode"  value="<?php echo $rec['zipcode'];?>" <?php echo $proc == "edit" ? $readonly : '';?>>
                                          </div>
                                        </div>
                                        <label id="zipcode-error" class="error" for="zipcode">กรุณาระบุ</label>
                                      </div>
                                  </div>
                                  <div class="row clearfix">
                                   <div class="col-md-4">
                                     <div class="form-group">
                                       <input type="checkbox" id="adsIDCard" class="filled-in" onclick="get_address();" />
                                       <label for="adsIDCard"><b>ที่อยู่ปัจจุบันตามบัตรประชาชน </b></label>
                                     </div>
                                   </div>
                                   <div class="col-md-4">
                                     <b>ที่อยู่ปัจจุบัน <span style="color:red"> *</span></b>
                                     <div class="form-group">
                                       <div class="form-line">
                                        <input type="text" class="form-control " placeholder=""  name="addressIDCard" id="addressIDCard"  value="<?php echo $rec['addressIDCard'];?>">
                                      </div>
                                      <label id="addressIDCard-error" class="error" for="addressIDCard">กรุณาระบุ</label>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <b>จังหวัด <span style="color:red"> *</span></b>
                                    <div class="form-group form-float">
                                      <select name="provinceIDCard" id="provinceIDCard" class="form-control" data-live-search="true"  onchange="get_area(this.value,'districtIDCard',0,1);">
                                        <option value="">เลือก</option>
                                        <?php
                                        $s_p=" SELECT * from setup_prov order by province_name_th asc";
                                        $q_p = $db->query($s_p);
                                        $n_p = $db->db_num_rows($q_p);
                                        while($r_p = $db->db_fetch_array($q_p)){?>
                                          <option value="<?php echo $r_p['provinceID'];?>"  <?php echo ($rec['provinceIDCard']==$r_p['provinceID'])?"selected":"";?>> <?php echo $r_p['province_name_th'];?></option>
                                        <?php }  ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                     <div class="col-sm-4">
                                       <b>อำเภอ/เขต <span style="color:red"> *</span></b>
                                        <div class="form-group form-float">
                                            <select name="districtIDCard" id="districtIDCard" class="form-control show-tick" data-live-search="true" onchange="get_area(this.value,'subDistrictIDCard',0,2);">
                                                   <option value="">เลือก</option>
                                            <?php
                                                $s_d=" SELECT * from setup_district where provinceID ='".$rec['provinceIDCard']."' order by district_name_th asc";
                                                $q_d = $db->query($s_d);
                                                $n_d = $db->db_num_rows($q_d);
                                               while($r_d = $db->db_fetch_array($q_d)){?>
                                                <option value="<?php echo $r_d['districtID'];?>" <?php echo ($rec['districtIDCard']==$r_d['districtID'])?"selected":"";?>><?php echo $r_d['district_name_th'];?></option>

                                            <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <b>ตำบล/แขวง <span style="color:red"> *</span></b>
                                        <div class="form-group form-float">
                                            <select name="subDistrictIDCard" id="subDistrictIDCard" class="form-control show-tick" data-live-search="true" onchange="get_zipcode(this.value,'zipcodeIDCard',0);">
                                                     <option value="">เลือก</option>
                                            <?php
                                                $s_s=" SELECT * from setup_subDistrict where districtID ='".$rec['districtIDCard']."' order by subDistrict_name_th asc";
                                                $q_s = $db->query($s_s);
                                                $n_s = $db->db_num_rows($q_s);
                                               while($r_s = $db->db_fetch_array($q_s)){?>
                                                <option value="<?php echo $r_s['subDistrictID'];?>"  <?php echo ($rec['districtIDCard']==$r_s['districtID'])?"selected":"";?> ><?php echo $r_s['subDistrict_name_th'];?></option>

                                            <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                         <b>รหัสไปรษณีย์ <span style="color:red"> *</span></b>
                                       <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control " placeholder=""  name="zipcodeIDCard" id="zipcodeIDCard"  value="<?php echo $rec['zipcodeIDCard'];?>">
                                        </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row clearfix">
                                    <div class="col-md-4">
                                        <b>ชื่อบุคคลอ้างอิง <span style="color:red"> *</span></b>
                                         <div class="form-group">
                                            <div class="form-line">
                                                <input type="text " name="firstnameref" id="firstnameref" class="form-control" placeholder="ชื่อ" value="<?php echo $rec['firstnameref'];?>" <?php echo $proc == "edit" ? $readonly : '';?>>
                                            </div>
                                            <label id="firstnameref-error" class="error" for="firstnameref">กรุณาระบุ</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                          <b>นามสกุล <span style="color:red"> *</span></b>
                                         <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="lastnameref" id="lastnameref" class="form-control" placeholder="นามสกุล" value="<?php echo $rec['lastnameref'];?>" <?php echo $proc == "edit" ? $readonly : '';?>>
                                            </div>
                                            <label id="lastnameref-error" class="error" for="lastnameref">กรุณาระบุ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <b>เบอร์โทรศัพท์ <span style="color:red"> *</span></b>
                                        <div class="input-group">
                                          <div class="form-line">
                                            <input type="text" class="form-control mobile" placeholder="Ex: 080-000-0000"  name="mobileref" id="mobileref"  value="<?php echo $rec['mobileref'];?>" <?php echo $proc == "edit" ? $readonly : '';?>>
                                          </div>
                                          <label id="mobileref-error" class="error" for="lastnameref">กรุณาระบุ</label>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="row clearfix">
                                    <div class="col-md-4">
                                     <b>รูปภาพ</b>
                                     <div class="form-group">
                                      <div class="form-line">
                                        <input type="file" class="form-control " placeholder=""  name="img" id="img" accept="image/x-png, image/gif, image/jpeg" value="">
                                        <input type="hidden" name="old_file" id="old_file" value="<?php echo $rec['img'];?>" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-4" style="display: <?php echo ($_SESSION['userType'] == 1 ? 'block' : 'none');?>">
                                    <b>สถานะการทำงาน</b>
                                    <div class="form-group">
                                      <input type="radio" value="1" name="userStatus" id="userStatus1" class="with-gap" <?php echo ($rec['userStatus']==1)?"checked":"";?>>
                                      <label for="userStatus1">ปกติ</label>
                                      <input type="radio" value="2" name="userStatus" id="userStatus2" class="with-gap" <?php echo ($rec['userStatus']==2)?"checked":"";?>>
                                      <label for="userStatus2" class="m-l-20">ระงับการใช้งาน</label>
                                      <input type="radio" value="3" name="userStatus" id="userStatus3" class="with-gap" <?php echo ($rec['userStatus']==3)?"checked":"";?>>
                                      <label for="userStatus3" class="m-l-20">ลาออก</label>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <b>สถานะการเข้าใช้งานระบบ</b>
                                    <div class="form-group">
                                      <input type="radio" value="1" name="activeStatus" id="activeStatus1" class="with-gap" <?php echo ($rec['activeStatus']==1)?"checked":"";?>>
                                      <label for="activeStatus1">ใช้งาน</label>
                                      <input type="radio" value="0" name="activeStatus" id="activeStatus0" class="with-gap"  <?php echo ($rec['activeStatus']==0)?"checked":"";?>>
                                      <label for="activeStatus0" class="m-l-20">ไม่ใช้งาน</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="header" name="userPass">
                                  <h2>User & Password</h2>
                                </div>
                                <div class="row clearfix" name="userPass">
                                  <div class="col-md-4">
                                    <b>Username <span style="color:red"> *</span></b>
                                    <div class="input-group">
                                      <span class="input-group-addon">
                                        <i class="material-icons">person</i>
                                      </span>
                                      <div class="form-line">
                                        <input type="text" <?php echo $readonly;?>  name="username" id="username" class="form-control" placeholder="Username" value="<?php echo $rec['username'];?>" onkeyup="chk_user();">
                                      </div>
                                      <label id="username-error" class="error" for="username">กรุณาระบุชื่อผู้ใช้งาน</label>
                                      <label id="username2-error" class="error" for="username">มีผู้ใช้งานนี้แล้ว</label>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                   <b>Password <span style="color:red"> *</span></b>
                                   <div class="input-group">
                                    <span class="input-group-addon">
                                      <i class="material-icons">vpn_key</i>
                                    </span>
                                    <div class="form-line " >
                                      <input type="password" name="password1" id="password1" class="form-control" placeholder="Password" value="<?php echo $rec['password'];?>" maxlength="6">
                                    </div>
                                    <label id="password1-error" class="error" for="password1" style="display: <?php echo ($_SESSION['userType'] == 1 ? 'none' : 'block');?>">ยืนยัน password ให้ตรงกัน</label>
                                  </div>
                                </div>
                                <div id="divpass2" class="col-sm-4" style="display: <?php echo ($_SESSION['userType'] == 1 ? 'none' : 'block');?>">
                                 <b>ยืนยัน Password <span style="color:red"> *</span></b>
                                 <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="material-icons">vpn_key</i>
                                  </span>
                                  <div class="form-line " >
                                    <input type="password" name="password2" id="password2" class="form-control" placeholder="ยืนยัน Password" value="<?php echo $rec['password'];?>" maxlength="6">
                                  </div>
                                  <label id="password2-error" class="error" for="password2">ยืนยัน password ให้ตรงกัน</label>
                                </div>
                              </div>
                            </div>
                               <!-- <div class="row clearfix">
                                   <div class="col-sm-6">
                                      <b>สถานะการใช้งาน</b>
                                   <div class="form-group">
                                        <input type="radio" value="1" name="activeStatus" id="activeStatus1" class="with-gap" <?php echo ($rec['activeStatus']==1)?"checked":"";?>>
                                        <label for="activeStatus1">ใช้งาน</label>
                                        <input type="radio" value="0" name="activeStatus" id="activeStatus0" class="with-gap"  <?php echo ($rec['activeStatus']==0)?"checked":"";?>>
                                        <label for="activeStatus0" class="m-l-20">ไม่ใช้งาน</label>
                                    </div>

                                    </div>
                                  
                                </div> -->

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


  if($('#firstname').val()==''){
    $('#firstname-error').show();
    return false;
  }else{
    $('#firstname-error').hide();
  }

  if($('#lastname').val()==''){
    $('#lastname-error').show();
    return false;
  }else{
    $('#lastname-error').hide();
  }

  if($('#birthday').val()==''){
    $('#birthday-error').show();
    return false;
  }else{
    $('#birthday-error').hide();
  }

  if($('#idcard').val()==''){
    $('#idcard-error').show();
    return false;
  }else{
    $('#idcard-error').hide();
  }

  if($('#mobile').val()==''){
    $('#mobile-error').show();
    return false;
  }else{
    $('#mobile-error').hide();
  }

  if($('#address').val()==''){
    $('#address-error').show();
    return false;
  }else{
    $('#address-error').hide();
  }

  if($('#provinceID').val()==0){
    $('#provinceID-error').show();
    return false;
  }else{
    $('#provinceID-error').hide();
  }

  if($('#districtID').val()==0){
    $('#districtID-error').show();
    return false;
  }else{
    $('#districtID-error').hide();
  }

  if($('#subDistrictID').val()==0){
    $('#subDistrictID-error').show();
    return false;
  }else{
    $('#subDistrictID-error').hide();
  }

  if($('#zipcode').val()==''){
    $('#zipcode-error').show();
    return false;
  }else{
    $('#zipcode-error').hide();
  }

  if($('#addressIDCard').val()==''){
    $('#addressIDCard-error').show();
    return false;
  }else{
    $('#addressIDCard-error').hide();
  }

  if($('#provinceIDCard').val()==0){
    $('#provinceIDCard-error').show();
    return false;
  }else{
    $('#provinceIDCard-error').hide();
  }

  if($('#districtIDCard').val()==0){
    $('#districtIDCard-error').show();
    return false;
  }else{
    $('#districtIDCard-error').hide();
  }

  if($('#subDistrictIDCard').val()==0){
    $('#subDistrictIDCard-error').show();
    return false;
  }else{
    $('#subDistrictIDCard-error').hide();
  }

  if($('#zipcode').val()==''){
    $('#zipcode-error').show();
    return false;
  }else{
    $('#zipcode-error').hide();
  }

  if($('#firstnameref').val()==''){
    $('#firstnameref-error').show();
    return false;
  }else{
    $('#firstnameref-error').hide();
  }

  if($('#lastnameref ').val()==''){
    $('#lastnameref-error').show();
    return false;
  }else{
    $('#lastnameref-error').hide();
  }

  if($('#mobileref').val()==''){
    $('#mobileref-error').show();
    return false;
  }else{
    $('#mobileref-error').hide();
  }

  if($('#Username').val()==''){
    $('#Username-error').show();
    return false;
  }else{
    $('#Username-error').hide();
  }

  if($('#chkuser').val()==1){
    $('#username2-error').show();
    return false;
  }else{
    $('#username2-error').hide();
  }

  if($('#divpass2').is(':visible')){
    if($('#password1').val() != $('#password2').val()){

      $('#password1-error').show();
      $('#password2-error').show();
      return false;
    }else{
      $('#password1-error').hide();
      $('#password2-error').hide();
    }
  }

  if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
    $("#frm-input").submit();
  }
}

$(document).ready(function() {
        $('.idcard').inputmask('9-9999-99999-99-9', { placeholder: '_-____-_____-__-_' });
        $('.mobile').inputmask('999-999-9999', { placeholder: '___-___-____' });
        //$('.form-line').removeClass('focused');
        //$('.focused').removeClass('focused');
        $('.error').hide();
        $('#password1').val('123456');
        // $('#activeStatus0').prop("checked", false);
        

        if($('#proc').val()=='add'){
          $('#activeStatus1').prop("checked", true);
          $('#userStatus1').prop("checked", true);
          var userName ='';
          $.ajaxSetup({async: false});
          $.post('process/get_process.php',{proc:'get_username'},function(data){
           userName =  data['name'];
         },'json');
          $('#username').val(userName);
          $('#userCode').val(userName);
        }

        // $('.datepickers').bootstrapMaterialDatePicker();
});
function get_address(){
  // console.log('getaddress');
  if($('#adsIDCard').is(':checked')) {
    let province_id = $('#hdfProvinceID').val();
    let district_id = $('#hdfDistrictID').val();
    let subdistrict_id = $('#hdfSubDistrictID').val();

    // console.log(province_id,district_id,subdistrict_id);
    
    // $('#provinceIDCard option[value='+$("#provinceIDCard").val()+']').removeAttr('selected','selected');

    $("#provinceIDCard option:selected").removeAttr('selected');
    $("#districtIDCard option:selected").removeAttr('selected');
    $("#subDistrictIDCard option:selected").removeAttr('selected');

    // $('#districtIDCard option[value='+0+']').removeAttr('selected','selected');
    // $('#subDistrictIDCard option[value='+0+']').removeAttr('selected','selected');

    get_area(province_id,'districtIDCard','0',1);
    get_area(district_id,'subDistrictIDCard','0',2);

    // $('#provinceIDCard select').val(province_id);
    // $('#districtIDCard').val(district_id);
    // $("#districtIDCard select").val(district_id);

    $("#provinceIDCard option:selected").removeAttr('selected');
    $("#districtIDCard option:selected").removeAttr('selected');
    $("#subDistrictIDCard option:selected").removeAttr('selected');

    $("#provinceIDCard").val(province_id);
    $("#districtIDCard").val(district_id);
    $("#subDistrictIDCard").val(subdistrict_id);

    // get_zipcode(district_id,'zipcode','0');
    let p_name = $("#provinceIDCard option:selected").text();
    let d_name = $("#districtIDCard option:selected").text();
    let sd_name = $("#subDistrictIDCard option:selected").text();

    $('[data-id="provinceIDCard"]').find("span.filter-option").text(p_name);
    $('[data-id="districtIDCard"]').find("span.filter-option").text(d_name);
    $('[data-id="subDistrictIDCard"]').find("span.filter-option").text(sd_name);

    // $('#addressIDCard').val($('#address').val());


    //$('#provinceIDCard').clone().appendTo($('#provinceID'));

    // $('#provinceID').clone().appendTo($('#provinceIDCard'));


    // $("#provinceIDCard").val($("#hdfProvinceID").val());

    //$("#provinceID").prop('selectedIndex')
    //$('#provinceIDCard').index($('#provinceID').select());


    // $('#zipcodeIDCard').val($('#zipcode').val());

  }else{
    $('#addressIDCard').val("");
    $('#provinceIDCard').val(0);
    $('#zipcodeIDCard').val("");
  }
}

function get_area(parent_id,id,hdf_id,type){
// function get_area(parent_id,id,type){
  console.log(parent_id,id,type);
    var html  = '<option value="">เลือก</option>';
     $.post('process/get_process.php',{proc:'get_area',parent_id:parent_id,type:type},function(data){

              $.each(data,function(index,value){
                  html += "<option value='"+value['DATA_VALUE']+"'>"+value['DATA_NAME']+"</option>";
              });

      if(+hdf_id != 0){
        $('#'+hdf_id).val(parent_id);
      }        
        // $('#'+hdf_id).val(parent_id);
        $('#'+id).html(html);
        $('#'+id).selectpicker('refresh');

    },'json');
}
function get_zipcode(parent_id,id,hdf_id){
  // console.log(parent_id,hdf_id);
    var html  = '';
     $.post('process/get_process.php',{proc:'get_zipcode',parent_id:parent_id},function(data){

      $.each(data,function(index,value){
        html += value['zipcode'];
      });
    if(+hdf_id != 0){
      $('#'+hdf_id).val(parent_id);
    } 
      // $('#'+hdf_id).val(parent_id);
      $('#'+id).val(html);

    },'json');
}
function chk_user(){

    var html  = 1;
    var username= $('#username').val();
    var userID= $('#userID').val();
     $.post('process/get_process.php',{proc:'chk_user',username:username,userID:userID},function(data){
        if(data==1){
             $('#username2-error').show();
             $('#chkuser').val(1);
        }else{
             $('#username2-error').hide();
             $('#chkuser').val(0);

        }
        //alert(data);
           //$('#chkuser').val()


    },'json');
}

$("input[name*='userStatus']").change(function(){
  if ($(this).val() != 1) {
    $('#activeStatus0').prop("checked", true);
    $('#activeStatus1').attr("disabled", true);
    $('div[name="userPass"]').hide();
  }else{
    $('#activeStatus1').prop("checked", true);
    $('#activeStatus1').removeAttr("disabled");
    $('div[name="userPass"]').show();

  }
});

$("input[name*='activeStatus']").change(function(){
  if ($(this).val() != 1) {
    $('div[name="userPass"]').hide();
  }else{
    $('div[name="userPass"]').show();
  }
});


//username2
</script>
