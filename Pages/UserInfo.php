<!DOCTYPE html>
<html>

<?php include 'css.php';?>

<body class="theme-red">
    <?php include 'MasterPage.php';?>
    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ข้อมูลพนักงาน</h2>
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" method="POST">
                                <h3>Account Information</h3>
                                <fieldset>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="txtUsername" maxlength="15" minlength="8" required>
                                            <label class="form-label">Username*</label>
                                        </div>
                                        <div class="help-info">กรุณากรอกตัวอักษรภาษาอังกฤษหรือตัวเลข 8-15 ตัวอักษร</div>
                                    </div>

                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="txtPassword" id="password" minlength="6" required>
                                            <label class="form-label">Password*</label>
                                        </div>
                                        <div class="help-info">ความยาวต้องไม่น้อยกว่า 6 ตัวอักษร</div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="confirm" id="
                                            confirm" required>
                                            <label class="form-label">Confirm Password*</label>
                                        </div>
                                    </div>
                                </fieldset>

                                <h3>Profile Information</h3>
                                <fieldset>
                                    <div class="form-group form-float">
                                        <b>ชื่อ*</b>
                                        <div class="form-line">
                                            <input type="text" name="txtName" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <b>นามสกุล*</b>
                                        <div class="form-line">
                                            <input type="text" name="txtSurname" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <b>อายุ*</b>
                                        <div class="form-line">
                                            <input min="18" type="number" name="txtAge" class="form-control" required>
                                        </div>
                                        <div class="help-info">The warning step will show up if age is less than 18</div>
                                    </div>
                                  <!--   <div class="demo-masked-input"> -->
                                        <div class="form-group form-float">
                                            <b>วัน/เดือน/ปีเกิด*</b>
                                            <div class="form-line">
                                                <input type="text" name="txtBirthday" class="form-control date" placeholder="Ex: 30/07/2000" required>
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                    <div class="form-group form-float">
                                        <b>รหัสบัตรประชาชน*</b>
                                        <div class="form-line">
                                            <input type="text" name="txtIDcard" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <b>Email*</b>
                                        <div class="form-line">
                                            <input type="email" name="txtEmail" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="demo-masked-input">
                                        <div class="form-group form-float">
                                            <b>เบอร์โทรศัพท์มือถือ*</b>
                                            <div class="form-line">
                                                <input type="text" name="txtTel" class="form-control mobile-phone-number" placeholder="Ex: 00-0000-0000" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <b>ที่อยู่*</b>
                                        <div class="form-line">
                                            <textarea rows="1" class="form-control no-resize auto-growth" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <b>จังหวัด*</b>
                                            <select name="txtProvince" class="form-control show-tick" data-live-search="true">
                                                <option value="">-- Please select --</option>
                                                <option>Hot Dog, Fries and a Soda</option>
                                                <option>Burger, Shake and a Smile</option>
                                                <option>Sugar, Spice and all things nice</option>
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <b>เขต/อำเภอ*</b>
                                            <select name="txtDistrict" class="form-control show-tick" data-live-search="true">
                                                <option value="">-- Please select --</option>
                                                <option>Hot Dog, Fries and a Soda</option>
                                                <option>Burger, Shake and a Smile</option>
                                                <option>Sugar, Spice and all things nice</option>
                                            </select>
                                    </div>
                                    <div class="form-group">
                                        <b>แขวง/ตำบล*</b>
                                            <select name="txtSubdistrict" class="form-control show-tick" data-live-search="true">
                                                <option value="">-- Please select --</option>
                                                <option>Hot Dog, Fries and a Soda</option>
                                                <option>Burger, Shake and a Smile</option>
                                                <option>Sugar, Spice and all things nice</option>
                                            </select>
                                    </div>
                                    <div class="form-group form-float">
                                        <b>รหัสไปรษณีย์*</b>
                                        <div class="form-line">
                                            <input type="text" name="txtZipcode" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <b>รูปภาพ</b>
                                        <input type="file" name="fileToUpload" id="fileToUpload">
                                    </div>
                                </fieldset>
                                <h3>Terms & Conditions - Finish</h3>
                                <fieldset>
                                    <input id="acceptTerms-2" name="acceptTerms" type="checkbox" required>
                                    <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
                                </fieldset>
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