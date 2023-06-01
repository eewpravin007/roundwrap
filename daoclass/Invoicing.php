<?php

class Invoicing {

    static function createInvoice($postBody) {
        
    }

    static function editInvoice($postBody) {
        
    }

    static function listInvoice($category = "PVC", $search = array()) {
        $invoice_details = $search["invoice_details"];
        $customer_name = $search["customer_name"];
        $so_number = $search["so_number"];
        $like = "";
        
        if($invoice_details != ""){
            $like.= "AND invoiceno LIKE '%$invoice_details%' ";
        }
        if($customer_name != ""){
            $like.= "AND customername LIKE '%$customer_name%' ";
        }
        if($so_number != ""){
            $like.= "AND so_no LIKE '%$so_number%' ";
        }
        
        $query = "SELECT * FROM `tbl_invoice` WHERE profile = '$category' $like ORDER BY invoiceno DESC";
        return MysqlConnection::fetchCustom($query);
    }

    static function getInvoice($invoiceId) {
        $query = "SELECT * FROM `tbl_invoice` WHERE invoiceno = '$invoiceId'";
        return MysqlConnection::fetchCustomSingle($query);
        
    }

    static function deleteInvoice($invoiceId) {
        
    }

    static function degitSetting($number) {
        
    }

}
