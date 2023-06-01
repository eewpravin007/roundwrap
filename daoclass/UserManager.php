<?php

class UserManager {

    static function updateUserDetails($postedarray, $id) {
        MysqlConnection::edit("user_master", $postedarray, " user_id = '$id' ");
    }

    static function getAllUserDetails() {
        $query = "SELECT * FROM `user_master` ORDER BY `user_master`.`firstName` ASC";
        return MysqlConnection::fetchCustom($query);
    }

    static function getUserFronLogin($userid) {
        return MysqlConnection::fetchCustomSingle("SELECT * FROM user_master WHERE user_id =  '$userid'");
    }

    static function getUserMenus($type) {
        $userid = filter_input(INPUT_GET, "userid");
        if (!empty($userid)) {
            $resultset = MysqlConnection::fetchCustom("SELECT * FROM `tbl_user_menu_mapping` where mainmenu = '$type' AND userid = '$userid'  ");
            $array = array();
            foreach ($resultset as $value) {
                array_push($array, $value["mainmenu"] . "$$" . $value["submenu"]);
            }
            return $array;
        }
    }

    static function getSettingArray() {
        $array = array();
        $array["master"] = array("item_master", "customer_master", "vendor_master", "profile_master", "edit_master", "tax_info_master", "color_master", "workstation_master", "production_tracking", "category_master", "alphacam_master", "profile_label"); //"step_integration" //"profile_price", "pvc_preferencemaster"
        $array["retail"] = array("purchase_orders", "sales_order", "back_order", "retail_invoice", "item_discrepancy");
        $array["production"] = array("packing_slip", "quotation", "work_order", "production_invoice");
        $array["system"] = array("user_management", "update_password", "email_setup", "email_template", "excel_import", "excel_download"); //"scanner_details",
        return $array;
    }

    static function getLoginHistory($userid) {
        $query = "SELECT * FROM `tbl_login_history` WHERE emailid = '$userid' ORDER BY logindate DESC ";
        $resultset = MysqlConnection::fetchCustom($query);
        $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 15, date('Y')));
        MysqlConnection::delete("DELETE FROM tbl_login_history WHERE logindate <= '$date' ");
        return $resultset;
    }

}
