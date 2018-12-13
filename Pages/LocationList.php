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
                            <h2>รายการตำแหน่งจัดเก็บ</h2>
                        </div>
                        <div class="body"> 
                            <form action="LocationInfo.php" method="POST">
                                <div class="icon-and-text-button-demo align-right">
                                    <button type="submit" class="btn btn-primary waves-effect"><span>เพิ่มข้อมูล</span><i class="material-icons">add</i></button>
                                </div>
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รหัสตำแหน่งจัดเก็บ</th>
                                                <th>ชื่อตำแหน่งจัดเก็บ</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Location001</td>
                                                <td>แสดงสินค้าชั้น1</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Location002</td>
                                                <td>ที่เก็บสินค้าชั้น2ตำแหน่งที่1</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Location003</td>
                                                <td>ที่เก็บสินค้าชั้น2ตำแหน่งที่2</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Location004</td>
                                                <td>ที่เก็บสินค้าชั้น2ตำแหน่งที่3</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Location005</td>
                                                <td>ที่เก็บสินค้าชั้น2ตำแหน่งที่4</td>
                                                <td>
                                                    <span  data-toggle="modal" data-target="#largeModal">
                                                        <button id="btn_info" type="button" class="btn btn-info btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="ข้อมูล">
                                                            <i class="material-icons">info_outline</i>
                                                        </button>
                                                    </span>
                                                    <a class="btn bg-orange btn-xs waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a class="btn bg-red btn-xs waves-effect">
                                                        <i class="material-icons">delete_forever</i>
                                                    </a>
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
        </div>
    </div>
</section>
<?php include 'js.php';?>
</body>

</html>
