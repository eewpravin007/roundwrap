<?php

class PackingSlip {

    static function getLast5Orders($limit = "LIMIT 0,5", $inwhere = "") {
        $packingslip = "SELECT"
                . " production_update, po_no, so_no, prof_id, sub_prof_id, total_pieces, rec_date, "
                . " (" . Customer::$CUSTOMER_NAME_QUERY . " id = ps.cust_id ) as cust_companyname,"
                . " datediff(req_date, now()) as daysLeft, isUrgent,ackrecv , ackrecvstatus, total_weight, billable_fitsquare,"
                . " ( substring_index(ps.color, '-', 1) ) as color_name"
                . " FROM `packslip` ps "
                . " WHERE indexid != '' $inwhere "
                . " ORDER BY indexid DESC $limit ";
        return MysqlConnection::fetchCustom($packingslip);
    }

    static function searchPackingSlip($array_where) {
        $columns = $array_where["columns"];
        $order_by = $array_where["order_by"];
        $filter_column = $array_where["where"];

        $packingslip = "SELECT"
                . " $columns , "
                . " (" . Customer::$CUSTOMER_NAME_QUERY . " id = ps.cust_id ) as cust_companyname, "
                . " (SELECT `phase_date` FROM `workorder_phase_history` WHERE `packslipId` = ps.ps_id AND phase = 'PRODUCTION IN' LIMIT 0,1) as prod_in_date"
                . " FROM `packslip` ps WHERE ps_id != '' $filter_column  $order_by ";
        return MysqlConnection::fetchCustomSingle($packingslip);
    }

    static function packingSlipDetails($psid) {
        $query = "SELECT * FROM `packslipdetail` WHERE ps_id = '$psid'";
        return MysqlConnection::fetchCustom($query);
    }

    static function createPackingSlip() {
        $query = "";
        return MysqlConnection::fetchCustomSingle($query);
    }

    static function updatePackingSlip() {
        
    }

    static function productionInStatus($productionstatus) {
        //<span class='badge bg-label-success'>02 APR 22</span>
        switch ($productionstatus) {
            case "PRODUCTION IN - OUT":
                echo "<span class='badge bg-label-warning'>PRODUCTION IN</span>";
                break;
            case "PRODUCTION OUT-OUT":
                echo "<span class='badge bg-label-success'>PRODUCTION OUT</span>";
                break;
            case "DELIVERED":
                echo "<span class='badge bg-label-success'>DELIVERED</span>";
                break;
            case "":
                echo "<span class='badge bg-label-danger'>PACKING SLIP</span>";
                break;
            case "WORK ORDER CREATED":
                echo "<span class='badge bg-label-danger'>WORK ORDER</span>";
                break;
            case "ORDER CREATED":
                echo "<span class='badge bg-label-danger'>ORDER CREATED</span>";
                break;
            default :
                echo "<span class='badge bg-label-warning'>" . $productionstatus . "</span>";
                break;
        }
    }

    static function deliveryLeft($param) {
        if ($param == "0") {
            return "<span class='badge bg-label-warning'>Delivery Today</span>";
        } else if ($param > 0) {
            return "<span class='badge bg-label-success'>" . abs($param) . " Days Left</span>";
        } else {
            return "<span class='badge bg-label-danger'>" . abs($param) . " Days Behind</span>";
        }
    }

    static function searchNumbersFromPackingSlip() {
        $master_search = array();
        $distinct_so = MysqlConnection::fetchCustom("SELECT DISTINCT(so_no) as result FROM `packslip` ORDER BY so_no");
        foreach ($distinct_so as $value) {
            $master_search["so_no"][] = $value["result"];
        }

        $distinct_po = MysqlConnection::fetchCustom("SELECT DISTINCT(po_no) as result FROM `packslip` ORDER BY po_no");
        foreach ($distinct_po as $value) {
            $master_search["po_no"][] = $value["result"];
        }

        $distinct_cl = MysqlConnection::fetchCustom("SELECT DISTINCT(`color`) as result FROM `packslip` ORDER BY color ASC");
        foreach ($distinct_cl as $value) {
            $master_search["color"][] = $value["result"];
        }

        $distinct_pr = MysqlConnection::fetchCustom("SELECT DISTINCT(`sub_prof_id`) as result FROM `packslip` ORDER BY sub_prof_id ASC");
        foreach ($distinct_pr as $value) {
            $master_search["sub_prof_id"][] = $value["result"];
        }
        return $master_search;
    }

    static function otherInProgressOrdersForCustomer($customerId, $status = "neworders") {
        $inprogress = self::getProductionStatus($status);
        $query = "SELECT"
                . " po_no, so_no, prof_id, sub_prof_id, total_pieces, rec_date,"
                . " production_update ,datediff(req_date, now()) as daysLeft "
                . "  "
                . " FROM packslip"
                . " WHERE cust_id = '$customerId' AND isLayout != 'Y' "
                . " AND production_update $inprogress ORDER BY so_no ASC";
        return MysqlConnection::fetchCustom($query);
    }

