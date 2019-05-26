<?php

$path = "../../";
include($path."include/config_header_top.php");

switch ($_POST["func"]) {
    case 'getProduct':

    getProduct($_POST["code"],$_POST["name"],$_POST["supID"]);

    break;

    case 'getSupInfo':

    getSupInfo($_POST["id"]);

    break;

    case 'getPOInfo':

    getPOInfo($_POST["id"]);

    break;

    case 'getReceiveInfo':

    getReceiveInfo($_POST["id"]);

    break;

    default:
        // code...
    break;
}

function getProduct($code, $name, $supID){

    global $db;

    $filter = "";
    if($code)
        $filter .= " AND productCode like '%".$code."%' ";
    if($name)
        $filter .= " AND productName like '%".$name."%' ";

    $sql = "SELECT tb_product.* FROM tb_productsupplier
    join tb_product on tb_productsupplier.productID = tb_product.productID
    WHERE tb_product.isEnabled = 1
    and tb_productsupplier.supID = '".$supID."' ".$filter;

    
    $query = $db->query($sql);
    while($rec = $db->db_fetch_array($query)){

        $sql_attr = "SELECT tb_attribute.attrName, tb_productattr.value
        FROM tb_productattr JOIN tb_attribute ON tb_productattr.attrID = tb_attribute.attrID
        WHERE productID = '".$rec["productID"]."'";
        $query_attr = $db->query($sql_attr);
        $nums_attr = $db->db_num_rows($query_attr);

        $attr = '';

        if($nums_attr > 0){
            while($rec_attr = $db->db_fetch_array($query_attr))
            {
                $attr .= $rec_attr['attrName'].": ".$rec_attr['value']."<br>";
            }
        }else{
            $attr = '-';
        }


        $arr[] = array(
            "productID" => $rec["productID"],
            "productCode" => $rec["productCode"],
            "productName" => $rec["productName"],
            "productTypeName" => get_productType_name($rec["productTypeID"]),
            "brandName" => get_brand_name($rec["brandID"]),
            "productDetail" => $rec["productDetail"],
            "unitType" => $rec["unitType"],
            "productUnit" => $rec["productUnit"],
            "orderPoint" => $rec["orderPoint"],
            "attr" => $attr,
        );
    }

    echo json_encode($arr);
}

function getSupInfo($id){

    global $db;

    $sql = "SELECT * FROM tb_supplier WHERE supID = '".$id."' ";
    $query = $db->query($sql);
    $rec = $db->db_fetch_array($query);

    $sup_name = $rec['sup_name'];
    $sup_address = $rec['sup_address'];
    $province_name_th = get_prov_name($rec['provinceID']);
    $district_name_th = get_district_name($rec['districtID']);
    $subDistrict_name_th = get_subDistrictID_name($rec['subDistrictID']);

    $arr = array(
        "sup_address" => $sup_address,
        "province_name_th" => $province_name_th,
        "district_name_th" => $district_name_th,
        "subDistrict_name_th" => $subDistrict_name_th,
        "sup_name" => $sup_name,
    );

    echo json_encode($arr);
}

