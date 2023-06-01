<?php

class GenericDropDownValues {

    static function genericDropDown($query, $selected) {
        $resultset = MysqlConnection::fetchCustom($query);
        $dropdown .= "<select class='form-control' style='width: 100%'>";
        $dropdown .= "<option value=''>Please select</option>";
        foreach ($resultset as $value) {
            $id = $value["id"];
            $drp_name = $value["drp_name"];
            $i_selected = "";
            if ($selected == $id) {
                $i_selected = "selected";
            } else {
                $i_selected = "";
            }
            $dropdown .= "<option $i_selected value='$id'>$drp_name</option>";
        }
        $dropdown .= "</select>";
        echo $dropdown;
    }

    static function genericQuery($querytype, $selected, $profilename) {
        $array = array();
        $array["customer_drp"] = "SELECT id, cust_companyname as drp_name  FROM `customer_master` ORDER BY cust_companyname ASC";
        $array["profile_drp"] = "SELECT id, profilename as drp_name FROM `tbl_portfolio_profile_price` WHERE category = '$profilename' ORDER BY `profilename` ASC";
        $array["clr_brand_drp"] = "SELECT DISTINCT(colorbrand) as drp_name, colorbrand as id FROM tbl_portfolio_profile_colors";
        $array["color_drp"] = "SELECT id, name as drp_name FROM `generic_entry` WHERE `type` = 'shipvia' ORDER BY name";
        $array["shipping_drp"] = "SELECT id, name as drp_name FROM `generic_entry` WHERE `type` = 'shipvia' ORDER BY name";
        self::genericDropDown($array[$querytype], $selected);
    }

    static function customDropdown($name, $selected) {
        $dropdown .= "<select class='form-control' style='width: 100%' name=$name>";
        $dropdown .= "<option value=''>Please select</option>";
        $dropdown .= "<option value='Y'>Yes</option>";
        $dropdown .= "<option value='N'>No</option>";
        $dropdown .= "</select>";
        echo $dropdown;
    }

}
