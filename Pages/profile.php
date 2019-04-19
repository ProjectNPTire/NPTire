<!DOCTYPE html>
<html>
<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$sql     = " SELECT *
FROM tb_user
where userID ='".$_SESSION["sys_id"]."' ";

$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$rec = $db->db_fetch_array($query);
$proc = 'edit';
if($proc=='edit'){
    $userType =$rec['userType'];
}else{
    $userType =2;
}
$readonly = "readonly";
?>

<body class="theme-red">
    <?php include 'MasterPage.php'; ?>

    <section class="content">
        <div class="container-fluid">
        	<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ข้อมูลส่วนตัว</h2>
                        </div>

                        <form id="frm-input" method="post" enctype="multipart/form-data" action="process/profile_process.php" >
                            <input type="hidden" id="proc" name="proc" value="edit">
                            <input type="hidden" id="userID" name="userID" value="<?php echo $_SESSION['sys_id'];?>">
                            <input type="hidden" id="form_page" name="form_page" value="profile.php">
                            <input type="hidden" id="activeStatus" name="activeStatus" value="<?php echo $rec[activeStatus];?>">
                            <input type="hidden" id="userType" name="userType" value="<?php echo $rec[userType];?>">

                            <div class="body">
                              <div class="row clearfix">
                                <div class="col-sm-12 align-right"><b><span style="color:red">* กรอกข้อมูลให้ครบทุกช่อง</span></b>
                                </div>
                              </div>
                                <div class="row clearfix">
                                   <div class="col-sm-4">
                                          <b>รหัสพนักงาน</b>
                                         <div class="form-group">
                                            <div class="form-line">
                                                <input type="text " name="userCode" id="userCode" class="form-control" value="<?php echo $rec['userCode'];?>" <?php echo $readonly; ?> >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                          <b>ชื่อ</b>
                                         <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" oninput="this.value=this.value.replace(/[^\u0E00-\u0E7Fa-zA-Z']/g,'');" name="firstname" id="firstname" class="form-control" placeholder="ชื่อ" value="<?php echo $rec['firstname'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                            </div>
                                            <label id="firstname-error" class="error" for="firstname">กรุณาระบุ ชื่อพนักงาน</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                          <b>นามสกุล</b>
                                         <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" oninput="this.value=this.value.replace(/[^\u0E00-\u0E7Fa-zA-Z']/g,'');" name="lastname" id="lastname" class="form-control" placeholder="นามสกุล" value="<?php echo $rec['lastname'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                            </div>
                                            <label id="lastname-error" class="error" for="lastname">กรุณาระบุ นามสกุลพนักงาน</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-4">
                                   <b>วัน/เดือน/ปีเกิด</b>
                                   <div class="input-group">
                                    <div class="form-line">
                                      <input type="text" class="form-control datepicker" name="birthday" id="birthday" placeholder="DD/MM/YYYY" onchange="get_birthday(this.value,'hdfBirthday');" value="<?php echo conv_date($rec['birthday']);?>"<?php echo $_SESSION["userType"] == "2" ? 'disabled' : '';?>>
                                    </div>
                                    <input type="hidden" class="form-control" name="hdfBirthday" id="hdfBirthday" value="<?php echo conv_date($rec['birthday']); ?>">
                                    <label id="birthday-error" class="error" for="birthday">กรุณาระบุ วัน/เดือน/ปีเกิด</label>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <b>หมายเลขบัตรประชาชน</b>
                                  <div class="input-group">
                                    <div class="form-line">
                                      <input type="text" onchange="checkForm();return false;" class="form-control idcard" placeholder="9-9999-99999-99-9"  name="idcard" id="idcard"  value="<?php echo $rec['idcard'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                    </div>
                                    <label id="idcard-error" class="error" for="idcard">กรุณาระบุ เลขบัตรประชาชน</label>
                                    <label id="idcard-error2" class="error" for="idcard">รูปแบบบัตรประชาชนไม่ถูกต้อง</label>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <b>เบอร์โทรศัพท์</b>
                                  <div class="input-group">
                                    <div class="form-line">
                                      <input type="text" class="form-control mobile" placeholder="Ex: 080-000-0000"  name="mobile" id="mobile" onchange="isPhoneNo(this,1);return false;" value="<?php echo $rec['mobile'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                    </div>
                                    <label id="mobile-error" class="error" for="mobile">กรุณาระบุ เบอร์โทรศัพท์พนักงาน</label>
                                    <label id="mobile-error2" class="error" for="mobile">รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง</label>
                                  </div>
                                </div>
                              </div>
                              <h2 class="card-inside-title">ที่อยู่ตามบัตรประชาชน</h2><hr />
                              <div class="row clearfix">
                                    <!-- <div class="col-md-4">
                                        <b>อีเมล</b>
                                        <div class="input-group">
                                          <div class="form-line">
                                            <input type="text" onchange="checkEmail(this);return false;" class="form-control email" placeholder="Ex: example@example.com" name="email" id="email"  value="<?php echo $rec['email'];?>">
                                          </div>
                                          <label id="email-error2" class="error" for="mobile">รูปแบบอีเมลไม่ถูกต้อง</label>
                                        </div>
                                    </div> -->
                                    <div class="col-md-4">
                                       <b>ที่อยู่</b>
                                       <div class="form-group">
                                         <div class="form-line">
                                            <input type="text" class="form-control " placeholder=""  name="address" id="address"  value="<?php echo $rec['address'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                          </div>
                                          <label id="address-error" class="error" for="address">กรุณาระบุ ที่อยู่ตามบัตรประชาชน</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
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
                                            <label id="provinceID-error" class="error" for="provinceID">กรุณาเลือก จังหวัดตามบัตรประชาชน</label>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                       <b>อำเภอ/เขต</b>
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
                                      <label id="districtID-error" class="error" for="districtID">กรุณาเลือก อำเภอ/เขตตามบัตรประชาชน</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                       <b>ตำบล/แขวง</b>
                                        <div class="form-group form-float">
                                            <select name="subDistrictID" id="subDistrictID" class="form-control show-tick" data-live-search="true" onchange="get_zipcode(this.value,'zipcode','hdfSubDistrictID');"<?php echo $_SESSION["userType"] == "2" ? 'disabled' : '';?>>
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
                                            <label id="subDistrictID-error" class="error" for="subDistrictID">กรุณาเลือก ตำบล/แขวงตามบัตรประชาชน</label>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                         <b>รหัสไปรษณีย์</b>
                                         <div class="form-group">
                                          <div class="form-line">
                                            <input type="text" class="form-control " placeholder=""  name="zipcode" id="zipcode"  value="<?php echo $rec['zipcode'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                          </div>
                                        </div>
                                        <label id="zipcode-error" class="error" for="zipcode">กรุณาระบุ รหัสไปรษณีย์ามบัตรประชาชน</label>
                                      </div>
                                  </div>
                                  <h2 class="card-inside-title">ที่อยู่ปัจจุบัน</h2><hr />
                                  <div class="row clearfix">
                                   <div class="col-md-4">
                                     <div class="form-group">
                                       <input type="checkbox" id="adsIDCard" class="filled-in" onclick="get_address();" />
                                       <label for="adsIDCard"><b>ที่อยู่ปัจจุบันตามบัตรประชาชน </b></label>
                                     </div>
                                   </div>
                                   <div class="col-md-4">
                                     <b>ที่อยู่ปัจจุบัน</b>
                                     <div class="form-group">
                                       <div class="form-line">
                                        <input type="text" class="form-control " placeholder=""  name="addressIDCard" id="addressIDCard"  value="<?php echo $rec['addressIDCard'];?>"<?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                      </div>
                                      <label id="addressIDCard-error" class="error" for="addressIDCard">กรุณาระบุ ที่อยู่ปัจจุบัน</label>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <b>จังหวัด</b>
                                    <div class="form-group form-float">
                                      <select name="provinceIDCard" id="provinceIDCard" class="form-control selectPcard" data-live-search="true"  onchange="get_area(this.value,'districtIDCard','hdfProvinceIDCard',1);"<?php echo $_SESSION["userType"] == "2" ? 'disabled' : '';?>>
                                        <option value="">เลือก</option>
                                        <?php
                                        $s_p=" SELECT * from setup_prov order by province_name_th asc";
                                        $q_p = $db->query($s_p);
                                        $n_p = $db->db_num_rows($q_p);
                                        while($r_p = $db->db_fetch_array($q_p)){?>
                                          <option value="<?php echo $r_p['provinceID'];?>"  <?php echo ($rec['provinceIDCard']==$r_p['provinceID'])?"selected":"";?>> <?php echo $r_p['province_name_th'];?></option>
                                        <?php }  ?>
                                      </select>
                                      <input type="hidden" name="hdfProvinceIDCard" id="hdfProvinceIDCard" value="<?php echo $rec['provinceIDCard'] ?>">
                                      <label id="provinceIDCard-error" class="error" for="provinceIDCard">กรุณาเลือก จังหวัดตามที่อยู่ปัจจุบัน</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                     <div class="col-sm-4">
                                       <b>อำเภอ/เขต</b>
                                        <div class="form-group form-float">
                                            <select name="districtIDCard" id="districtIDCard" class="form-control selectPcard show-tick" data-live-search="true" onchange="get_area(this.value,'subDistrictIDCard','hdfDistrictIDCard',2);"<?php echo $_SESSION["userType"] == "2" ? 'disabled' : '';?>>
                                                   <option value="">เลือก</option>
                                            <?php
                                                $s_d=" SELECT * from setup_district where provinceID ='".$rec['provinceIDCard']."' order by district_name_th asc";
                                                $q_d = $db->query($s_d);
                                                $n_d = $db->db_num_rows($q_d);
                                               while($r_d = $db->db_fetch_array($q_d)){?>
                                                <option value="<?php echo $r_d['districtID'];?>" <?php echo ($rec['districtIDCard']==$r_d['districtID'])?"selected":"";?>><?php echo $r_d['district_name_th'];?></option>
                                              <?php }  ?>
                                            </select>
                                            <input type="hidden" name="hdfDistrictIDCard" id="hdfDistrictIDCard" value="<?php echo $rec['districtIDCard'] ?>">
                                            <label id="districtIDCard-error" class="error" for="districtIDCard">กรุณาเลือก อำเภอ/เขตตามที่อยู่ปัจจุบัน</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <b>ตำบล/แขวง</b>
                                        <div class="form-group form-float">
                                            <select name="subDistrictIDCard" id="subDistrictIDCard" class="form-control selectPcard show-tick" data-live-search="true" onchange="get_zipcode(this.value,'zipcodeIDCard','hdfSubDistrictIDCard');"<?php echo $_SESSION["userType"] == "2" ? 'disabled' : '';?>>
                                                     <option value="">เลือก</option>
                                            <?php
                                                $s_s=" SELECT * from setup_subDistrict where districtID ='".$rec['districtIDCard']."' order by subDistrict_name_th asc";
                                                $q_s = $db->query($s_s);
                                                $n_s = $db->db_num_rows($q_s);
                                               while($r_s = $db->db_fetch_array($q_s)){?>
                                                <option value="<?php echo $r_s['subDistrictID'];?>"  <?php echo ($rec['subDistrictIDCard']==$r_s['subDistrictID'])?"selected":"";?> ><?php echo $r_s['subDistrict_name_th'];?></option>
                                            <?php }  ?>
                                            </select>
                                            <input type="hidden" name="hdfSubDistrictIDCard" id="hdfSubDistrictIDCard" value="<?php echo $rec['subDistrictIDCard'] ?>">
                                            <label id="subDistrictIDCard-error" class="error" for="subDistrictIDCard">กรุณาเลือก ตำบล/แขวงตามที่อยู่ปัจจุบัน</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                     <b>รหัสไปรษณีย์</b>
                                     <div class="form-group">
                                      <div class="form-line">
                                        <input type="text" class="form-control "  name="zipcodeIDCard" id="zipcodeIDCard"  value="<?php echo $rec['zipcodeIDCard'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                      </div>
                                      <label id="zipcodeIDCard-error" class="error" for="zipcodeIDCard">กรุณาระบุ รหัสไปรษณีย์ตามที่อยู่ปัจจุบัน</label>
                                    </div>
                                  </div>                         
                                </div>
                                <div id="divref" style="display: <?php echo ($_SESSION['userType'] == 1 ? 'none' : 'block');?>">
                                <h2 class="card-inside-title">บุคคลอ้างอิง</h2><hr />
                                <div class="row clearfix">
                                  <div class="col-md-4">
                                    <b>ชื่อบุคคลอ้างอิง</b>
                                    <div class="form-group">
                                      <div class="form-line">
                                        <input type="text" oninput="this.value=this.value.replace(/[^\u0E00-\u0E7Fa-zA-Z']/g,'');" name="firstnameref" id="firstnameref" class="form-control" placeholder="ชื่อ" value="<?php echo $rec['firstnameref'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                      </div>
                                      <label id="firstnameref-error" class="error" for="firstnameref">กรุณาระบุ ชื่อบุคคลอ้างอิง</label>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <b>นามสกุล</b>
                                    <div class="form-group">
                                      <div class="form-line">
                                        <input type="text" oninput="this.value=this.value.replace(/[^\u0E00-\u0E7Fa-zA-Z']/g,'');" name="lastnameref" id="lastnameref" class="form-control" placeholder="นามสกุล" value="<?php echo $rec['lastnameref'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                      </div>
                                      <label id="lastnameref-error" class="error" for="lastnameref">กรุณาระบุ นามสกุลบุคคลอ้างอิง</label>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <b>เบอร์โทรศัพท์</b>
                                    <div class="input-group">
                                      <div class="form-line">
                                        <input type="text" onchange="isPhoneNo(this,2);return false;" class="form-control mobile" placeholder="Ex: 080-000-0000"  name="mobileref" id="mobileref"  value="<?php echo $rec['mobileref'];?>" <?php echo $_SESSION["userType"] == "2" ? $readonly : '';?>>
                                      </div>
                                      <label id="mobileref-error" class="error" for="lastnameref">กรุณาระบุ เบอร์โทรศัพท์บุคคลอ้างอิง</label>
                                      <label id="mobileref-error2" class="error" for="mobile">รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                                <div class="row clearfix">
                                  <div class="col-md-4">
                                   <b>รูปภาพ</b>
                                     <div class="form-group">
                                      <div class="form-line">
                                        <input type="file" class="form-control " name="img" id="img" accept="image/x-png, image/gif, image/jpeg" value="<?php echo $rec['img'];?>" onchange="ValidateSingleInput(this);" >
                                        <input type="hidden" name="old_file" id="old_file" value="<?php echo $rec['img'];?>" >
                                      </div>
                                      <div class="help-info">อัพโหลดได้เฉพาะไฟล์JPEG,RAW,PSD,GIF,PNG,TIFF</div>
                                      <label id="img-error" class="error" for="img">กรุณาเลือกรูปภาพ</label>
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
                                  <div class="col-sm-4" style="display: <?php echo ($_SESSION['userType'] == 1 ? 'block' : 'none');?>">
                                    <b>สถานะการเข้าใช้งานระบบ</b>
                                    <div class="form-group">
                                      <input type="radio" value="1" name="activeStatus" id="activeStatus1" class="with-gap" <?php echo ($rec['activeStatus']==1)?"checked":"";?>>
                                      <label for="activeStatus1">ใช้งาน</label>
                                      <input type="radio" value="0" name="activeStatus" id="activeStatus0" class="with-gap"  <?php echo ($rec['activeStatus']==0)?"checked":"";?>>
                                      <label for="activeStatus0" class="m-l-20">ไม่ใช้งาน</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group" id="userPass">
                                 <h2 class="card-inside-title">User & Password</h2><hr />
                                <div class="row clearfix">
                                  <div class="col-md-4">
                                    <b>Username</b>
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
                                   <b>Password</b>
                                   <div class="input-group">
                                    <span class="input-group-addon">
                                      <i class="material-icons">vpn_key</i>
                                    </span>
                                    <div class="form-line " >
                                      <input type="password" onchange="chkMinlength(this,1);return false;" maxlength="6" name="password1" id="password1" class="form-control numb" placeholder="Password" value="<?php echo $rec['password'];?>">
                                    </div>
                                    <div class="help-info" <?php echo $_SESSION["userType"] == "1" ? 'hidden' : '';?>>กรอกได้ไม่เกินและไม่ต่ำกว่า6ตัวอักษรและเป็นตัวเลขเท่านั้น</div>
                                    <label id="password1-error2" class="error" for="password1">กรุณาระบุให้ครบ6ตัวอักษร</label>
                                    <label id="password1-error" class="error" for="password1" style="display: <?php echo ($_SESSION['userType'] == 1 ? 'none' : 'block');?>">ยืนยัน password ให้ตรงกัน</label>
                                  </div>
                                </div>
                                <div id="divpass2" class="col-sm-4" style="display: <?php echo ($_SESSION['userType'] == 1 ? 'none' : 'block');?>">
                                 <b>ยืนยัน Password</b>
                                 <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="material-icons">vpn_key</i>
                                  </span>
                                  <div class="form-line " >
                                    <input type="password" onchange="chkMinlength(this,2);return false;" maxlength="6" name="password2" id="password2" class="form-control numb" placeholder="ยืนยัน Password" value="<?php echo $rec['password'];?>">
                                  </div>
                                  <div class="help-info">กรอกได้ไม่เกินและไม่ต่ำกว่า6ตัวอักษรและเป็นตัวเลขเท่านั้น</div>
                                  <label id="password2-error2" class="error" for="password2">กรุณาระบุให้ครบ6ตัวอักษร</label>
                                  <label id="password2-error" class="error" for="password2">ยืนยัน password ให้ตรงกัน</label>
                                </div>
                              </div>
                            </div>
                          </div>
                               <div class="align-center">
                                    <button type="button" class="btn btn-success waves-effect" onclick="chkinput();">บันทึก</button>
                                    <button type="button" class="btn btn-warning waves-effect" onclick="OnCancel();">ยกเลิก</button>
                                </div>
                            </div>
                             
                        </form>
                    </div>
                </div>
            </div>

            <!--  -->
        </div>
    </div>
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
    $('#firstname').focus();
    return false;
  }else{
    $('#firstname-error').hide();
  }

  if($('#lastname').val()==''){
    $('#lastname-error').show();
    $('#lastname').focus();
    return false;
  }else{
    $('#lastname-error').hide();
  }

  if($('#birthday').val()==''){
    $('#birthday-error').show();
    $('#birthday').focus();
    return false;
  }else{
    $('#birthday-error').hide();
  }

  if($('#idcard').val()==''){
    $('#idcard-error').show();
    $('#idcard').focus();
    return false;
  }else{
    $('#idcard-error').hide();
  }
  
  if($('#mobile').val()==''){
    $('#mobile-error').show();
    $('#mobile').focus();
    return false;
  }else{
    $('#mobile-error').hide();
  }

  if($('#address').val()==''){
    $('#address-error').show();
    $('#address').focus();
    return false;
  }else{
    $('#address-error').hide();
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
    $('#zipcode-error').show();
    $('#zipcode').focus();
    return false;
  }else{
    $('#zipcode-error').hide();
  }

  if($('#addressIDCard').val()==''){
    $('#addressIDCard-error').show();
    $('#addressIDCard').focus();
    return false;
  }else{
    $('#addressIDCard-error').hide();
  }

  if($('#provinceIDCard').val()==0){
    $('#provinceIDCard-error').show();
    $('#provinceIDCard').focus();
    return false;
  }else{
    $('#provinceIDCard-error').hide();
  }

  if($('#districtIDCard').val()==0){
    $('#districtIDCard-error').show();
    $('#districtIDCard').focus();
    return false;
  }else{
    $('#districtIDCard-error').hide();
  }

  if($('#subDistrictIDCard').val()==0){
    $('#subDistrictIDCard-error').show();
    $('#subDistrictIDCard').focus();
    return false;
  }else{
    $('#subDistrictIDCard-error').hide();
  }

  if($('#zipcodeIDCard').val()==''){
    $('#zipcodeIDCard-error').show();
    $('#zipcodeIDCard').focus();
    return false;
  }else{
    $('#zipcodeIDCard-error').hide();
  }
if($('#divref').is(':visible')){
  if($('#firstnameref').val()==''){
    $('#firstnameref-error').show();
    $('#firstnameref').focus();
    return false;
  }else{
    $('#firstnameref-error').hide();
  }

  if($('#lastnameref ').val()==''){
    $('#lastnameref-error').show();
    $('#lastnameref').focus();
    return false;
  }else{
    $('#lastnameref-error').hide();
  }

  if($('#mobileref').val()==''){
    $('#mobileref-error').show();
    $('#mobileref').focus();
    return false;
  }else{
    $('#mobileref-error').hide();
  }
}

  if($('#proc').val()=='add'){
    if($('#img').val()==''){
      $('#img-error').show();
      $('#img').focus();
      return false;
    }else{
      $('#img-error').hide();
    }
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
        $('.form-line').removeClass('focused');
        //$('.focused').removeClass('focused');
        $('.error').hide();
        $(".numb").inputFilter(function(value) {
          return /^\d*$/.test(value);
        });
        // $('#activeStatus0').prop("checked", false);

        if($('#proc').val()=='add'){
          $('#activeStatus1').prop("checked", true);
          $('#userStatus1').prop("checked", true);
          $('#password1').val('123456');
          $('#password1').attr('readonly',true);
          var userName ='';
          $.ajaxSetup({async: false});
          $.post('process/get_process.php',{proc:'get_username'},function(data){
           userName =  data['name'];
         },'json');
          $('#username').val(userName);
          $('#userCode').val(userName);
        }
        if($("input[name*='userStatus']:checked").val() != 1){
            $('#activeStatus0').prop("checked", true);
            $('#activeStatus1').attr("disabled", true);
            $('#userPass').hide();
        }else{
            $('#activeStatus1').prop("checked", true);
            $('#activeStatus1').removeAttr("disabled");
            $('#userPass').show();
          }
        // $('.datepickers').bootstrapMaterialDatePicker();
});
function get_address(){
  // console.log('getaddress');
  if($('#adsIDCard').is(':checked')) {
    debugger
    let province_id = $('#hdfProvinceID').val();
    let district_id = $('#hdfDistrictID').val();
    let subdistrict_id = $('#hdfSubDistrictID').val();

    $('#provinceIDCard').selectpicker('refresh');
    $('#districtIDCard').selectpicker('refresh');
    $('#subDistrictIDCard').selectpicker('refresh');
    
    get_area(province_id,'districtIDCard','hdfProvinceIDCard',1);
    get_area(district_id,'subDistrictIDCard','hdfDistrictIDCard',2);

    $("#provinceIDCard").selectpicker('val', province_id);
    $("#districtIDCard").selectpicker('val', district_id);
    $("#subDistrictIDCard").selectpicker('val', subdistrict_id);
    $("#hdfSubDistrictIDCard").val($('#subDistrictIDCard').val());
    $('#addressIDCard').val($('#address').val());
    $('#zipcodeIDCard').val($('#zipcode').val());

  }else{
    $('#provinceIDCard').selectpicker('deselectAll');
    $('#districtIDCard').selectpicker('deselectAll');
    $('#subDistrictIDCard').selectpicker('deselectAll');
    $('#addressIDCard').val("");
    $('#zipcodeIDCard').val("");
  }
}

function get_area(parent_id,id,hdf_id,type){
// function get_area(parent_id,id,type){
  // console.log(parent_id,id,type);
    var html  = '<option value="">เลือก</option>';
     $.ajaxSetup({async: false});  
     $.post('process/get_process.php',{proc:'get_area',parent_id:parent_id,type:type},function(data){

              $.each(data,function(index,value){
                  html += "<option value='"+value['DATA_VALUE']+"'>"+value['DATA_NAME']+"</option>";
              });

        $('#'+hdf_id).val(parent_id);
        $('#'+id).html(html);
        $('#'+id).selectpicker('refresh');

    },'json');
}
function get_zipcode(parent_id,id,hdf_id){
  debugger
  // console.log(parent_id,hdf_id);
    var html  = '';
    $.ajaxSetup({async: false});
     $.post('process/get_process.php',{proc:'get_zipcode',parent_id:parent_id},function(data){

      $.each(data,function(index,value){
        html += value['zipcode'];
      });
      $('#'+hdf_id).val(parent_id);
      // $('#'+hdf_id).val(parent_id);
      $('#'+id).val(html);

    },'json');
}

function get_birthday(parent_id,hdf_id){
  $('#'+hdf_id).val(parent_id);
}

function chk_user(){

    var html  = 1;
    var username= $('#username').val();
    var userID= $('#userID').val();
    $.ajaxSetup({async: false});
     $.post('process/get_process.php',{proc:'chk_user',username:username,userID:userID},function(data){
        if(data==1){
             $('#username2-error').show();
             $('#username2').focus();
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
    $('#userPass').hide();
  }else{
    $('#activeStatus1').prop("checked", true);
    $('#activeStatus1').removeAttr("disabled");
    $('#userPass').show();

  }
});

$("input[name*='activeStatus']").change(function(){
  if ($(this).val() != 1) {
    $('#userPass').hide();
  }else{
    $('#userPass').show();
  }
});

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
function checkID(id)
{
  if(id.length != 13) return false;
  for(i=0, sum=0; i < 12; i++)
    sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
  return false; return true;
}

function checkForm()
{ 
  var res = $('#idcard').val().replace(/-/g, "");
  if(!checkID(res)){
    $('#idcard-error2').show();
    $('#idcard').focus();
    return false;
  }else{
    $('#idcard-error2').hide();
  } 
}
function isPhoneNo(input,type){
  var res = input.value.replace(/-/g, "");
  var regExp = /^0([0-9]{1})([0-9]{8})$/i;
  if (!regExp.test(res)) {
    if (type == 1) {
      $('#mobile-error2').show();
      $('#mobile').focus();
      return false;
    }else{
      $('#mobileref-error2').show();
      $('#mobileref').focus();
      return false;
    }
  }else{
    if (type == 1) {
      $('#mobile-error2').hide();
    }else{
      $('#mobileref-error2').hide();
    }
  }
}
function checkEmail(input){
var emailCheck=/^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i;
  if (!emailCheck.test(input.value)){
    $('#email-error2').show();
    $('#email').focus();
    return false;
  }else{
    $('#email-error2').hide();
  }
}
function chkMinlength(input,type){
  if (input.value.length < 6) {
    if (type == 1) {
      $('#password1-error2').show();
      $('#password1').focus();
      return false;
    }else{
      $('#password2-error2').show();
      $('#password2').focus();
      return false;
    }
  }else{ 
    if (type == 1) {
      $('#password1-error2').hide();
    }else{
      $('#password2-error2').hide();
    }
  }
}
</script>