function getPOInfo($id){

    global $db;

    $sql_po = "SELECT * FROM tb_po WHERE poID = '".$id."' ";
    $query_po = $db->query($sql_po);
    $rec_po = $db->db_fetch_array($query_po);

    $sql_sup = "SELECT * FROM tb_supplier WHERE supID = '".$rec_po["supID"]."' ";
    $query_sup = $db->query($sql_sup);
    $rec_sup = $db->db_fetch_array($query_sup);

    $sql_emp = "SELECT * FROM tb_user WHERE userID = '".$rec_po["create_by"]."' ";
    $query_emp = $db->query($sql_emp);
    $rec_emp = $db->db_fetch_array($query_emp);

    $sql_pd = "SELECT * FROM tb_po_desc WHERE poID = '".$id."' ";
    $query_pd = $db->query($sql_pd);

    $poID = $rec_po["poID"];
    $sup_name = $rec_sup["sup_name"];
    $sup_address = $rec_sup["sup_address"]." ".get_subDistrictID_name($rec_sup["subDistrictID"])." ".get_district_name($rec_sup["districtID"])." ".get_prov_name($rec_sup["provinceID"])." ".$rec_sup["zipcode"];
    $sup_tel = $rec_sup["sup_tel"];
    $namesale = $rec_sup["namesale"]." ".$rec_sup["lastnamesale"];
    $mobilesale = $rec_sup["mobilesale"];
    $total = $rec_po["total"];
    $poDate = $rec_po["poDate"];
    $create_by = $rec_po["create_by"];
    $poStatus = $rec_po["poStatus"];
    $cancelBy = $rec_po["cancelBy"];
    $cancelDate = $rec_po["cancelDate"];

    $empname = $rec_emp["firstname"]." ".$rec_emp["lastname"];

    if($_SESSION["userType"] == "1") $isCancel = 1;
    else $isCancel = 0;

    $arr_head = array(
        "poID" => $poID,
        "sup_name" => $sup_name,
        "sup_address" => $sup_address,
        "sup_tel" => $sup_tel,
        "namesale" => $namesale,
        "mobilesale" => $mobilesale,
        "total" => $total,
        "poDate" => conv_date($poDate),
        "create_by" => $create_by,
        "poStatus" => $poStatus,
        "poStatusName" => get_poStatus($poStatus),
        "isCancel" => $isCancel,
        "empname" => $empname,
        "cancelBy" => $cancelBy,
        "cancelDate" => $cancelDate,
    );

    $i = 1;

    while($rec_pd = $db->db_fetch_array($query_pd))
    {

        $sql_product = "SELECT * FROM  tb_product
        WHERE productID = '".$rec_pd["productID"]."' ";
        $query_product = $db->query($sql_product);
        $rec_product = $db->db_fetch_array($query_product);

        $sql_cnt_received = "SELECT SUM(qty) AS received_qty FROM tb_receive_desc WHERE productID = '".$rec_pd["productID"]."' AND poID = '".$poID."' AND cancelFlag = '0' ";
        $query_cnt_received = $db->query($sql_cnt_received);
        $rec_cnt_received = $db->db_fetch_array($query_cnt_received);

        $sql_attr = "SELECT tb_attribute.attrName, tb_productattr.value
        FROM tb_productattr JOIN tb_attribute ON tb_productattr.attrID = tb_attribute.attrID
        WHERE productID = '".$rec_pd["productID"]."'";
        $query_attr = $db->query($sql_attr);
        $nums_attr = $db->db_num_rows($query_attr);

        $attr = '';

        if($nums_attr > 0){
            while($rec_attr = $db->db_fetch_array($query_attr))
            {
                $attr .= $rec_attr['attrName'].": ".$rec_attr['value']."<br>";
            }
        }else{
            $attr = '-';
        }

        $arr_desc[] = array(
            "productID"=>$rec_pd['productID'],
            "productCode"=>$rec_product['productCode'],
            "productName"=>$rec_product['productName'],
            "productTypeID"=>$rec_product['productTypeID'],
            "brandID"=>$rec_product['brandID'],
            "productTypeName"=>get_productType_name($rec_product['productTypeID']),
            "brandName"=>get_brand_name($rec_product['brandID']),
            "price"=>$rec_pd['price'],
            "qty"=>$rec_pd['qty'],
            "amount"=>$rec_pd['amount'],
            "received_qty"=>$rec_cnt_received['received_qty'] != '' ? $rec_cnt_received['received_qty'] : '0',
            "attr" => $attr,
            "unitType"=>$arr_unitType[$rec_product['unitType']],
            "tempID" => $i,
        );
        // $locationTypeID = $rec_product["locationTypeID"];
        // $sql_location = "SELECT * FROM tb_location WHERE locationTypeID = '".$locationTypeID."' AND productID IN ('".$rec_pd["productID"]."',0)";     
        // $query_location = $db->query($sql_location);
        // $nums_location = $db->db_num_rows($query_location);
        // if ($nums_location > 0) {
        //     while($rec_location = $db->db_fetch_array($query_location)){
        //         $arr_location[] = array(
        //             "locationID"=>$rec_location['locationID'],
        //             "locationName"=>$rec_location['locationName'],
        //             "locationTypeID"=>$rec_location['locationTypeID'],
        //             "tempID" => $i,
        //         );
        //     }
        // }else{
        //     $sql_location = "SELECT * FROM tb_location WHERE locationTypeID = '".$locationTypeID."' AND productID = 0";
        //     $query_location = $db->query($sql_location);
        //     while($rec_location = $db->db_fetch_array($query_location)){
        //         $arr_location[] = array(
        //             "locationID"=>$rec_location['locationID'],
        //             "locationName"=>$rec_location['locationName'],
        //             "locationTypeID"=>$rec_location['locationTypeID'],
        //             "tempID" => $i,
        //         );
        //     }
        // }
        // $i++;
    }

    $sql_loctype = "SELECT tb_locationType.locationTypeID,locationTypeName FROM tb_locationType
    JOIN tb_location ON tb_locationtype.locationTypeID = tb_location.locationTypeID
    WHERE locationType = 3 OR locationID NOT IN (SELECT locationID FROM tb_productstore) 
    ORDER BY FIELD(locationType,3,1,2)";     
    $query_loctype = $db->query($sql_loctype);
    $nums_loctype = $db->db_num_rows($query_loctype);
    if ($nums_loctype > 0) {
        while($rec_loctype = $db->db_fetch_array($query_loctype)){
            $arr_locationType[] = array(
                "locationTypeID"=>$rec_loctype['locationTypeID'],
                "locationTypeName"=>$rec_loctype['locationTypeName'],
            );
        }
    }

    $sql_loc = "SELECT * FROM tb_location 
    join tb_locationType on tb_location.locationTypeID = tb_locationType.locationTypeID
    where locationType = 3";     
    $query_loc = $db->query($sql_loc);
    $nums_loc = $db->db_num_rows($query_loc);
    if ($nums_loc > 0) {
        while($rec_loc = $db->db_fetch_array($query_loc)){
            $arr_location[] = array(
                "locationID"=>$rec_loc['locationID'],
                "locationName"=>$rec_loc['locationName'],
            );
        }
    }

    $arr = array(
        "po_head" => $arr_head,
        "po_desc" => $arr_desc,
        "location" => $arr_location,
        "locationType" => $arr_locationType,
    );

    echo json_encode($arr);
}