    static function tracking($so_no, $database = "rw") {
        $workordertrack = MysqlConnection::fetchCustom("SELECT `phase`, count(phase) as count"
                        . " FROM $database.`workorder_phase_history`"
                        . " WHERE `workOrId` = '$so_no' GROUP BY phase");

        $master_result = array();
        foreach ($workordertrack as $value) {

            if ($value["phase"] == "DELIVERY-IN") {
                $value["phase"] = "ORDER DELIVERED";
                $value["color"] = "yellow";
            } else if ($value["phase"] == "ORDER DELIVERED") {
                $value["phase"] = "ORDER DELIVERED";
                $value["color"] = "green";
            } else if ($value["count"] == 2) {
                $value["color"] = "green";
            } else if ($value["count"] == 1) {
                $value["color"] = "yellow";
            } else {
                $value["color"] = "red";
            }
            $master_result[$value["phase"]] = $value;
        }
        return $master_result;
    }

    static function trackingPhase($phase) {
        $array = array();
        $array[] = "WORK ORDER";
        $array[] = "PRODUCTION IN";
        if ($phase == "PVC") {
            $array[] = "CNC";
            $array[] = "SAND/CLEAN";
            $array[] = "GLUE";
            $array[] = "VINYL PRESS AND PACK";
        } else {
            $array[] = "LAMINATE PRESS";
            $array[] = "SAW/BLANKS";
            $array[] = "POSTFORMING";
            $array[] = "SAW/DOOR";
            $array[] = "EDGE BANDING";
            $array[] = "LAMINATE CLEAN/PACK";
        }
        $array[] = "PRODUCTION OUT";
        $array[] = "ORDER DELIVERED";
        return $array;
    }

    static function getTotalOrdersByStation($category) {
        $inprogress = self::getProductionStatus("inprogres");
        $query = "SELECT count(`production_update`) as count, production_update , sum(total_pieces) as total_pieces"
                . " FROM `packslip` WHERE production_update $inprogress"
                . " AND prof_id = '$category' GROUP BY production_update ORDER BY `count` ASC";
        return MysqlConnection::fetchCustom($query);
    }

    static function getProductionStatus($category) {
        $master_array = array();
        $master_array["inprogres"] = " NOT IN ('ORDER DELIVERED-OUT', 'DELIVERY-IN', 'WORK ORDER CREATED', 'ORDER DELIVERED', '')";
        $master_array["delivered"] = " IN ('ORDER DELIVERED-OUT', 'DELIVERY-IN', 'ORDER DELIVERED' )";
        $master_array["packingslip"] = " IN ('')";
        $master_array["workorder"] = " IN ('WORK ORDER CREATED')";
        $master_array["neworders"] = " IN ('', 'WORK ORDER CREATED')";
        return $master_array[$category];
    }

    static function stationWiseReport($station) {
        $query = "SELECT"
                . " po_no, so_no, prof_id, sub_prof_id, total_pieces, rec_date,"
                . " production_update ,datediff(req_date, now()) as daysLeft,"
                . " (" . Customer::$CUSTOMER_NAME_QUERY . " id = ps.cust_id ) as cust_companyname"
                . "  "
                . " FROM packslip ps "
                . " WHERE production_update LIKE '%$station%' AND isLayout != 'Y' ORDER BY so_no ASC";
        return MysqlConnection::fetchCustom($query);
    }

    static function getDelayedOrders($blank = "", $whereand = "") {
        $query = "SELECT so_no, po_no, prof_id, sub_prof_id, total_pieces, total_weight, ps_id, 
            (" . Customer::$CUSTOMER_NAME_QUERY . " id = ps.cust_id ) as cust_companyname,
                datediff(req_date, now()) as daysLeft, ( substring_index(ps.color, '-', 1) ) as color_name,
            cust_id, production_update, production_update_date, rec_date, req_date FROM `packslip` ps
            WHERE isLayout != 'Y' and req_date < CURDATE() $whereand
            ORDER BY req_date ASC";
        return MysqlConnection::fetchCustom($query);
    }

    static function deleteAndCleanPackingSlip($packslipid) {
        MysqlConnection::delete("DELETE FROM packslip WHERE ps_id = '$packslipid' ");
        MysqlConnection::delete("DELETE FROM packslipdetail WHERE ps_id = '$packslipid' ");
        MysqlConnection::delete("DELETE FROM workorder_phase_history WHERE packslipId = '$packslipid' ");
        MysqlConnection::delete("DELETE FROM tbl_track_ps WHERE psid = '$packslipid' ");
    }

}
