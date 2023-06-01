<?php

require_once 'PHPMailer-master/PHPMailerAutoload.php';

class MysqlConnection {

    static function connect() {
        $DB_NAME = "rw";
        $DB_HOST = "localhost";
        $DB_USER = "root";
        $DB_PASS = "";
        $connection = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        return $connection;
    }

    static function printMe($value) {
        echo "<pre>";
        print_r($value);
        echo "<pre/>";
    }

    static function getPageNameFromURL($pagename) {
        $explode = explode("_", $pagename);
        if (count($explode) >= 2) {
            return $include = $explode[1] . "/" . $pagename;
        } else {
            return $include = "dashboard/analytics_dashboard";
        }
    }

    static function connectToDiffrent($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
        return mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    }

    static function executeQuery($query) {
        $connect = MysqlConnection::connect();
        $mysqli_query = mysqli_query($connect, $query);
        $connect->close();
        return $mysqli_query;
    }

    static function getPrimary($tbl = "") {
        $mysqlprimary = MysqlConnection::fetchCustom("show index from $tbl where Key_name = 'PRIMARY'");
        return $mysqlprimary[0]["Column_name"];
    }

    static function getNextValue($type = "") {
        if ($type == "PO") {
            $sql = "SELECT `purchaseOrderId` as next FROM `purchase_order` ORDER BY `idindex` DESC LIMIT 0,1";
        } else {
            $sql = "SELECT `sono`  as next FROM `sales_order` ORDER BY `idindex` DESC LIMIT 0,1";
        }
        $resultset = MysqlConnection::fetchCustom($sql);
        $result = $resultset[0];
        if ($result["next"] == "") {
            return "1000";
        } else {
            return $result["next"] + 1;
        }
    }

    static function insert($tbl = "", $data = array()) {
        $connect = MysqlConnection::connect();
        $promarykeycolumn = MysqlConnection::getPrimary($tbl);
        $primarykey = md5(time() . "" . rand(0000000, 9999999));
        $data[$promarykeycolumn] = $primarykey;
        try {
            $keysset = "";
            $valuesset = "";
            foreach ($data as $key => $values) {
                $keysset .= "`" . $key . "`,";
                $valuesset .= "'" . mysqli_real_escape_string($connect, trim($values)) . "',";
            }
            echo $query = " INSERT INTO $tbl (" . substr($keysset, 0, strlen($keysset) - 1) . ") VALUES (" . substr($valuesset, 0, strlen($valuesset) - 1) . ");";
            //echo "<br/>";
            MysqlConnection::executeQuery($query);
            return $primarykey;
        } catch (Exception $exc) {
            echo "<span style='color:red'>SQL QUERY ERROR !!! INSERT !!!" . $exc->getMessage() . "<span>";
        }
    }

    static function edit($tbl = "", $data = array(), $where = "") {
        $connect = MysqlConnection::connect();
        try {
            $update = "";
            foreach ($data as $key => $values) {
                $update .= "`" . $key . "` = " . "'" . mysqli_real_escape_string($connect, trim($values)) . "',";
            }
            echo $query = " UPDATE $tbl SET " . substr($update, 0, strlen($update) - 1) . " WHERE $where ";
            return MysqlConnection::executeQuery($query);
        } catch (Exception $exc) {
            echo "<span style='color:red'>SQL QUERY ERROR !!! EDIT !!!" . $exc->getMessage() . "<span>";
        }
    }

    static function deleteOperation($tblname, $primaryid, $primaryvalue) {
        $query = "DELETE FROM $tblname WHERE $primaryid = '$primaryvalue' ";
        MysqlConnection::executeQuery($query);
    }
    
    static function delete($query) {
        try {
            MysqlConnection::executeQuery($query);
            return "";
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }

    static function toArrays($resource) {
        $arrayList = array();
        while ($rows = mysqli_fetch_assoc($resource)) {
            array_push($arrayList, $rows);
        }
        return $arrayList;
    }

    static function fetchCustom($query) {
        $resource = MysqlConnection::executeQuery($query);
        return MysqlConnection::toArrays($resource);
    }

    static function fetchCustomSingle($query) {
        $resource = MysqlConnection::executeQuery($query);
        $resource_result = MysqlConnection::toArrays($resource);
        return $resource_result[0];
    }
    
    static function fetchCustomSingleCounter($query) {
        $resource = MysqlConnection::executeQuery($query);
        $resource_result = MysqlConnection::toArrays($resource);
        return $resource_result[0]["count"];
    }

    static function exchangeArray($POST, $unset_array = array()) {
        foreach ($unset_array as $keys) {
            unset($POST[$keys]);
        }
        return $POST;
    }

    static function uploadFile($objfile, $destination) {
        $modifiedName = str_replace(" ", "_", $objfile["name"]);
        $fname = $destination . "" . $modifiedName;
        move_uploaded_file($objfile["tmp_name"], $fname);
        return empty($objfile["name"]) ? "" : $fname;
    }

    static function readFile($file_name) {
        $handle = fopen($file_name, 'rb') or die("error opening file");
        $contains = fread($handle, filesize($file_name));
        fclose($handle) or die("error closing file handle");
        return $contains;
    }

    // when we store this to database 
    static function formatToBRAddress($address) {
        $exp = explode("\n", $address);
        $buildaddress = "";
        foreach ($exp as $value) {
            //$buildaddress = $buildaddress . "" . trim($value) . "<br/>";
            if (trim($value) != "" && trim($value) != "-") {
                $buildaddress = $buildaddress . "" . trim($value) . "<br/>";
            }
        }
        return preg_replace('#(<br */?>\s*)+#i', '<br />', $buildaddress);
    }

    // when we retrive this from database  
    static function formatToSlashNAddress($address) {
        $exp = explode("<br />", $address);
        $buildaddress = "";
        foreach ($exp as $value) {
            $buildaddress = $buildaddress . "" . trim($value) . "\n";
        }
        return preg_replace("/[\r\n]+/", "\n", $buildaddress);
    }

}
