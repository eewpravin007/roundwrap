<?php

class Vendor {

    static function getVendorDetails($columns = "*") {
        return MysqlConnection::fetchCustom("SELECT $columns FROM `supplier_master`"
                        . " ORDER BY `companyname` ASC");
    }

    static function getVendor($primary) {
        $query = "SELECT * FROM `supplier_master` WHERE supp_id = '$primary' ";
        return MysqlConnection::fetchCustomSingle($query);
    }

}
