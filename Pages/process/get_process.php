<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");


$PROC = $_POST['proc'];

switch($PROC){

	case "get_value" :
	$parent_id = $_POST['parent_id'];
	$sql ="  SELECT value as DATA_VALUE ,value as DATA_NAME FROM `tb_productattr` JOIN tb_typeattr on tb_typeattr.attrID = tb_productattr.attrID WHERE tb_productattr.attrID = '".$parent_id."'
	group by value order by value asc ";

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

	case "get_location" :
	$locationTypeID = $_POST['locationTypeID'];
	$productID = $_POST['productID'];

	$sql ="SELECT tb_location.locationID as DATA_VALUE ,locationName as DATA_NAME
	FROM tb_location
	LEFT JOIN tb_productstore ON tb_location.locationID = tb_productstore.locationID
	WHERE tb_location.locationTypeID = '".$locationTypeID."' AND (ps_id IS null or ps_unit = 0) OR(productID = '".$productID."' and ps_unit > 0)";

	

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

	case "get_attr" :
	$productTypeID = $_POST['parent_id'];
	$sql =" SELECT tb_attribute.attrID as DATA_VALUE ,attrName as DATA_NAME FROM tb_attribute 
	JOIN tb_typeattr ON tb_attribute.attrID = tb_typeattr.attrID
	WHERE productTypeID ='".$productTypeID."' ";
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

	case "get_poID" :
	$po_ym = "PO-".date("ym");

	$sql_po_no = "SELECT COUNT(*) AS poID FROM tb_po WHERE poID like '".$po_ym."%' ";
	$query_po_no = $db->query($sql_po_no);
	$rec_po_no = $db->db_fetch_array($query_po_no);
	$run_no = sprintf("%03d", ($rec_po_no['poID']+1));

	$poID = $po_ym.$run_no;
	
	$OBJ['name']=$poID;
	echo json_encode($OBJ);
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

	case "chk_idcard" :
	$userID = $_POST['userID'];
	$idcard = $_POST['idcard'];

	$sql=" SELECT idcard from tb_user where idcard ='".$idcard."'  and userID !='".$userID."'";
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

	case "chk_LocationTypeName" :
	$locationTypeID = $_POST['locationTypeID'];
	$locationTypeName = $_POST['locationTypeName'];
	$name_nospace = str_replace(" ","",$locationTypeName);


	$sql=" SELECT locationTypeName from tb_locationtype where name_nospace ='".$name_nospace."'  and locationTypeID !='".$locationTypeID."'";
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

	case "chk_locationTypeCode" :
	$locationTypeCode = $_POST['locationTypeCode'];
	$locationTypeID = $_POST['locationTypeID'];

	$sql=" SELECT locationTypeCode from tb_locationtype where locationTypeCode ='".$locationCode."'  and locationTypeID !='".$locationTypeID."' ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_locationCode" :
	$locationCode = $_POST['locationCode'];
	$locationID = $_POST['locationID'];

	$sql=" SELECT locationCode from tb_location where locationCode ='".$locationCode."'  and locationID !='".$locationID."' ";
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

	case "chk_brandCode" :
	$brandCode = $_POST['brandCode'];
	$brandID = $_POST['brandID'];

	$sql=" SELECT brandCode from tb_brand where brandCode ='".$brandCode."'  and brandID !='".$brandID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "get_productcode" :
	$brandID = $_POST['brandID'];
	$sql=" SELECT brandCode from tb_brand where brandID ='".$brandID."'  ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	$rec = $db->db_fetch_array($query);
	$OBJ['name']=$rec['brandCode'];
	echo json_encode($OBJ);
	exit();
	break;

	case "chk_editeattr" :

	$sql=" SELECT * from tb_attribute join tb_typeattr on tb_typeattr.attrID = tb_attribute.attrID ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
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

	case "chkDelData_Supplier" :
	$supID = $_POST['supID'];

	$sql=" SELECT * FROM  tb_supplier
	JOIN tb_product on tb_supplier.supID = tb_product.supID
	WHERE tb_supplier.supID ='".$supID."' ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chkDelData_ProductType" :
	$productTypeID = $_POST['productTypeID'];

	$sql=" SELECT * FROM tb_producttype
	LEFT JOIN tb_product on tb_producttype.productTypeID = tb_product.productTypeID
	WHERE tb_producttype.productTypeID ='".$productTypeID."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chkDelData_Brand" :
	$brandID = $_POST['brandID'];

	$sql=" SELECT * FROM  tb_brand
	LEFT JOIN tb_location on tb_brand.brandID = tb_location.brandID
	LEFT JOIN tb_product on tb_brand.brandID = tb_product.brandID
	WHERE tb_brand.brandID ='".$brandID."' AND (tb_location.brandID IS NOT NULL OR tb_product.brandID IS NOT NULL)";
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

	case "chkDelData_LocationType" :
	$locationTypeID = $_POST['locationTypeID'];

	$sql=" SELECT * FROM  tb_locationtype
	JOIN tb_location on tb_location.locationTypeID = tb_locationtype.locationID
	WHERE tb_locationtype.locationTypeID ='".$locationTypeID."'";
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
	$sql=" SELECT productTypeCode from tb_producttype where productTypeID ='".$productTypeID."'	 ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	$rec = $db->db_fetch_array($query);


	$sql_sub =" SELECT productCode from tb_product where productCode like '%".$rec['productTypeCode']."%' and productTypeID != 1 order by productID desc";
	$query_sub =$db->query($sql_sub);
	$nums_sub = $db->db_num_rows($query_sub);
	$rec_sub = $db->db_fetch_array($query_sub);

	if($rec_sub['productCode']){
		$arr = explode('-',$rec_sub['productCode']);
		$int = $arr[1]+1;
		$newcode =  $rec['productTypeCode'].'-'.sprintf("%'.03d",$int);
	}else{
		$newcode = $rec['productTypeCode'].'-001';
	}
	$OBJ['name']=	$newcode;



	echo json_encode($OBJ);
	exit();
	break;

	case "get_locationTypeCode" :
	$locationType = $_POST['locationType'];	
	$name = $arr_locationType[$locationType];
	$sql =" SELECT locationTypeCode from tb_locationtype where locationType ='".$locationType."' order by locationTypeCode desc ";
	$query =$db->query($sql);
	$nums = $db->db_num_rows($query);
	$rec = $db->db_fetch_array($query);

	if($rec['locationTypeCode']){
		$sql_sub =" SELECT locationTypeCode from tb_locationtype where locationTypeCode like '%".$rec['locationTypeCode']."%'";
		$query_sub =$db->query($sql_sub);
		$nums_sub = $db->db_num_rows($query_sub);
		$rec_sub = $db->db_fetch_array($query_sub);

		$arr = explode('-',$rec_sub['locationTypeCode']);
		$int = $arr[1]+1;
		$newcode =  $name.'-'.sprintf("%'.03d",$int);

	}else{
		$newcode = $name.'-001';
	}
	$OBJ['name']=	$newcode;
	echo json_encode($OBJ);
	exit();
	break;

	case "get_locationCode" :

	$sql_sub =" SELECT COUNT(*) AS locationCode from tb_location order by locationID desc";
	$query_sub =$db->query($sql_sub);
	$rec_sub = $db->db_fetch_array($query_sub);
	$run_sub = sprintf("%03d", ($rec_sub['locationCode']+1));
	$newcode = 'Location-'.$run_sub;	
	$OBJ['name']=	$newcode;
	echo json_encode($OBJ);
	exit();
	break;

	case "chkDelData_supPO" :
	$supID = $_POST['supID'];

	$sql=" SELECT * FROM tb_po
	WHERE supID ='".$supID."' and poStatus != 3 and poStatus != 99 ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
	echo json_encode($OBJ);
	exit();
	break;

	case "chkDelData_locStrock" :
	$locationID = $_POST['locationID'];

	$sql=" SELECT * FROM tb_productstore
	WHERE locationID ='".$locationID ."' and ps_unit > 0 ";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);

	$OBJ=$nums;
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
			$filter .= " and c.locationName  like '%".$name."%'";
		}else if($type == 2){
			$filter .= " and b.productName  like '%".$name."%'";
		}else if($type == 3){
			$filter .= " and d.productTypeName  like '%".$name."%'";
		}else if($type == 4){
			$filter .= " and e.brandName  like '%".$name."%'";
		}
	}

	// if($type == 0 && !$name) $sql="select a.* ,b.productName,c.locationName,b.productCode,b.brandID,b.unitType,b.productTypeID
	// from tb_productstore a
	// join tb_product b on a.productID = b.productID
	// join tb_location c on a.locationID = c.locationID
	// join tb_producttype d on b.productTypeID = d.productTypeID
	// join tb_brand e on b.brandID = e.brandID
	// where ps_unit > 0";
	// else 
	$sql=" SELECT tb_product.*,tb_productstore.ps_unit,tb_productstore.locationTypeID,tb_productstore.locationID
	FROM  tb_productstore INNER JOIN
	tb_product ON tb_productstore.productID = tb_product.productID INNER JOIN
	tb_producttype ON tb_product.productTypeID = tb_producttype.productTypeID INNER JOIN
	tb_brand ON tb_product.brandID = tb_brand.brandID
	where ps_unit > 0 {$filter}";

	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	// if($filter!=''){
	while($rec = $db->db_fetch_array($query)){
		
		$sql_attr = "SELECT tb_attribute.attrName, tb_productattr.value
		FROM tb_productattr JOIN tb_product ON tb_productattr.productID = tb_product.productID
		JOIN tb_attribute ON tb_productattr.attrID = tb_attribute.attrID
		WHERE tb_productattr.productID = '".$rec["productID"]."'";
		$query_attr = $db->query($sql_attr);
		$nums_attr = $db->db_num_rows($query_attr);

		if($nums_attr > 0){
			while($rec_attr = $db->db_fetch_array($query_attr))
			{
				$attr .= $rec_attr['attrName'].": ".$rec_attr['value']."<br>";
			}
		}else{
			$attr = '-';
		}
		

		$row['productID']  = $rec['productID'];
		$row['productCode']  = $rec['productCode'];
		$row['productName']  = $rec['productName'];
		$row['productTypeName']  = get_productType_name($rec['productTypeID']);
		$row['brandName']  = get_brand_name($rec['brandID']);
		$row['locationTypeName']  = get_locationType_name($rec['locationTypeID']);
		$row['locationName']  = get_location_name($rec['locationID']);
		$row['locationTypeID']  = $rec['locationTypeID'];
		$row['locationID']  = $rec['locationID'];
		$row['ps_unit']  = number_format($rec['ps_unit']);
		$row['unitType']  = $arr_unitType[$rec['unitType']];
		$row['attr']  = $attr;
		array_push($OBJ,$row);
	}
	echo json_encode($OBJ);
	exit();
	break;

	case "get_attribute" :
	$name = $_POST['name'];
	
	$filter = "";
	$OBJ  = array();

	if($name){
		$filter .= " and attrName  like '%".$name."%'";
	}

	$sql=" select *
	from tb_attribute
	where isEnabled = 1 {$filter}";

	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	while($rec = $db->db_fetch_array($query)){
		$row['attrID']  = $rec['attrID'];
		$row['attrName']  = $rec['attrName'];
		array_push($OBJ,$row);
	}
	echo json_encode($OBJ);
	exit();
	break;

	case "get_typeattr" :
	$productTypeID = $_POST['productTypeID'];
	
	$OBJ  = array();

	$sql=" select * from tb_typeattr
	join tb_attribute on tb_typeattr.attrID = tb_attribute.attrID
	where isEnabled = 1 and productTypeID ='".$productTypeID."' order by seq";

	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	while($rec = $db->db_fetch_array($query)){
		$row['attrID']  = $rec['attrID'];
		$row['attrName']  = $rec['attrName'];
		array_push($OBJ,$row);
	}
	echo json_encode($OBJ);
	exit();
	break;

	case "get_product_bill" :
	$OBJ  = array();
	$id = $_POST['id'];

	$sql=" SELECT a.billDescUnit ,b.*,c.locationName,d.locationTypeName
	from tb_bill_desc a
	join tb_product b on a.productID = b.productID
	join tb_location c on a.locationID = c.locationID
	join tb_locationtype d on a.locationTypeID = d.locationTypeID
	where billID ='".$id."'";
	$query=$db->query($sql);
	$nums = $db->db_num_rows($query);
	while($rec = $db->db_fetch_array($query)){

		$sql_attr = "SELECT tb_attribute.attrName, tb_productattr.value
		FROM tb_productattr JOIN tb_product ON tb_productattr.productID = tb_product.productID
		JOIN tb_attribute ON tb_productattr.attrID = tb_attribute.attrID
		WHERE tb_productattr.productID = '".$rec["productID"]."'";
		$query_attr = $db->query($sql_attr);
		$nums_attr = $db->db_num_rows($query_attr);

		if($nums_attr > 0){
			while($rec_attr = $db->db_fetch_array($query_attr))
			{
				$attr .= $rec_attr['attrName'].": ".$rec_attr['value']."<br>";
			}
		}else{
			$attr = '-';
		}

		$row['productCode']  = $rec['productCode'];
		$row['productName']  = $rec['productName'];
		$row['productTypeName']  = get_productType_name($rec['productTypeID']);
		$row['brandName']  = get_brand_name($rec['brandID']);
		$row['locationTypeName']  = $rec['locationTypeName'];
		$row['locationName']  = $rec['locationName'];
		$row['locationTypeID']  = $rec['locationTypeID'];
		$row['locationID']  = $rec['locationID'];
		$row['billDescUnit']  = number_format($rec['billDescUnit']);
		$row['unitType']  = $arr_unitType[$rec['unitType']];
		$row['attr']  = $attr;
		array_push($OBJ,$row);
	}
	echo json_encode($OBJ);
	exit();
	break;
	
	case "delect_supPO" :
	$runID = $_POST['runID'];

	$tb3 = 'tb_productsupplier';
	$db->db_delete($tb3, " runID = '".$runID."'");
	// $sql=" DELETE FROM tb_productsupplier
	// WHERE runID ='".$runID."'";
	// $query=$db->query($sql);
	// $nums = $db->db_num_rows($query);

	// $OBJ=$nums;
	// echo json_encode($OBJ);
	exit();
	break;
	
}


?>
