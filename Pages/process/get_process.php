<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");


$PROC = $_POST['proc'];

switch($PROC){

	case "get_brand" :
	$productTypeID = $_POST['productTypeID'];
	$sql ="  SELECT brandID as DATA_VALUE ,brandName as DATA_NAME from tb_brand where  productTypeID ='".$productTypeID."' order by brandName asc ";
	$query=$db->query($sql);
	$OBJ=array();
	while ($rec = $db->db_fetch_array($query)){
		$row['DATA_VALUE'] =$rec['DATA_VALUE'];
		$row['DATA_NAME'] =$rec['DATA_NAME'];
		array_push($OBJ,$row);
	}
	echo json_encode($OBJ);
	exit();
	break;

	case "get_area" :
	$parent_id = $_POST['parent_id'];
	$type = $_POST['type'];
	if($type==1){
		$sql ="  SELECT districtID as DATA_VALUE ,district_name_th as DATA_NAME from setup_district where provinceID ='".$parent_id."' order by district_name_th asc ";
	}else if($type==2){
		$sql=" SELECT subDistrictID as DATA_VALUE ,subDistrict_name_th as DATA_NAME from setup_subDistrict where districtID ='".$parent_id."' order by subDistrict_name_th asc";

	}


	$query=$db->query($sql);
	$OBJ=array();
	while ($rec = $db->db_fetch_array($query)){
		$row['DATA_VALUE'] =$rec['DATA_VALUE'];
		$row['DATA_NAME'] =$rec['DATA_NAME'];
		array_push($OBJ,$row);
	}
	echo json_encode($OBJ);
	exit();
	break;

	case "get_zipcode" :
	$parent_id = $_POST['parent_id'];

	$sql=" SELECT zipcode from setup_subDistrict where subDistrictID ='".$parent_id."' order by subDistrict_name_th asc";


	$query=$db->query($sql);
	$OBJ=array();
	while ($rec = $db->db_fetch_array($query)){

		$row['zipcode'] =$rec['zipcode'];
		array_push($OBJ,$row);
	}
	echo json_encode($OBJ);
	exit();
	break;

	case "get_username" :

	$sql = "SELECT MAX(userID) AS userID FROM tb_user";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	$run = sprintf("%03d", ($rec['userID']+1));

	$newUserID['name'] = "emp".$run;
	echo json_encode($newUserID);
	exit();
	break;

	case "get_supCode" :
	$sql = "SELECT MAX(supID) AS supID FROM tb_supplier";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	$run = sprintf("%03d", ($rec['supID']+1));

	$newUserID['name'] = "sup".$run;
	echo json_encode($newUserID);
	exit();
	break;

	case "get_productTypeCode" :

	$sql = "SELECT MAX(productTypeID) AS productTypeID FROM tb_producttype";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	$run = sprintf("%03d", ($rec['productTypeID']+1));

	$newUserID['name'] = "pdt".$run;
	echo json_encode($newUserID);
	exit();
	break;

	case "get_brandCode" :

	$sql = "SELECT MAX(brandID) AS brandID FROM tb_brand";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	$run = sprintf("%03d", ($rec['brandID']+1));

	$newUserID['name'] = "bnd".$run;
	echo json_encode($newUserID);
	exit();
	break;

	case "chk_user" :
	$userID = $_POST['userID'];
	$username = $_POST['username'];

	$sql=" SELECT username from tb_user where username ='".$username."'  and userID !='".$userID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_sup" :
	$supID = $_POST['supID'];
	$sup_name = $_POST['sup_name'];
	$name_nospace = str_replace(" ","",$sup_name);

	$sql=" SELECT sup_name from tb_supplier where name_nospace ='".$name_nospace."'  and supID !='".$supID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_productTypeCode" :
	$productTypeCode = $_POST['productTypeCode'];
	$productTypeID = $_POST['productTypeID'];

	$sql=" SELECT productTypeCode from tb_producttype where productTypeCode ='".$productTypeCode."'  and productTypeID !='".$productTypeID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_productTypeName" :
	$productTypeID = $_POST['productTypeID'];
	$productTypeName = $_POST['productTypeName'];
	$name_nospace = str_replace(" ","",$productTypeName);


	$sql=" SELECT productTypeName from tb_producttype where name_nospace ='".$name_nospace."'  and productTypeID !='".$productTypeID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;


	case "chk_LocationName" :
	$locationID = $_POST['locationID'];
	$locationName = $_POST['locationName'];
	$name_nospace = str_replace(" ","",$locationName);


	$sql=" SELECT locationName from tb_location where name_nospace ='".$name_nospace."'  and locationID !='".$locationID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_locationCode" :
	$locationCode = $_POST['locationCode'];
	$locationID = $_POST['locationID'];

	$sql=" SELECT locationCode from tb_location where locationCode ='".$locationCode."'  and locationID !='".$productTypeID."' ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_productTypeNameShort" :
	$productTypeNameShort = $_POST['productTypeNameShort'];
	$productTypeID = $_POST['productTypeID'];

	$sql=" SELECT productTypeNameShort from tb_producttype where productTypeNameShort ='".$productTypeNameShort."'  and productTypeID !='".$productTypeID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_brandName" :
	$brandID = $_POST['brandID'];
	$brandName = $_POST['brandName'];
	$name_nospace = str_replace(" ","",$brandName);

	$sql=" SELECT brandName from tb_brand where name_nospace ='".$name_nospace."'  and brandID !='".$brandID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_brandName_short" :
	$brandName_short = $_POST['brandName_short'];
	$brandID = $_POST['brandID'];

	$sql=" SELECT brandName_short from tb_brand where brandName_short ='".$brandName_short."'  and brandID !='".$brandID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "get_productcode" :
	$brand = $_POST['brand'];
	$sql=" SELECT brandName_short from tb_brand where brandID ='".$brand."'  ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	$rec = $db->db_fetch_array($query);
	$OBJ['name']=$rec['brandName_short'];
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_productCode" :
	$productCode = $_POST['productCode'];
	$name_nospace = str_replace(" ","",$productCode);

	$sql=" SELECT productCode from tb_product where productCode ='".$name_nospace."' ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_productName" :
	$productID = $_POST['productID'];
	$productName = $_POST['productName'];
	$name_nospace = str_replace(" ","",$productName);

	$sql=" SELECT productName from tb_product where name_nospace ='".$name_nospace."'  and productID !='".$productID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chkDelData_ProductType" :
	$productTypeID = $_POST['productTypeID'];

	$sql=" SELECT * FROM tb_producttype
	LEFT JOIN tb_brand on tb_producttype.productTypeID = tb_brand.productTypeID
	LEFT JOIN tb_location on tb_producttype.productTypeID = tb_location.productTypeID
	LEFT JOIN tb_product on tb_producttype.productTypeID = tb_product.productTypeID
	WHERE tb_producttype.productTypeID ='".$productTypeID."' AND tb_brand.brandID IS NOT NULL";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chkDelData_Brand" :
	$brandID = $_POST['brandID'];

	$sql=" SELECT * FROM  tb_brand
	JOIN tb_product on tb_brand.brandID = tb_product.brandID
	WHERE tb_brand.brandID ='".$brandID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chkDelData_Location" :
	$locationID = $_POST['locationID'];

	$sql=" SELECT * FROM  tb_location
	JOIN tb_productstore on tb_location.locationID = tb_productstore.locationID
	WHERE tb_location.locationID ='".$locationID."' AND ps_unit > 0";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chkDelData_Product" :
	$productID = $_POST['productID'];

	$sql=" SELECT * FROM  tb_product
	JOIN tb_productstore on tb_product.productID = tb_productstore.productID
	WHERE tb_product.productID ='".$productID."' AND ps_unit > 0";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "get_productcoder_other" :
	$productTypeID = $_POST['productTypeID'];
	$sql=" SELECT productTypeNameShort from tb_producttype where productTypeID ='".$productTypeID."'  ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	$rec = $db->db_fetch_array($query);


	$sql_sub =" SELECT productCode from tb_product where productCode like '".$rec['productTypeNameShort']."%' and productTypeID != 1 order by productID desc LIMIT 1";
	$query_sub =$db->query($sql_sub);
	$nums_sub = $db->db_num_rows($query_sub);
	$rec_sub = $db->db_fetch_array($query_sub);

	if($rec_sub['productCode']){
		$arr = explode('-',$rec_sub['productCode']);
		$int = $arr[1]+1;
		$newcode =  $rec['productTypeNameShort'].'-'.sprintf("%'.03d",$int);
	}else{
		$newcode = $rec['productTypeNameShort'].'-001';
	}
	$OBJ['name']=	$newcode;



	echo json_encode($OBJ);
	exit();
	break;

	case "get_product" :
	$type = $_POST['type'];
	$name = $_POST['name'];
	
	$filter = "";
	$OBJ  = array();

	if($name){
		if($type == 1){
			$filter .= " and c.locationCode  like '%".$name."%' and c.locationName  like '%".$name."%'";
		}
		else if($type == 2){
			$filter .= " and b.productCode  like '%".$name."%' and b.productName  like '%".$name."%'";
		}
	}

	if($type == 0 && !$name) $sql=" SELECT a.* ,b.productName,c.locationName,b.productCode,b.modelName,b.productSize,b.brandID,b.unitType,b.productTypeID
		from tb_productstore a
		join tb_product b on a.productID = b.productID
		join tb_location c on a.locationID = c.locationID
		where ps_unit > 0";
	else $sql=" SELECT a.* ,b.productName,c.locationName,b.productCode,b.modelName,b.productSize,b.brandID,b.unitType,b.productTypeID
		from tb_productstore a
		join tb_product b on a.productID = b.productID
		join tb_location c on a.locationID = c.locationID
		where ps_unit > 0 {$filter}";

	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	// if($filter!=''){
		while($rec = $db->db_fetch_array($query)){
			$detail ='';
			if($rec['modelName']){
				$detail .=' รุ่น '.$rec['modelName'];
			}
			if($rec['productSize']){
				$detail .='  ขนาด '.$rec['productSize'];
			}

			$row['productCode']  = $rec['productCode'];
			$row['productName']  = $rec['productName'];
			$row['productID']  = $rec['productID'];
			$row['locationName']  = $rec['locationName'];
			$row['locationID']  = $rec['locationID'];
			$row['brand']  = get_brand_name($rec['brandID']);
			$row['productTypeName']  = get_productType_name($rec['productTypeID']);
			$row['brandID']  = $rec['brandID'];
			$row['detail']  = $detail;
			$row['ps_unit']  = number_format($rec['ps_unit']);
			$row['unitType']  = $arr_unitType[$rec['unitType']];
			array_push($OBJ,$row);
		}
	// }
			//	$OBJ['name']=$rec['brandName_short'];



	echo json_encode($OBJ);
	exit();
	break;

	case "get_product_bill" :
	$OBJ  = array();
	$id = $_POST['id'];
	$sql=" SELECT a.* ,b.productName,c.locationName,b.productCode,b.modelName,b.productSize,b.brandID,b.unitType
	from tb_bill_desc a
	join tb_product b on a.productID = b.productID
	join tb_location c on a.locationID = c.locationID
	where 1=1 and billID ='".$id."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	while($rec = $db->db_fetch_array($query)){
		$row['productCode']  = $rec['productCode'];
		$row['productName']  = $rec['productName'];
		$row['locationName']  = $rec['locationName'];
		$row['brand']  = get_brand_name($rec['brandID']);
		$row['billDescUnit']  = number_format($rec['billDescUnit']);
		$row['unitType']  = $arr_unitType[$rec['unitType']];
		array_push($OBJ,$row);
	}
	echo json_encode($OBJ);
	exit();
	break;
	
	
}


?>
