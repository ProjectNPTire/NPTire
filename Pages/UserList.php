<!DOCTYPE html>
<html>

<?php include 'css.php';?>

<body class="theme-red">
    <?php include 'MasterPage.php';?>

    <section class="content">
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>รายการพนักงาน</h2>
                        </div>
                        <div class="body">
                            <form action="UserInfo.php" method="POST">
                                <div class="icon-and-text-button-demo align-right">
                                    <button type="button" class="btn btn-primary waves-effect"><span>เพิ่มข้อมูล</span><i class="material-icons">add_box</i></button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>รหัสพนักงาน</th>
                                                <th>ชื่อพนักงาน</th>
                                                <th>เบอร์โทรศัพท์</th>
                                                <th>สถานะ</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>EM001</td>
                                                <td>นางสาว สมหญิง จริงใจ</td>
                                                <td>0835642537</td>
                                                <td>ใช้งาน</td>
                                                <td>
                                                    <button type="button" class="btn bg-warning waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" class="btn bg-red waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>EM002</td>
                                                <td>นาย สมชาย ใจดี</td>
                                                <td>0834638505</td>
                                                <td>ใช้งาน</td>
                                                <td>
                                                    <button type="button" class="btn bg-warning waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" class="btn bg-red waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>EM003</td>
                                                <td>นางสาว สมฤดี มีฐานะ</td>
                                                <td>0892378940</td>
                                                <td>ไม่ใช้งาน</td>
                                                <td>
                                                    <button type="button" class="btn bg-warning waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" class="btn bg-red waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>EM004</td>
                                                <td>นาย สมหมาย เอี่ยมศรี</td>
                                                <td>0935734673</td>
                                                <td>ไม่ใช้งาน</td>
                                                <td>
                                                    <button type="button" class="btn bg-warning waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" class="btn bg-red waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>EM005</td>
                                                <td>นาย วิทยา ฐานะดี</td>
                                                <td>0863659720</td>
                                                <td>ใช้งาน</td>
                                                <td>
                                                    <button type="button" class="btn bg-warning waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    <button type="button" class="btn bg-red waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>

    <?php include 'js.php';?>
</body>

</html>