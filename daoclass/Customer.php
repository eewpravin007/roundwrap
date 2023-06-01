<?php

class Customer {

    static $CUSTOMER_NAME_QUERY = "SELECT cust_companyname cm FROM customer_master WHERE ";

    static function customerNameById() {
        
    }

    static function getCustomerDetails($columns) {
        return MysqlConnection::fetchCustom("SELECT $columns FROM `customer_master`"
                        . " ORDER BY `customer_master`.`cust_companyname` ASC");
    }

    static function getCustomerDetailsById($columns, $primary) {
        return MysqlConnection::fetchCustomSingle("SELECT $columns FROM `customer_master` WHERE id = '$primary' ");
    }

    static function top5Customers() {
        
    }

    static function getCustomerById($id) {
        $columns = "defaultsqfeet, firstname, lastname, cust_companyname, "
                . "cust_email, mobileno, country, billto, cust_fax, phno, "
                . "enable_tracking, portalUser, status";
        $customer_result = MysqlConnection::fetchCustom("SELECT $columns FROM `customer_master` "
                        . "WHERE id = '$id' ");
        return $customer_result[0];
    }

    static function doorInCustomer($customerid, $clause) {
        $rw_single_query = "SELECT sum(total_pieces) as total_pieces FROM packslip"
                . " WHERE cust_id = '$customerid'"
                . " AND production_update $clause ('DELIVERY-IN', 'ORDER DELIVERED-OUT', 'ORDER DELIVERED', 'PRODUCTION OUT-OUT')";
        $rw_single = MysqlConnection::fetchCustomSingle($rw_single_query);
        $rwbku_single_query = "SELECT sum(total_pieces) as total_pieces "
                . "FROM rw_bkup.packslip where cust_id = '$customerid' "
                . "AND production_update "
                . "NOT $clause ('DELIVERY-IN', 'ORDER DELIVERED-OUT', 'ORDER DELIVERED', 'PRODUCTION OUT-OUT')";
        $rwbku_single = MysqlConnection::fetchCustomSingle($rwbku_single_query);
        return $rw_single["total_pieces"] + $rwbku_single["total_pieces"];
    }

    static function getCustomerNameAndOtherDetails() {
        return MysqlConnection::fetchCustom("SELECT "
                        . "cm.id, cm.cust_companyname, cm.defaultsqfeet, sum(ps.total_pieces) as total_pieces,"
                        . "cm.enable_tracking,cm.portalUser,cm.phno,cm.cust_email,cm.status "
                        . "FROM `customer_master` cm, packslip ps "
                        . "WHERE cm.id = ps.cust_id "
                        . "GROUP BY cm.id "
                        . "ORDER BY total_pieces DESC");
    }

    static function globleSearch($search) {
        $columns_info = "cm.id, cm.cust_companyname, ps.so_no, ps.po_no, ( substring_index(color, '-', 1) ) as color_name,"
                . " ps.prof_id, ps.sub_prof_id, ps.rec_date, datediff(ps.req_date, now()) as daysLeft, ps.isUrgent, ps.total_pieces, "
                . " ps.location, ps.production_update ";
         
        return MysqlConnection::fetchCustom("SELECT $columns_info "
                        . "FROM `customer_master` cm, packslip ps "
                        . "WHERE cm.id = ps.cust_id "
                        . " $search "
                        . "");
    }

    static function customerOrderCountPerYear($customerid, $year) {
        $query_live = MysqlConnection::fetchCustomSingle("SELECT sum(total_pieces) as doorCount FROM rw.`packslip` WHERE "
                        . "cust_id = '$customerid' AND `rec_date` LIKE '%$year-%'");
        $query_back = MysqlConnection::fetchCustomSingle("SELECT sum(total_pieces) as doorCount FROM rw_bkup.`packslip` WHERE "
                        . "cust_id = '$customerid' AND `rec_date` LIKE '%$year-%'");
        return $query_live["doorCount"] + $query_back["doorCount"];
    }

    static function customerDoorDetailsPerYear($customerid, $year) {
        $columns = "  ps_id, po_no, so_no, prof_id, sub_prof_id, total_pieces, rec_date, total_weight, billable_fitsquare,  "
                . "( substring_index(color, '-', 1) ) as color_name ";
        $query_live = MysqlConnection::fetchCustom("SELECT $columns FROM rw.`packslip` WHERE "
                        . "cust_id = '$customerid' AND `rec_date` LIKE '%$year-%' ORDER BY rec_date ASC");
        $query_back = MysqlConnection::fetchCustom("SELECT $columns FROM rw_bkup.`packslip` WHERE "
                        . "cust_id = '$customerid' AND `rec_date` LIKE '%$year-%'  ORDER BY rec_date ASC");
        return array_merge($query_back, $query_live);
    }

}
