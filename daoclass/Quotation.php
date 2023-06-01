<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Quotation
 *
 * @author inspiron 15
 */
class Quotation {

    static function listQuotation($category = "PVC") {
        
        
        
        
        
        $minusdate = date('Y-m-d', strtotime("-120 days"));
        $query = "SELECT qh.*,"
                . " (" . Customer::$CUSTOMER_NAME_QUERY . " id = ps.cust_id ) as cust_companyname  "
                . " FROM `tbl_quotation_history` qh, packslip ps "
        . "WHERE qh.packingslipid = ps.ps_id "
        . "AND ps.prof_id = '$category' AND enterdate > '$minusdate'  "
        . "ORDER BY quoteno DESC";
        return MysqlConnection::fetchCustom($query);
    }

}