function getReceiveInfo($id){

    global $db;

    $sql_receive = "SELECT * FROM tb_receive WHERE receiveID = '".$id."' ";
    $query_receive = $db->query($sql_receive);
    $rec_receive = $db->db_fetch_array($query_receive);

    $sql_po = "SELECT * FROM tb_po WHERE poID = '".$rec_receive["poID"]."' ";
    $query_po = $db->query($sql_po);
    $rec_po = $db->db_fetch_array($query_po);

    $sql_sup = "SELECT * FROM tb_supplier WHERE supID = '".$rec_po["supID"]."' ";
    $query_sup = $db->query($sql_sup);
    $rec_sup = $db->db_fetch_array($query_sup);

    if($rec_receive["create_by"] == $_SESSION["sys_id"]) $isCancel = 1;
    else $isCancel = 0;

    $arr_head = array(
        "receiveID" => $rec_receive["receiveID"],
        "poID" => $rec_receive["poID"],
        "receiveDate" => conv_date($rec_receive["receiveDate"]),
        "create_by" => $rec_receive["create_by"],
        "receiveStatus" => $rec_receive["receiveStatus"],
        "sup_name" => $rec_sup["sup_name"],
        "sup_address" => $rec_sup["sup_address"]." ".get_subDistrictID_name($rec_sup["subDistrictID"])." ".get_district_name($rec_sup["districtID"])." ".get_prov_name($rec_sup["provinceID"])." ".$rec_sup["zipcode"],
        "sup_tel" => $rec_sup["sup_tel"],
        "total" => $rec_po["total"],
        "receiveStatus" => $rec_receive["receiveStatus"],
        "receiveStatusName" => get_receiveStatus($rec_receive["receiveStatus"]),
        "isCancel" => $isCancel,
    );

    $sql_pd = "SELECT * FROM tb_po_desc WHERE poID = '".$rec_receive["poID"]."' ";
    $query_pd = $db->query($sql_pd);
    while($rec_pd = $db->db_fetch_array($query_pd))
    {
        $sql_product = "SELECT tb_product.*,tb_locationtype.locationTypeName,tb_location.locationName FROM  tb_product JOIN
        tb_locationtype ON tb_product.locationTypeID = tb_locationtype.locationTypeID JOIN
        tb_location ON tb_product.locationID = tb_location.locationID
        WHERE productID = '".$rec_pd["productID"]."' ";
        $query_product = $db->query($sql_product);
        $rec_product = $db->db_fetch_array($query_product);

        $sql_receive_desc = "SELECT * FROM tb_receive_desc WHERE productID = '".$rec_pd["productID"]."' AND receiveID = '".$id."' ";
        $query_receive_desc = $db->query($sql_receive_desc);
        $rec_receive_desc = $db->db_fetch_array($query_receive_desc);

        $sql_attr = "SELECT tb_attribute.attrName, tb_productattr.value
        FROM tb_productattr JOIN tb_product ON tb_productattr.productID = tb_product.productID
        JOIN tb_attribute ON tb_productattr.attrID = tb_attribute.attrID
        WHERE tb_productattr.productID = '".$rec_pd["productID"]."'";
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

        $arr_desc[] = array(
            "productID"=>$rec_pd['productID'],
            "productCode"=>$rec_product['productCode'],
            "productName"=>$rec_product['productName'],
            "productTypeName"=>get_productType_name($rec_product['productTypeID']),
            "brandName"=>get_brand_name($rec_product['brandID']),
            "modelName" => $rec_product["modelName"] != '' ? $rec_product["modelName"] : '-',
            "productSize" => $rec_product["productSize"] != '' ? $rec_product["productSize"] : '-',
            "price"=>$rec_pd['price'],
            "qty"=>$rec_pd['qty'],
            "amount"=>$rec_pd['amount'],
            "receive_qty"=>$rec_receive_desc['qty'],
            "locationTypeName" => $rec_product['locationTypeName'],
            "locationName" => $rec_product['locationName'],
            "attr" => $attr,
        );
    }

    $arr = array(
        "receive_head" => $arr_head,
        "receive_desc" => $arr_desc,
        // "location" => $arr_location,
    );

    echo json_encode($arr);

}







?>
