<?php
$path_pic = $path."file_img/";
$sql_ses     = " SELECT *
FROM tb_user
where userID ='".$_SESSION["sys_id"]."' ";

$query_ses = $db->query($sql_ses);
$nums_ses = $db->db_num_rows($query_ses);
$rec_ses = $db->db_fetch_array($query_ses);

$sql_roles     = " SELECT *
FROM tb_role ";

$query_roles = $db->query($sql_roles);
//$nums = $db->db_num_rows($query);
$arr_key = array();
unset($arr_key);
while ($rec_roles = $db->db_fetch_array($query_roles)) {
  $arr_key[$rec_roles['menuKey']]['isAdd'] = $rec_roles['isAdd'];
  $arr_key[$rec_roles['menuKey']]['isEdit'] = $rec_roles['isEdit'];
  $arr_key[$rec_roles['menuKey']]['isDel'] = $rec_roles['isDel'];
  $arr_key[$rec_roles['menuKey']]['isSearch'] = $rec_roles['isSearch'];
  $arr_key[substr($rec_roles['menuKey'], 0, 1)] += $rec_roles['isSearch'];
}

$arrMenu = array(
  'desc' => array(
    '0' => 'หน้าหลัก',
    '1' => 'ค้นหาสินค้า',
    // '1_1' => 'ข้อมูลพนักงาน',
    // '2_1' => 'ข้อมูลคู่ค้า',
    '2' => array(
      '0' => 'จัดการข้อมูลบุคคล',
      '2_1' => 'ข้อมูลพนักงาน',
      '2_2' => 'ข้อมูลบริษัทคู่ค้า',
    ),

    '3' => array(
      '0' => 'ตั้งค่า',
      '3_1' => 'ข้อมูลประเภทสินค้า',
      '3_2' => 'ข้อมูลยี่ห้อสินค้า',
      '3_3' => 'ข้อมูลหน่วยนับ',
      '3_4' => 'ข้อมูลตำแหน่งจัดเก็บสินค้า',
    ),

    '4' => array(
      '0' => 'จัดการข้อมูลสินค้า',
      '4_1' => 'ข้อมูลยางรถยนต์',
      '4_2' => 'ข้อมูลสินค้าอื่น',
    ),

    '5' => array(
      '0' => 'การเคลื่อนไหวสินค้า',
      '5_1' => 'สั่งซื้อสินค้า',
      '5_2' => 'รับเข้าสินค้า',
      '5_3' => 'เบิกสินค้า',
    ),
  ),



  'url'=> array(
    '0' => 'main.php',
    '1' => 'SearchProduct.php',
    // '1_1' => 'UserList.php',
    // '2_1' => 'SupplierList.php',
    '2' => array(
      '0' => 'จัดการข้อมูลบุคคล',
      '2_1' => 'UserList.php',
      '2_2' => 'SupplierList.php',
    ),

    '3' => array(
      '0' => 'ตั้งค่า',
      '3_1' => 'ProductTypeList.php',
      '3_2' => 'BrandList.php',
      '3_3' => 'UnitList.php',
      '3_4' => 'LocationList.php',
    ),

    '4' => array(
      '0' => 'จัดการข้อมูลสินค้า',
      '4_1' => 'ProductMainList.php',
      '4_2' => 'ProductList.php',
    ),

    '5' => array(
      '0' => 'การเคลื่อนไหวสินค้า',
      '5_1' => 'OrderList.php',
      '5_2' => 'ReceiveList.php',
      '5_3' => 'TransferList.php',
    ),

    // '3' => array(
    //   '0' => '#',
    //   '3_1' => 'AttributeList.php',
    //   '3_2' => 'ProductTypeList.php',
    //   '3_3' => 'BrandList.php',
    //   '3_4' => 'LocationTypeList.php',
    //   '3_5' => 'LocationList.php',
    //   '3_6' => 'ProductList.php',
    // ),
    // '4_1' => 'OrderList.php',
    // '5_1' => 'ReceiveList.php',
    // '6_1' => 'TransferList.php',
  ),
  'icon'=> array(
    '0' => '<i class="material-icons">home</i>',
    '1' => '<i class="material-icons">search</i>',
    '2' => '<i class="material-icons">group</i>',
    '3' => '<i class="material-icons">settings</i>',
    '4' => '<i class="material-icons">apps</i>',
    '5' => '<i class="material-icons">local_shipping</i>',
    // '0' => '<i class="material-icons">home</i>',
    // '1' => '<i class="material-icons">search</i>',
    // '1_1' => '<i class="material-icons">group</i>',
    // '2_1' => '<i class="material-icons">group</i>',
    // '3' => '<i class="material-icons">apps</i>',
    // '4_1' => '<i class="material-icons">shopping_basket</i>',
    // '5_1' => '<i class="material-icons">file_download</i>',
    // '6_1' => '<i class="material-icons">file_upload</i>',
  )
); 


?>
<!-- Page Loader -->
<div class="page-loader-wrapper">
  <div class="loader">
    <div class="preloader">
      <div class="spinner-layer pl-red">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
    </div>
    <p>Please wait...</p>
  </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Top Bar -->
<nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
      <a href="javascript:void(0);" class="bars"></a>
      <div class="image">
        <span>
          <img src="../assets/images/Layer1.png" align="left" width="48" height="48" alt="Logo" />
          <a class="navbar-brand" href="index.html">NP TIRE (GOLDWHEELS)</a>
        </span>
      </div>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="nav navbar-nav navbar-right">

      </ul>
    </div>
  </div>
