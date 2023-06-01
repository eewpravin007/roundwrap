<?php

class Production {

    static function putOrderInProdIn($keys) {
        $production_update_date = date("Y-m-d");
        $incause = "'" . implode("','", $keys) . "'";
        $query = " UPDATE packslip "
                . " SET production_update = 'PRODUCTION IN - OUT', production_update_date = '$production_update_date' "
                . " WHERE ps_id IN($incause) ";
        MysqlConnection::executeQuery($query);
    }

    static function getPackingSlipLastProductionUpdate($ps_id) {
        $query = "SELECT cust_id, ps_id, so_no, production_update, sub_prof_id FROM packslip WHERE ps_id = '$ps_id' ";
        return MysqlConnection::fetchCustomSingle($query);
    }

    static function createEntryForTracking($ordersList, $phase_in_out) {
        $expload = explode("-", $phase_in_out);
        $phase = $expload[0];
        $status = $expload[1];
        foreach ($ordersList as $order) {
            $arrscanner = array();
            $arrscanner["cust_id"] = $order["cust_id"];
            $arrscanner["packslipId"] = $order["ps_id"];
            $arrscanner["workOrId"] = $order["so_no"];
            $arrscanner["phase_date"] = date("Y-m-d");
            $arrscanner["phase_time"] = date("g:i A");
            $arrscanner["phase"] = trim($phase);
            $arrscanner["phase_description"] = trim($phase);
            $arrscanner["phaseno"] = "0";
            $arrscanner["enterby"] = "";
            $arrscanner["alertHistory"] = "-";
            $arrscanner["workInCode"] = "-";
            $arrscanner["workOutCode"] = "-";
            $arrscanner["status"] = trim($status);
            $arrscanner["phaseno"] = "1";
            MysqlConnection::insert("workorder_phase_history", $arrscanner);
        }
    }

    static function createTrackingEvent($order) {
        $phasestatus = $order["phase"] . "-" . $order["status"];
        $location = $order["location"];
        $production_update_date = date("Y-m-d");
        $query = " UPDATE packslip "
                . " SET production_update = '$phasestatus' , "
                . " production_update_date = '$production_update_date',"
                . " location = '$location' "
                . " WHERE ps_id = '" . $order["ps_id"] . "' ";
        MysqlConnection::executeQuery($query);
        $arrscanner = array();
        $arrscanner["cust_id"] = $order["cust_id"];
        $arrscanner["packslipId"] = $order["ps_id"];
        $arrscanner["workOrId"] = $order["so_no"];
        $arrscanner["phase_date"] = date("Y-m-d");
        $arrscanner["phase_time"] = date("g:i A");
        $arrscanner["phase"] = trim($order["phase"]);
        $arrscanner["phase_description"] = trim($order["phase"]);
        $arrscanner["phaseno"] = "0";
        $arrscanner["enterby"] = "Touch-Scanner";
        $arrscanner["alertHistory"] = $order["alertHistory"];
        $arrscanner["workInCode"] = "-";
        $arrscanner["workOutCode"] = "-";
        $arrscanner["status"] = trim($order["status"]);
        $arrscanner["phaseno"] = "1";
        MysqlConnection::insert("workorder_phase_history", $arrscanner);
    }

    static function trackingPortalPhase($phase) {
        $array = array();
        if ($phase == "PVC") {
            $array[] = "CNC";
            $array[] = "SAND/CLEAN";
            $array[] = "GLUE";
            $array[] = "VINYL PRESS AND PACK";
        } else if ($phase == "LAMINATE") {
            $array[] = "LAMINATE PRESS";
            $array[] = "SAW/BLANKS";
            $array[] = "POSTFORMING";
            $array[] = "SAW/DOOR";
            $array[] = "EDGE BANDING";
            $array[] = "LAMINATE CLEAN/PACK";
        }
        return $array;
    }

