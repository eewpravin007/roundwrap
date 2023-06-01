<?php

class HistoryOrders {

    static function getValidSoumber($so_number = "") {
        $so_found = "NO";
        $real_order = MysqlConnection::fetchCustomSingle("SELECT so_no FROM rw.packslip WHERE so_no = '$so_number' ");
        if ($real_order["so_no"] != "") {
            $so_found = "rw";
        } else {
            $backup_order = MysqlConnection::fetchCustomSingle("SELECT so_no FROM rw_bkup.packslip WHERE so_no = '$so_number' ");
            if ($backup_order["so_no"] != "") {
                $so_found = "rw_bkup";
            }
        }
        return $so_found;
    }

    static function getPackingSlipDetails($so_number = "") {
        $database = self::getValidSoumber($so_number);
        $master_array = array();
        if ($database != "NO") {

            $query_order = "SELECT * FROM $database.packslip WHERE so_no = '$so_number' ";
            $master_array["order"] = MysqlConnection::fetchCustomSingle($query_order);

            $ps_id = $master_array["order"]["ps_id"];
            $query_item = "SELECT * FROM $database.packslipdetail WHERE ps_id = '$ps_id' ";
            $master_array["items"] = MysqlConnection::fetchCustom($query_item);

            $master_array["db"] = $database;
        }
        return $master_array;
    }

    static function getPackingSlipDetailsByPo($po_number = "") {
        $columns = "ps_id, po_no ,so_no, prof_id, sub_prof_id, ( substring_index(ps.color, '-', 1) ) as color_name, rec_date";
        $like = "LIKE '%$po_number%'";
        $master_array = array();

        $customerquery = Customer::$CUSTOMER_NAME_QUERY;
        
        $query_order = "SELECT $columns, ($customerquery id = ps.cust_id ) as customername  FROM rw.packslip ps WHERE po_no $like ";
        $liveresult = MysqlConnection::fetchCustom($query_order);

        $query_item = "SELECT $columns, ($customerquery  id = ps.cust_id ) as customername  FROM  rw_bkup.packslip ps WHERE po_no $like ";
        $historyresult = MysqlConnection::fetchCustom($query_item);

        foreach ($liveresult as $value) {
            $value["db"] = "rw";
            $master_array[] = $value;
        }

        foreach ($historyresult as $value) {
            $value["db"] = "rw_bkup";
            $master_array[] = $value;
        }

        return $master_array;
    }

    static function getOrderYear($customerid) {
        $mergearray = array();
        $live_result = MysqlConnection::fetchCustom("SELECT "
                        . "( substring_index(`rec_date`, '-', 1) ) as rec_date "
                        . "FROM rw.packslip WHERE cust_id = '$customerid' ORDER BY rec_date DESC ");
        foreach ($live_result as $value) {
            $mergearray[$value["rec_date"]] = $value["rec_date"];
        }


        $live_backup = MysqlConnection::fetchCustom("SELECT "
                        . "( substring_index(`rec_date`, '-', 1) ) as rec_date "
                        . "FROM rw_bkup.packslip WHERE cust_id = '$customerid' ORDER BY rec_date DESC  ");
        foreach ($live_backup as $value) {
            $mergearray[$value["rec_date"]] = $value["rec_date"];
        }
        return array_keys($mergearray);
    }

}
