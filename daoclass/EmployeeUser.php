<?php

class EmployeeUser {

    static function createEmployeeUser() {
        
    }

    static function editEmployeeUser() {
        
    }

    static function getEmployeeUser($userId) {
        
    }

    static function deleteEmployeeUser($userId) {
        
    }

    static function listEmployeeUser() {
        return MysqlConnection::fetchCustom("");
    }

    static function searchEmployeeUser($search_param) {
        
    }

    static function createEmployeeUserLogin() {
        
    }

    static function uploadEmployeeAvatar($avatar_details) {
        
    }

    static function ordersByEmployeId($employId) {
        $packingslip = "SELECT"
                . " po_no, so_no, prof_id, sub_prof_id, total_pieces, "
                . " rec_date, production_update , datediff(req_date, now()) as daysLeft, "
                . " (" . Customer::$CUSTOMER_NAME_QUERY . " id = ps.cust_id ) as cust_companyname"
                . " FROM `packslip` ps"
                . " WHERE addedBy LIKE '%$employId%' ORDER BY indexid DESC LIMIT 0,5 ";
        return MysqlConnection::fetchCustom($packingslip);
    }

}