    static function getTrackingWhere($wrokstation) {
        $array["CNC"] = " WHERE production_update IN ('PRODUCTION IN - OUT', 'CNC-IN') "; //, 'CNC-OUT'
        $array["SAND/CLEAN"] = "  WHERE production_update IN ('CNC-OUT', 'SAND/CLEAN-IN')  "; //, 'SAND/CLEAN-OUT'
        $array["GLUE"] = "  WHERE production_update IN ('SAND/CLEAN-OUT', 'GLUE-IN')  "; //, 'GLUE-OUT'
        $array["VINYL PRESS AND PACK"] = "  WHERE production_update IN ('GLUE-OUT', 'VINYL PRESS AND PACK-IN')  "; //, 'VINYL PRESS AND PACK-OUT'
        /// SETTING FOR LAMINATE
        $array["LAMINATE PRESS"] = " WHERE production_update IN ('PRODUCTION IN - OUT', 'LAMINATE PRESS-IN') "; //, 'LAMINATE PRESS-OUT
        $array["SAW/BLANKS"] = " WHERE production_update IN ('LAMINATE PRESS-OUT', 'SAW/BLANKS-IN') "; //, 'SAW/BLANKS-OUT'
        $array["POSTFORMING"] = " WHERE production_update IN ('SAW/BLANKS-OUT', 'POSTFORMING-IN') "; //, 'POSTFORMING-OUT'
        $array["SAW/DOOR"] = " WHERE production_update IN ('POSTFORMING-OUT', 'SAW/DOOR-IN') "; //, 'SAW/DOOR-OUT'
        $array["EDGE BANDING"] = " WHERE production_update IN ('SAW/DOOR-OUT', 'EDGE BANDING-IN') "; //, 'EDGE BANDING-OUT'
        $array["LAMINATE CLEAN/PACK"] = " WHERE production_update IN ('EDGE BANDING-OUT', 'LAMINATE CLEAN/PACK-IN') "; //, 'LAMINATE CLEAN/PACK-OUT'
        return $array[$wrokstation];
    }

    static function getRecordsForStationTracking($wrokstation, $category, $subprofile = "") {
        $where = self::getTrackingWhere($wrokstation);
        if ($subprofile != "") {
            $subprofile = " AND sub_prof_id = 'PRESSING'";
        }
        $clmnames = "production_update, req_date, sub_prof_id, total_pieces, "
                . "( substring_index(color, '-', 1) ) as color_name, ps_id, "
                . "workOrd_Id, seq_no,po_no, colorbrand, req_date, "
                . "req_date, production_update, isUrgent, ps_id, datediff(req_date, now()) as daysLeft,"
                . " (SELECT cust_companyname cm FROM customer_master WHERE id = ps.cust_id ) as cust_companyname ";
        $query = "SELECT $clmnames FROM `packslip` ps $where"
                . " AND prof_id = '$category'"
                . " $subprofile"
                . " AND isUrgent IN ('Y', 'N')"
                . " ORDER BY isUrgent DESC";
        return MysqlConnection::fetchCustom($query);
    }

    static function getTrackingHistory($psid) {
        $query = "SELECT phase, status, workOrId, phase_date, phase_time, remake FROM workorder_phase_history "
                . "WHERE packslipId = '$psid' ORDER BY iindex DESC";
        return MysqlConnection::fetchCustom($query);
    }

    static function setRemakeOrder($remakeDoor, $location, $phase, $packslip) {
        MysqlConnection::executeQuery("UPDATE workorder_phase_history "
                . "SET remake = '$remakeDoor' "
                . ", location = '$location' "
                . "WHERE phase = '$phase'"
                . "AND packslipId = '$packslip' ");
    }

    static function getShortPackingSLip($psid) {
        $clmnames = "production_update, req_date, sub_prof_id, total_pieces, "
                . "( substring_index(color, '-', 1) ) as color_name, ps_id, location, "
                . " so_no, seq_no,po_no, colorbrand, req_date, "
                . " isUrgent, datediff(req_date, now()) as daysLeft,"
                . " (SELECT cust_companyname cm FROM customer_master WHERE id = ps.cust_id ) as cust_companyname ";
        $query = "SELECT $clmnames FROM `packslip` ps WHERE ps_id = '$psid' ";
        return MysqlConnection::fetchCustomSingle($query);
    }

