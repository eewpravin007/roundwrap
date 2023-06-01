<?php

class Profiles {

    static function getActiveProfiles($category) {
        $query = "SELECT ps.ps_id, ps.total_pieces, ps.billable_fitsquare, ps.prof_id, ps.sub_prof_id, ( substring_index(ps.color, '-', 1) ) as color_name, "
                . "ps.colorbrand, (SELECT cust_companyname cm FROM customer_master WHERE id = ps.cust_id ) as cust_companyname, "
                . "ps.so_no, ps.po_no, ps.req_date, datediff(ps.req_date, now()) as daysLeft, ps.cust_id "
                . "FROM `packslip` ps WHERE ps.production_update IN ('WORK ORDER CREATED') "
                . "AND ps.prof_id = '$category' AND ps.isLayout != 'Y' ORDER BY sub_prof_id ASC";
        return MysqlConnection::fetchCustom($query);
    }

    static function getProfilesGroup($category) {
        $resultset_profiles = self::getActiveProfiles($category);

        $master_array = array();
        $master_profiles = array();
        $master_profiles_orders = array();

        foreach ($resultset_profiles as $value) {
            if (!in_array($value["sub_prof_id"], $master_profiles)) {
                $master_profiles[] = $value["sub_prof_id"];
            }
            $master_profiles_orders[$value["sub_prof_id"]][] = $value;
        }
        $master_array["profile"] = $master_profiles;
        $master_array["profile_order"] = $master_profiles_orders;
        return $master_array;
    }

    static function groupProfileFromPackingSLip($profilesGroups, $select) {
        $selected = array();
        foreach ($profilesGroups as $value) {
            $psid = $value["ps_id"];
            if (in_array($psid, $select)) {
                $selected["value"][] = $value;
            }
        }
        $selected["psid"] = $select;
        return $selected;
    }

    static function getProfileForMasterPage($category = "PVC") {
        $query = "SELECT * FROM `tbl_portfolio_profile_price` WHERE category = '$category' "
                . "ORDER BY `profilename`, profile ASC";
        $resultset = MysqlConnection::fetchCustom($query);

        $display = array();

        $profilename = array();
        $profiledetails = array();

        foreach ($resultset as $value) {
            $profilename[] = $value["profilename"];
            $profiledetails[] = $value;
        }
        $display[] = array_unique($profilename);
        $display[] = $profiledetails;
        return $display;
    }

    static function getProfileOrderCounter($category = "PVC", $profile = "") {
        if ($profile != "") {
            $profile_like = "";
        }
        $displayordercount = array();
        $query_live = MysqlConnection::fetchCustom("SELECT sub_prof_id, total_pieces FROM rw.`packslip`"
                        . " WHERE prof_id = '$category' $profile_like ORDER BY sub_prof_id");

        $query_bkcp = MysqlConnection::fetchCustom("SELECT sub_prof_id, total_pieces FROM rw_bkup.`packslip`"
                        . " WHERE prof_id = '$category' ORDER BY sub_prof_id");

        foreach ($query_live as $value) {
            $displayordercount[$value["sub_prof_id"]][] = $value["total_pieces"];
        }
        foreach ($query_bkcp as $value) {
            $displayordercount[$value["sub_prof_id"]][] = $value["total_pieces"];
        }

        $displaycounter = array();
        foreach ($displayordercount as $key => $value) {
            $displaycounter[$key] = array_sum($value);
        }
        return $displaycounter;
    }

    static function getProfileDataForReport($category, $profilename = "") {
        $displayorder = array();

        if ($profilename == "") {
            return $displayorder;
        }

        if ($profilename != "") {
            $profile_like = " AND sub_prof_id LIKE '%$profilename%' ";
        }
         
        $columns = "( substring_index(color, '-', 1) ) as color, colorbrand, ps_id, prof_id, sub_prof_id, cust_id, rec_date, req_date,"
                . " total_pieces, (" . Customer::$CUSTOMER_NAME_QUERY . " ps.cust_id = id ) as customername,"
                . " datediff(ps.req_date, now()) as daysLeft, production_update,so_no, po_no ";
        $query_live = "SELECT  $columns "
                . " FROM rw.packslip ps"
                . " WHERE prof_id = '$category' "
                . " $profile_like "
                . " ORDER BY sub_prof_id ASC";
        $result_live = MysqlConnection::fetchCustom($query_live);
        foreach ($result_live as $value) {
            $value["order"] = "Active";
            $displayorder[] = $value;
        }
        $query_bkps = "SELECT $columns "
                . " FROM rw_bkup.packslip ps "
                . " WHERE prof_id = '$category' "
                . " $profile_like "
                . " ORDER BY sub_prof_id ASC";
        $result_bkps = MysqlConnection::fetchCustom($query_bkps);
        foreach ($result_bkps as $value) {
            $value["order"] = "Backup";
            $displayorder[] = $value;
        }
        return $displayorder;
    }

    static function createOrEditProfile($data, $primary) {
        echo $primary;
        if($primary == ""){
            return MysqlConnection::insert("tbl_portfolio_profile_price", $data);
        }else{
            return MysqlConnection::edit("tbl_portfolio_profile_price", $data, " id = '$primary' ");
        }
    }
    
    static function getProfileFromPrimary($primary) {
        $query = "SELECT * FROM tbl_portfolio_profile_price WHERE id = '$primary'  ";
        return MysqlConnection::fetchCustomSingle($query);
    }
    
    static function getAllPrimaryIds($category) {
        $query = "SELECT `id` FROM `tbl_portfolio_profile_price` WHERE category = '$category' ORDER BY `tbl_portfolio_profile_price`.`profilename` ASC";
        return MysqlConnection::fetchCustom($query);
    }
    
}
