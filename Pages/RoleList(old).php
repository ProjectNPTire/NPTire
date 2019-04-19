<!DOCTYPE html>
<html>
<?php
$path = "../";
include($path."include/config_header_top.php");
include 'css.php';
$page_key ='99999';
/*$sql     = " SELECT *
            FROM tb_role ";

$query = $db->query($sql);
//$nums = $db->db_num_rows($query);
$arr_key = array();
//unset($arr_key);
while ($rec = $db->db_fetch_array($query)) {
    $arr_key[$rec['menuKey']]['isAdd'] = $rec['isAdd'];
    $arr_key[$rec['menuKey']]['isEdit'] = $rec['isEdit'];
    $arr_key[$rec['menuKey']]['isDel'] = $rec['isDel'];
    $arr_key[$rec['menuKey']]['isSearch'] = $rec['isSearch'];
}*/
$arr_menu  = array(
        'm1' => 'บุคคล',
        'm_1' => array(
            '1_1' => 'ข้อมูลพนักงาน',
            '1_2' => 'ข้อมูลคู่ค้า'
        ),
        'm2' => 'สินค้า',
        'm_2' => array(
            '2_1' => 'ประเภทสินค้า',
            '2_2' => 'ยี่ห้อสินค้า',
            '2_3' => 'ข้อมูลสินค้า',
            /*'m_2_3' => array(
                '2_3_1' => 'ข้อมูลยางและแม็กซ์',
                '2_3_2' => 'ข้อมูลสินค้าอื่น',
            ),*/
            '2_4' => 'ตำแหน่งจัดเก็บสินค้า',
        ),
        'm3' => 'การเคลื่อนไหวสินค้า',
        'm_3' => array(
            '3_1' => 'สั่งซื้อสินค้า',
            '3_2' => 'รับเข้าสินค้า',
            '3_3' => 'เบิกสินค้า',
        ),
	);
?>

<?php include 'css.php';?>
<body class="theme-red">
    <?php include 'MasterPage.php';?>
    <?php
    if($_SESSION["userType"] != 1){ // check permission
    ?>
        <script>
            alert("คุณไม่มีสิทธิ์ใช้งานหน้านี้");
            window.location.assign("main.php");
        </script>
    <?php
    }
    ?>
	<?php include 'MasterPage.php';?>
	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
                            <?php /*echo "<pre>"; ?>
                            <?php print_r($arr_key); ?>
                            <?php echo "</pre>";*/ ?>
							<h2>
								กำหนดสิทธิ์การใช้งาน
							</h2>
						</div>
						<div class="body table-responsive">
                            <form id="frm-search" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" id="proc" name="proc" value="">
                                <input type="hidden" id="form_page" name="form_page" value="RoleList.php">
    							<table class="table table-bordered">
    								<thead>
    									<tr>
    										<th><div align="center">รายการ</div></th>
    										<th><div align="center">ค้นหา</div></th>
    										<th><div align="center">เพิ่ม</div></th>
    										<th><div align="center">แก้ไข</div></th>
    										<th><div align="center">ลบ</div></th>
    									</tr>
    								</thead>
    								<tbody>
    									<?php foreach ($arr_menu  as $key => $value){ ?>
                                            <?php if(!is_array($arr_menu[$key])){?>
                                                <tr style="background-color: #EBEDEF">
                                                    <td colspan="5"><strong><?php echo $arr_menu[$key]; ?></strong></td>
                                                </tr>
                                            <?php } ?>
                                            <?php foreach($arr_menu[$key] as $sub_key => $sub_v){ ?>
                                                <?php if(!is_array($arr_menu[$key][$sub_key])){?>
                                                <tr>
                                                    <td><ul><?php echo $arr_menu[$key][$sub_key]; ?></ul><input type="hidden" name="menuKey[<?php echo $sub_key; ?>]" value="<?php echo $sub_key; ?>"></td>
                                                    <td align="center">
                                                        <input type="checkbox" id="isSearch<?php echo $sub_key; ?>" name="isSearch<?php echo $sub_key; ?>" value="1" class="filled-in chk-col-blue" <?php echo ($arr_key[$sub_key]['isSearch']==1) ? "checked" : "" ; ?> />
        											    <label for="isSearch<?php echo $sub_key; ?>"></label>
                                                    </td>
                                                    <td align="center">
                                                        <input type="checkbox" id="isAdd<?php echo $sub_key; ?>" name="isAdd<?php echo $sub_key; ?>" value="1" class="filled-in chk-col-blue" <?php echo ($arr_key[$sub_key]['isAdd']==1) ? "checked" : "" ; ?> />
        											    <label for="isAdd<?php echo $sub_key; ?>"></label>
                                                    </td>
                                                    <td align="center">
                                                        <input type="checkbox" id="isEdit<?php echo $sub_key; ?>" name="isEdit<?php echo $sub_key; ?>" value="1" class="filled-in chk-col-blue" <?php echo ($arr_key[$sub_key]['isEdit']==1) ? "checked" : "" ; ?> />
        											    <label for="isEdit<?php echo $sub_key; ?>"></label>
                                                    </td>
                                                    <td align="center">
                                                        <input type="checkbox" id="isDel<?php echo $sub_key; ?>" name="isDel<?php echo $sub_key; ?>" value="1" class="filled-in chk-col-blue" <?php echo ($arr_key[$sub_key]['isDel']==1) ? "checked" : "" ; ?> />
        											    <label for="isDel<?php echo $sub_key; ?>"></label>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <?php /*foreach($arr_menu[$key][$sub_key] as $k => $v){ ?>
                                                    <?php if(!is_array($arr_menu[$key][$sub_key][$k])){?>
                                                    <tr>
                                                        <td colspan="5"><ul><ul><?php echo $arr_menu[$key][$sub_key][$k]; ?></ul></ul></td>
                                                    </tr>
                                                    <?php } ?>
                                                <?php }*/ ?>
                                            <?php } ?>
                                        <?php } ?>
    								</tbody>
    							</table>

                                <div class="align-center">
                                    <button class="btn btn-success waves-effect" type="button" onclick="editData();">บันทึก</button>
                                </div>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include 'js.php';?>
</body>

</html>

<script>
    function editData(){
        if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
            $("#proc").val("edit");
            $("#frm-search").attr("action","process/role_process.php").submit();
        }
    }
</script>