    static function getShortPackingSLipBySo($sono) {
        $clmnames = "production_update, req_date, sub_prof_id, total_pieces, "
                . "( substring_index(color, '-', 1) ) as color_name, ps_id, location, "
                . " so_no, seq_no,po_no, colorbrand, req_date, "
                . " isUrgent, datediff(req_date, now()) as daysLeft,"
                . " (SELECT cust_companyname cm FROM customer_master WHERE id = ps.cust_id ) as cust_companyname ";
        $query = "SELECT $clmnames FROM `packslip` ps WHERE so_no = '$sono' ";
        return MysqlConnection::fetchCustomSingle($query);
    }

    static function trackingPortalButtonName($phase) {
        $array["PRODUCTION IN - OUT"] = "CNC-IN";
        $array["CNC-IN"] = "CNC-OUT";
        $array["CNC-OUT"] = "SAND/CLEAN-IN";
        $array["SAND/CLEAN-IN"] = "SAND/CLEAN-OUT";
        $array["SAND/CLEAN-OUT"] = "GLUE-IN";
        $array["GLUE-IN"] = "GLUE-OUT";
        $array["GLUE-OUT"] = "VINYL PRESS AND PACK-IN";
        $array["VINYL PRESS AND PACK-IN"] = "VINYL PRESS AND PACK-OUT";

        $array["VINYL PRESS AND PACK-OUT"] = "LAMINATE PRESS-IN";
        $array["LAMINATE PRESS-IN"] = "LAMINATE PRESS-OUT";
        $array["LAMINATE PRESS-OUT"] = "SAW/BLANKS-IN";
        $array["SAW/BLANKS-IN"] = "SAW/BLANKS-OUT";
        $array["SAW/BLANKS-OUT"] = "POSTFORMING-IN";
        $array["POSTFORMING-IN"] = "POSTFORMING-OUT";
        $array["POSTFORMING-OUT"] = "SAW/DOOR-IN";
        $array["SAW/DOOR-IN"] = "SAW/DOOR-OUT";
        $array["SAW/DOOR-OUT"] = "EDGE BANDING-IN";
        $array["EDGE BANDING-IN"] = "EDGE BANDING-OUT";
        $array["EDGE BANDING-OUT"] = "LAMINATE CLEAN/PACK-IN";
        $array["LAMINATE CLEAN/PACK-IN"] = "LAMINATE CLEAN/PACK-OUT";

        $expload = explode("-", $array[$phase]);
        return $expload[1];
    }

    static function trackingNotesFromAdmin() {
        $start_date = date("Y-m-d");
        $qyery = "SELECT * FROM `tbl_empnote_template` WHERE `startDate` = '$start_date'";
        return MysqlConnection::fetchCustom($qyery);
    }

    static function createPlanning($category, $date = "") {
        if ($date != "") {
            $date_where = " AND req_date = '$date' ";
        }
        $clmnames = "production_update, req_date, sub_prof_id, total_pieces, "
                . "( substring_index(color, '-', 1) ) as color_name, ps_id, location, "
                . " so_no, seq_no,po_no, colorbrand, req_date, "
                . " isUrgent, datediff(req_date, now()) as daysLeft, "
                . " (SELECT cust_companyname cm FROM customer_master WHERE id = ps.cust_id ) as cust_companyname ";
        $query = "SELECT $clmnames "
                . " FROM `packslip` ps WHERE `production_update` "
                . " NOT IN ('DELIVERY-IN', 'ORDER DELIVERED', 'PRODUCTION OUT-OUT', 'ORDER DELIVERED-OUT')"
                . " AND isLayout != 'Y' "
                . " AND prof_id = '$category' "
                . " $date_where ORDER BY req_date ASC";
        $resultset = MysqlConnection::fetchCustom($query);
        $filter_result = array();
        foreach ($resultset as $value) {
            $filter_result[$value["req_date"]][] = $value;
        }
        return $filter_result;
    }

