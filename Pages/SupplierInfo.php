<!DOCTYPE html>
<html>

<?php include 'css.php';?>

<body class="theme-red">
    <?php include 'MasterPage.php';?>
    <section class="content">
        <div class="container-fluid">
            <!-- Advanced Form Example With Validation -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ข้อมูลคู่ค้า</h2>
                        </div>
                        <div class="body">
                            <form id="form_validation" method="POST">
                                <div class="form-group form-float">
                                    <b>ชื่อคู่ค้า/บริษัท*</b>
                                    <div class="form-line">
                                        <input type="text" name="txtName" class="form-control" required>
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
                                        <option selected>Hot Dog, Fries and a Soda</option>
                                        <option>Burger, Shake and a Smile</option>
                                        <option>Sugar, Spice and all things nice</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <b>แขวง/ตำบล*</b>
                                    <select name="txtSubdistrict" class="form-control show-tick" data-live-search="true">
                                        <option value="">-- Please select --</option>
                                        <option>Hot Dog, Fries and a Soda</option>
                                        <option selected>Burger, Shake and a Smile</option>
                                        <option>Sugar, Spice and all things nice</option>
                                    </select>
                                </div>
                                <div class="form-group form-float">
                                    <b>รหัสไปรษณีย์*</b>
                                    <div class="form-line">
                                        <input type="text" name="txtZipcode" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <b>หมายเหตุ</b>
                                    <div class="form-line">
                                        <textarea rows="1" class="form-control no-resize auto-growth" required></textarea>
                                    </div>
                                </div>
                                <div class="align-center">
                                    <button class="btn btn-success waves-effect" type="submit">บันทึก</button>
                                    <button class="btn btn-default waves-effect" type="button">ยกเลิก</button>
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