</nav>
<!-- #Top Bar -->
<section>
  <!-- Left Sidebar -->
  <aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
      <div class="image">
        <?php if($rec_ses['img']==''){?>
          <img src="../assets/images/user.png" width="48" height="48" alt="User" />
        <?php } else{?>
          <img src="<?php echo $path_pic.$rec_ses['img'];?>" width="48" height="48" alt="User" />
        <?php } ?>
      </div>
      <div class="info-container">
        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['sys_name'];?></div>
        <div class="btn-group user-helper-dropdown">
          <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
          <ul class="dropdown-menu pull-right">
            <li><a href="profile.php"><i class="material-icons">person</i>ข้อมูลส่วนตัว</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php"><i class="material-icons">input</i>ออกจากระบบ</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
      <ul class="list">
        <li class="header">เมนูหลัก</li>
                   <?php //print_pre($arrMenu);
                    foreach ($arrMenu['desc'] as $key => $value) {
                      if(count($arrMenu['desc'][$key]) > 1){
                        $active = '';
                        if($key==$page_key){
                          $active = 'class="active"';
                        }
                        ?>
                        <li <?php echo $active;?>>
                         <?php if($_SESSION["userType"] == 1 || ($_SESSION["userType"] == 2 && $arr_key[$key] > 0)){ // check number of submenu by permission  ?>
                           <a href="javascript:void(0);" class="menu-toggle"> <?php echo $arrMenu['icon'][$key].'  <span>'.$arrMenu['desc'][$key][0].'</span>'; ?> </a>
                         <?php } ?>
                         <ul class="ml-menu">
                           <?php   foreach($arrMenu['desc'][$key] as $keySub => $valSub){
                             if($keySub>0){
                              $active_sub = '';
                              $active_toggled = '';

                              if($keySub==$page_key){
                                $active_sub = 'class="active"';
                              }
                              if(count($arrMenu['desc'][$key][$keySub]) > 1){
                                foreach ($arrMenu['desc'][$key][$keySub] as $chk=> $value_chk) {
                                  if($chk==$page_key)
                                    $active_toggled = 'toggled';
                                }
                              }

                                  if($_SESSION["userType"] == 1 || ($_SESSION["userType"] == 2 && $arr_key[$keySub]['isSearch'] == 1 )){ // open menu by permission
                                    if(count($arrMenu['desc'][$key][$keySub]) > 1){ ?>

                                      <li <?php echo  $active_sub ;?>>
                                        <a href="javascript:void(0);" class="menu-toggle <?php echo  $active_toggled;?>"><?php echo $valSub[0];?></a>
                                        <ul class="ml-menu">
                                         <?php   foreach($arrMenu['desc'][$key][$keySub] as $keySub2 => $valSub2){
                                          if($keySub2>0){
                                            $active_sub2 = '';
                                            if($keySub2==$page_key){
                                              $active_sub2 = 'class="active"';
                                            }

                                            echo  '   <li '.$active_sub2.'>  <a href="'.$arrMenu['url'][$key][$keySub][$keySub2].'">'.$valSub2.'</a>  </li>';

                                          }
                                        } ?>
                                      </ul>
                                    </li>

                                    <?php
                                  }else{
                                    if($keySub==$page_key){
                                      $active_sub = 'class="active"';
                                    }
                                    echo '<li '. $active_sub.'><a href="'.$arrMenu['url'][$key][$keySub].'">'.$valSub.'</a></li>';
                                  }

                                      //
                                }
                              }
                              ?>

                            <?php } ?>
                          </ul>
                        </li>


                      <?php }else{
                       $active = '';
                       if($key==$page_key){
                        $active = 'class="active"';
                      }
                      ?>
                      <li <?php echo $active;?>>
                        <a href="<?php echo $arrMenu['url'][$key]; ?>">  <?php echo $arrMenu['icon'][$key].'  <span>'.$arrMenu['desc'][$key].'</span>'; ?></a>
                      </li>

                    <?php }
                  } ?>
                  <!--  $arrMenu = array( 'desc' => array( 'url'=> array( 'icon'=> array(-->




                  <?php if($_SESSION["userType"] == 1){ ?>
                    <li class="header">รายงานและการใช้งาน</li>
                    <li>
                      <a href="Report.php">
                        <i class="material-icons col-light-blue">donut_large</i>
                        <span>รายงาน</span>
                      </a>
                    </li>

                    <li>
                      <a href="ReportStock.php">
                        <i class="material-icons col-light-green">donut_large</i>
                        <span>รายงานข้อมูลสินค้าทั้งหมดจัดเก็บตามพื้นที่</span>
                      </a>
                    </li>

                    <li>
                      <a href="RoleList.php">
                        <i class="material-icons col-red">donut_large</i>
                        <span>กำหนดสิทธิ์ผู้ใช้งาน</span>
                      </a>
                    </li>
                    <li>
                      <a href="LogFile.php">
                        <i class="material-icons col-amber">donut_large</i>
                        <span>ข้อมูลการใช้ระบบ</span>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
              <!-- #Menu -->
              <!-- Footer -->
              <div class="legal">
                <div class="copyright">
                  &copy; 2018 - 2019 <a href="javascript:void(0);">NP TIRE (GOLDWHEELS)</a>.
                </div>
              </div>
              <!-- #Footer -->
            </aside>

          </section>

<!--



-->