    static function getProdOrderStatestic($counter_for) {
        $queryproduction_pvc = "SELECT ps.total_pieces "
                . " FROM  `packslip` ps , customer_master cm"
                . " WHERE cm.id = ps.cust_id "
                . " AND prof_id = 'PVC' AND sub_prof_id != 'PRESSING'  "
                . " AND ps.`workOrd_Id` != '-'"
                . " AND production_update = 'WORK ORDER CREATED'"
                . " AND ps.packlebelsback != 'HOLD' "
                . " ORDER BY ps.`workOrd_Id`, ps.color, ps.req_date  DESC ";
        $pvc = MysqlConnection::fetchCustom($queryproduction_pvc);
        $total_door_pvc = 0;
        foreach ($pvc as $packinfo) {
            $total_door_pvc = $total_door_pvc + $packinfo["total_pieces"];
        }
        $array["pvccount"] = $total_door_pvc;

        $queryproductionlaminate = "SELECT ps.total_pieces "
                . " FROM  `packslip` ps , customer_master cm"
                . " WHERE cm.id = ps.cust_id "
                . " AND prof_id = 'LAMINATE' AND sub_prof_id != 'PRESSING'  "
                . " AND ps.`workOrd_Id` != '-'"
                . " AND production_update = 'WORK ORDER CREATED'"
                . " AND ps.packlebelsback != 'HOLD' "
                . " ORDER BY ps.`workOrd_Id`, ps.color, ps.req_date  DESC ";
        $laminate = MysqlConnection::fetchCustom($queryproductionlaminate);
        $total_doorlaminate = 0;
        foreach ($laminate as $packinfo) {
            $total_doorlaminate = $total_doorlaminate + $packinfo["total_pieces"];
        }
        $array["lamicount"] = $total_doorlaminate;
        return $array[$counter_for];
    }

    static function getTrackingDashboardCounter($category, $status, $date_current, $phase) {
        //        if (($category == "PVC" || $category == "LAMINATE") && $status == "IN") {
        //            $phase = "PRODUCTION IN";
        //        } else if ($category == "PVC" && $status == "OUT") {
        //            $phase = "VINYL PRESS AND PACK";
        //        } else if ($category == "LAMINATE" && $status == "OUT") {
        //            $phase = "LAMINATE CLEAN/PACK";
        //        }
        $query = "SELECT sum(ps.total_pieces) as totalDoors FROM packslip ps, workorder_phase_history wph "
                . "WHERE ps.ps_id = wph.packslipId "
                . "AND wph.phase_date IN ('$date_current') "
                . "AND wph.phase = '$phase' "
                . "AND wph.status = '$status' AND ps.prof_id = '$category'";
        $result = MysqlConnection::fetchCustomSingle($query);
        return $result["totalDoors"];
    }

    static function getTrackingDashboardCounterBulk($category, $status, $date_current) {
        if (($category == "PVC" || $category == "LAMINATE") && $status == "IN") {
            $phase = "PRODUCTION IN";
        } else if ($category == "PVC" && $status == "OUT") {
            $phase = "VINYL PRESS AND PACK";
        } else if ($category == "LAMINATE" && $status == "OUT") {
            $phase = "LAMINATE CLEAN/PACK";
        }
        $query = "SELECT sum(ps.total_pieces) as totalDoors, wph.phase_date  FROM packslip ps, workorder_phase_history wph "
                . "WHERE ps.ps_id = wph.packslipId "
                . "AND wph.phase_date IN ('$date_current') "
                . "AND wph.phase = '$phase' "
                . "AND wph.status = '$status' AND ps.prof_id = '$category'";
        $result = MysqlConnection::fetchCustomSingle($query);
        return $result["totalDoors"];
    }

}
