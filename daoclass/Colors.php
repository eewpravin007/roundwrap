<?php

class Colors {

    static function getColorDetailsFromCategory($category) {

        if ($category == "PVC") {
            $sub_qyery_total_pieces = "(SELECT SUM(total_pieces) "
                    . "FROM packslip ps "
                    . "WHERE ps.prof_id = '$category' "
                    . "AND ps.`color` LIKE CONCAT('%',pps.colorname, '%') ) as total_pieces ";
            $sub_qyery_total_sqfeet = "(SELECT SUM(billable_fitsquare) "
                    . "FROM packslip ps "
                    . "WHERE ps.prof_id = '$category' "
                    . "AND ps.`color` LIKE CONCAT('%',pps.colorname, '%') ) as billable_fitsquare ";
        } else {
            $sub_qyery_total_pieces = "(SELECT SUM(total_pieces) "
                    . "FROM packslip ps "
                    . "WHERE ps.prof_id = '$category' "
                    . "AND ps.`color` LIKE CONCAT('%',pps.colorname, '%')"
                    . "AND pps.colorbrand = ps.colorbrand ) as total_pieces ";

            $sub_qyery_total_sqfeet = "(SELECT SUM(billable_fitsquare) "
                    . "FROM packslip ps "
                    . "WHERE ps.prof_id = '$category' "
                    . "AND ps.`color` LIKE CONCAT('%',pps.colorname, '%')"
                    . "AND pps.colorbrand = ps.colorbrand ) as billable_fitsquare ";
        }
        $query = "SELECT pps.id, pps.colorname, pps.colorbrand, pps.colorprice , pps.colorcode, "
                . " $sub_qyery_total_pieces, $sub_qyery_total_sqfeet"
                . " FROM tbl_portfolio_profile_colors pps "
                . " WHERE category = '$category' "
                . " ORDER BY total_pieces DESC";
        $result_set = MysqlConnection::fetchCustom($query);
        return $result_set;
    }

    static function getActiveColors($category) {
        $query = "SELECT ps.ps_id, ps.total_pieces, ps.billable_fitsquare, ps.prof_id, ( substring_index(ps.color, '-', 1) ) as color_name, "
                . "ps.colorbrand, (SELECT cust_companyname cm FROM customer_master WHERE id = ps.cust_id ) as cust_companyname, "
                . "ps.so_no, ps.po_no, ps.req_date, datediff(ps.req_date, now()) as daysLeft, ps.cust_id "
                . "FROM `packslip` ps WHERE ps.production_update IN ('WORK ORDER CREATED') "
                . "AND ps.prof_id = '$category' AND ps.isLayout != 'Y' ORDER BY color_name ASC";
        return MysqlConnection::fetchCustom($query);
    }

    ///SELECT DISTINCT( substring_index(color, '-', 1) ) as color_name FROM `packslip` WHERE prof_id = 'PVC' ORDER BY color_name ASC

    static function getColorGroup($category) {
        $resultset_color = self::getActiveColors($category);

        $master_array = array();
        $master_colors = array();
        $master_colors_orders = array();

        foreach ($resultset_color as $value) {
            if (!in_array($value["color_name"], $master_colors)) {
                $master_colors[] = $value["color_name"];
            }
            $master_colors_orders[$value["color_name"]][] = $value;
        }
        $master_array["color"] = $master_colors;
        $master_array["color_order"] = $master_colors_orders;
        return $master_array;
    }

    static function groupColorsFromPackingSLip($colorGroups, $select) {
        $selected = array();
        foreach ($colorGroups as $value) {
            $psid = $value["ps_id"];
            if (in_array($psid, $select)) {
                $selected["value"][] = $value;
            }
        }
        $selected["psid"] = $select;
        return $selected;
    }

    static function getColorList($category = "PVC", $columns = "*") {
        $query = "SELECT $columns FROM `tbl_portfolio_profile_colors` "
                . " WHERE category = '$category'"
                . " ORDER BY `tbl_portfolio_profile_colors`.`colorname` ASC";
        return MysqlConnection::fetchCustom($query);
    }

    static function getColorSearchColum($category, $columns) {
        $result = self::getColorList($category, $columns);
        $displayarray = array();
        foreach ($result as $value) {
            $displayarray[] = $value[$columns];
        }
        return array_unique($displayarray);
    }

    static function getOrdersByColors($category = "PVC") {

        $color_orders = array();
        $color_orders_result = array();

        $query_live = "SELECT ( substring_index(color, '-', 1) ) as color, total_pieces "
                . "FROM rw.packslip WHERE prof_id = '$category' ORDER BY color ASC";
        $result_live = MysqlConnection::fetchCustom($query_live);

        foreach ($result_live as $value) {
            $color_orders[$value["color"]][] = $value["total_pieces"];
        }


        $query_bkps = "SELECT ( substring_index(color, '-', 1) ) as color, total_pieces "
                . "FROM rw_bkup.packslip WHERE prof_id = '$category' ORDER BY color ASC";
        $result_bkps = MysqlConnection::fetchCustom($query_bkps);

        foreach ($result_bkps as $value) {
            $color_orders[$value["color"]][] = $value["total_pieces"];
        }

        foreach ($color_orders as $key => $value) {
            $color_orders_result[$key] = array_sum($value);
        }
        return $color_orders_result;
    }

    static function getOrdersByColorName($category = "PVC", $colorName, $brandname) {
        $displayorder = array();

        if ($colorName == "" && $brandname == "") {
            return $displayorder;
        }

        if ($colorName != "") {
            $color_like = " AND color LIKE '%$colorName%' ";
        }
        if ($brandname != "") {
            $brand_like = " AND colorbrand LIKE '%$brandname%' ";
        }
        $columns = "( substring_index(color, '-', 1) ) as color, colorbrand, ps_id, prof_id, sub_prof_id, cust_id, rec_date, req_date,"
                . " total_pieces, (" . Customer::$CUSTOMER_NAME_QUERY . " ps.cust_id = id ) as customername,"
                . " datediff(ps.req_date, now()) as daysLeft, production_update,so_no, po_no ";
        $query_live = "SELECT  $columns "
                . " FROM rw.packslip ps"
                . " WHERE prof_id = '$category' "
                . " $color_like $brand_like "
                . " ORDER BY color ASC";
        $result_live = MysqlConnection::fetchCustom($query_live);
        foreach ($result_live as $value) {
            $value["order"] = "Active";
            $displayorder[] = $value;
        }
        $query_bkps = "SELECT $columns "
                . " FROM rw_bkup.packslip ps "
                . " WHERE prof_id = '$category' "
                . " $color_like $brand_like "
                . " ORDER BY color ASC";
        $result_bkps = MysqlConnection::fetchCustom($query_bkps);
        foreach ($result_bkps as $value) {
            $value["order"] = "Backup";
            $displayorder[] = $value;
        }
        return $displayorder;
    }

    static function getColorByPrimary($param) {
        $query = "SELECT * FROM `tbl_portfolio_profile_colors` WHERE `id` = '$param'";
        return MysqlConnection::fetchCustomSingle($query);
    }

    static function saveEditColor($param, $data) {
        if ($param == "") {
            MysqlConnection::insert("tbl_portfolio_profile_colors", $data);   
        } else {
            MysqlConnection::edit("tbl_portfolio_profile_colors", $data, "`id` = '$param' ");   
            
        }
    }

}
