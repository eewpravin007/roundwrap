<?php
 
class IncomingOrder {
    
    static function getIncomingOrderDetails(){
        return MysqlConnection::fetchCustom("SELECT * FROM `packslip_customer`");
    }
    
}
