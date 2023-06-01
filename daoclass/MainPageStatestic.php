<?php

class MainPageStatestic {

    static function getProductionLiveChart() {
        //$current_date = "2022-09-28";
        $current_date = date("Y-m-d");
        $columns = " prof_id, total_pieces ";
        $master_result = MysqlConnection::fetchCustom("SELECT $columns "
                        . " FROM `packslip` "
                        . " WHERE `rec_date` = '$current_date'");

        $pvc_counter = 0;
        $laminate_counter = 0;

        $pvc_door_counter = 0;
        $laminate_door_counter = 0;
        foreach ($master_result as $value) {
            if ($value["prof_id"] == "PVC") {
                $pvc_counter++;
                $pvc_door_counter = $pvc_door_counter + $value["total_pieces"];
            } else {
                $laminate_counter++;
                $laminate_door_counter = $laminate_door_counter + $value["total_pieces"];
            }
        }
        $result_array = array();
        $result_array["PVC"]["total_order"] = $pvc_counter;
        $result_array["PVC"]["total_door"] = $pvc_door_counter;
        $result_array["PVC"]["total_door_percent"] = ($pvc_door_counter / ($laminate_door_counter + $pvc_door_counter)) * 100;

        $result_array["LAMINATE"]["total_order"] = $laminate_counter;
        $result_array["LAMINATE"]["total_door"] = $laminate_door_counter;
        $result_array["LAMINATE"]["total_door_percent"] = ($laminate_door_counter / ($laminate_door_counter + $pvc_door_counter)) * 100;

        $getProductionOutData = self::getProductionOutData("PRODUCTION OUT", "OUT");
        $result_array["PVC"]["doors_made"] = $getProductionOutData["PVC"];
        $result_array["LAMINATE"]["doors_made"] = $getProductionOutData["LAMINATE"];

        $production_date = self::getProductionRate($getProductionOutData["PVC"], $getProductionOutData["LAMINATE"]);
        $result_array["PVC"]["production_rate"] = $production_date["PVC"];
        $result_array["LAMINATE"]["production_rate"] = $production_date["LAMINATE"];

        return $result_array;
    }

    //`phase` = 'PRODUCTION OUT' AND status = 'OUT'
    static function getProductionOutData($phase, $status) {
        //$current_date = "2022-09-28";
        $current_date = date("Y-m-d");
        $query = "SELECT `cust_id`, workOrId, phase_time,"
                . " (SELECT prof_id FROM packslip WHERE ps_id = wph.packslipId) as prof_id,"
                . " (SELECT total_pieces FROM packslip WHERE ps_id = wph.packslipId) as total_pieces"
                . " FROM `workorder_phase_history` wph WHERE `phase_date` = '$current_date'"
                . " AND `phase` = '$phase' AND status = '$status' ORDER BY `prof_id` ASC";
        $master_result = MysqlConnection::fetchCustom($query);
        $return_result = array();

        $pvc_counter = 0;
        $laminate_counter = 0;

        foreach ($master_result as $value) {
            if ($value["prof_id"] == "PVC") {
                $pvc_counter = $pvc_counter + $value["total_pieces"];
            } else {
                $laminate_counter = $laminate_counter + $value["total_pieces"];
            }
        }
        $return_result["PVC"] = $pvc_counter;
        $return_result["LAMINATE"] = $laminate_counter;
        return $return_result;
    }

    static function getProductionRate($pvc, $laminate) {
        $door_capacity = 500;

        $pvc_rate = round((( $pvc / $door_capacity ) * 100), 2);
        $lami_rate = round((( $laminate / $door_capacity ) * 100), 2);

        $return_result["PVC"] = $pvc_rate;
        $return_result["LAMINATE"] = $lami_rate;
        return $return_result;
    }

    static function getPvcAndLaminateLiveStationLoad() {
        //`profiletype`,
        //$current_date = "2022-09-28";
        $current_date = date("Y-m-d");
        $station_query = "SELECT `name` "
                . "FROM `generic_entry` "
                . "WHERE `type` LIKE 'scannerstep' ";

        $query = "SELECT `cust_id`, workOrId, phase_time, phase, `phase_date`, status, "
                . " (SELECT prof_id FROM packslip WHERE ps_id = wph.packslipId) as prof_id,"
                . " (SELECT total_pieces FROM packslip WHERE ps_id = wph.packslipId) as total_pieces"
                . " FROM `workorder_phase_history` wph WHERE `phase_date` = '$current_date'"
                . " AND `phase` IN($station_query) AND status IN('IN' , 'OUT') ORDER BY `prof_id` ASC";

        $resultset_array = array();
        $total_keys = array();
        $station_production = MysqlConnection::fetchCustom($query);
        foreach ($station_production as $value) {
            $profile = $value["prof_id"];
            $phase = $value["phase"];
            $status = $value["status"];
            $key = $phase . "-" . $status;

            $resultset_array[$profile][$key][] = $value["total_pieces"];

            if (!in_array($key, $total_keys[$profile])) {
                $total_keys[$profile][] = $key;
            }
        }


        $graph_values = array();
        foreach ($resultset_array as $sub_array) {
            foreach ($sub_array as $key => $value) {
                $graph_values[$key] = array_sum($value);
            }
        }
        return $graph_values;
    }

    static function onlyProductionOutValues() {
        //$current_date = "2022-09-28";
        $current_date = date("Y-m-d");
        $query = "SELECT `cust_id`, workOrId, phase_time, phase, `phase_date`, status, "
                . "(SELECT prof_id FROM packslip WHERE ps_id = wph.packslipId) as prof_id, "
                . "(SELECT total_pieces FROM packslip WHERE ps_id = wph.packslipId) as total_pieces "
                . " FROM `workorder_phase_history` wph WHERE `phase_date` = '$current_date'"
                . " AND `phase` = 'PRODUCTION OUT' "
                . " AND status IN('IN' , 'OUT') "
                . " ORDER BY `prof_id` ASC";

        $master_result = MysqlConnection::fetchCustom($query);
        $return_order = array();
        foreach ($master_result as $value) {
            $key = $value["prof_id"] . "-" . $value["phase"] . "-" . $value["status"];
            $return_order[$key][] = $value["total_pieces"];
        }

        $graph_values = array();
        foreach ($return_order as $key => $sub_array) {
            $graph_values[$key] = array_sum($sub_array);
        }
        return $graph_values;
    }

    static function orderTimeLineInward($limit = "") {
        $in_delivery = " production_update IN ('ORDER CREATED', '')";
        $query = "SELECT"
                . " (" . Customer::$CUSTOMER_NAME_QUERY . " id = ps.cust_id ) as cust_companyname, "
                . " prof_id, `so_no`, `rec_date`, `req_date`, `po_no` , sub_prof_id, "
                . " production_update ,datediff(req_date, now()) as daysLeft"
                . " FROM `packslip` ps "
                . " WHERE $in_delivery AND isLayout != 'Y'"
                . " ORDER BY so_no DESC $limit ";
        $master_result = MysqlConnection::fetchCustom($query);

        $return_result = array();
        foreach ($master_result as $value) {
            $return_result[] = $value;
        }
        return $return_result;
    }

    static function orderTimeLineInProduction($limit = "") {
        $in_delivery = " production_update"
                . " NOT IN ('ORDER CREATED', '', 'ORDER DELIVERED', 'PRODUCTION OUT-OUT', 'ORDER DELIVERED-OUT', 'DELIVERY-IN')";
        $query = "SELECT"
                . " (" . Customer::$CUSTOMER_NAME_QUERY . " id = ps.cust_id ) as cust_companyname, "
                . " prof_id, `so_no`, `rec_date`, `req_date`, `po_no` , sub_prof_id, "
                . " production_update ,datediff(req_date, now()) as daysLeft"
                . " FROM `packslip` ps "
                . " WHERE $in_delivery  AND isLayout != 'Y' "
                . " ORDER BY so_no DESC $limit";
        $master_result = MysqlConnection::fetchCustom($query);

        $return_result = array();
        foreach ($master_result as $value) {
            $return_result[] = $value;
        }
        return $return_result;
    }

    static function orderTimeLineDelivery($and = "", $limit = "") {
        $in_delivery = " production_update IN ('ORDER DELIVERED', 'PRODUCTION OUT-OUT')";
        $query = "SELECT"
                . " (" . Customer::$CUSTOMER_NAME_QUERY . " id = ps.cust_id ) as cust_companyname, "
                . " prof_id, `so_no`, `rec_date`, `req_date`, `po_no` , sub_prof_id, "
                . " production_update ,datediff(req_date, now()) as daysLeft, "
                . " deliveryPerson, deliveryNote, deliveryContact, deliveredOn"
                . " "
                . " FROM `packslip` ps "
                . " WHERE $in_delivery $and "
                . " ORDER BY so_no DESC $limit";
        $master_result = MysqlConnection::fetchCustom($query);

        $return_result = array();
        foreach ($master_result as $value) {
            $production_update = $value["production_update"];
            $value["production_update"] = $production_update == "ORDER DELIVERED" ? "DELIVERED" : "READY FOR DELIVERY";
            $return_result[] = $value;
        }
        return $return_result;
    }

    static function workStationLoad($date, $year) {
        $query = "SELECT "
                . " phase_date, phase, "
                . " (SELECT prof_id FROM packslip WHERE ps_id = wph.packslipId) as prof_id, "
                . " (SELECT total_pieces FROM packslip WHERE ps_id = wph.packslipId) as total_pieces "
                . " FROM `workorder_phase_history` wph "
                . " WHERE `phase_date` LIKE '%$date%'"
                . " AND ( substring_index(phase_date, '-', 1) ) = '$year' "
                . " AND status = 'OUT' "
                . " AND phase NOT IN('ORDER DELIVERED', 'PRODUCTION OUT', 'PRODUCTION IN') "
                . " ORDER BY phase_date ASC";
        $master_result = MysqlConnection::fetchCustom($query);

        $return_result = array();
        foreach ($master_result as $value) {
            $return_result[$value["phase_date"] . "*" . $value["phase"]][] = $value["total_pieces"];
        }

        $graph_values = array();
        foreach ($return_result as $key => $value) {
            $graph_values[$key] = array_sum($value);
        }

        $chart_values = array();
        foreach ($graph_values as $key => $value) {

            $expload = explode("*", $key);
            $date = $expload[0];
            $phase = $expload[1];
            $chart_values[$phase][$date] = $value;
        }

        return $chart_values;
    }

    static function showLoad($chart_values, $station = "") {
        $display_values = $chart_values[$station];
        $key_val = array();
        $key_val[] = implode(",", array_keys($display_values));
        $key_val[] = implode(",", array_values($display_values));
        return $key_val;
    }

    static function workStationLoadGeneratePDF($date, $phase = "PRODUCTION OUT", $year) {
        $query = "SELECT "
                . " phase_date, phase, "
                . " (SELECT prof_id FROM packslip WHERE ps_id = wph.packslipId) as prof_id, "
                . " (SELECT total_pieces FROM packslip WHERE ps_id = wph.packslipId) as total_pieces "
                . " FROM `workorder_phase_history` wph "
                . " WHERE `phase_date` LIKE '%$date%' "
                . " AND status = 'OUT' "
                . " AND phase IN('$phase')"
                . " AND ( substring_index(phase_date, '-', 1) ) = '$year' "
                . " ORDER BY phase_date ASC";
        $resultset = MysqlConnection::fetchCustom($query);

        $filer_category = array();

        foreach ($resultset as $value) {
            $filer_category[$value["prof_id"]][$value["phase_date"]][] = $value["total_pieces"];
        }
        return $filer_category;
    }

    static function generateDoorsReport($filer_category) {
        $display = array();
        foreach ($filer_category as $key => $value) {
            $display[$key] = array_sum($value);
        }
        return $display;
    }

    static function counterRow() {
        
        $array_counter = array();

        $website_order = "SELECT count(ps_id) as count FROM `packslip_customer` WHERE fromExcel != 'Y' ";
        $array_counter["website_count"] = MysqlConnection::fetchCustomSingleCounter($website_order);

        $tracking_note = "SELECT count(wph.iindex) as count FROM workorder_phase_history wph WHERE wph.alertHistory NOT IN('', '-') AND wph.`scannerCode` != 'Y'";
        $array_counter["tracking_note"] = MysqlConnection::fetchCustomSingleCounter($tracking_note);

        $pending_akg = "SELECT count(po_no) as count FROM `packslip` ps WHERE indexid != '' AND `ackrecv` = 'NO' AND production_update = '' ";
        $array_counter["pending_akg"] = MysqlConnection::fetchCustomSingleCounter($pending_akg);
        
        $late_orders = "SELECT count(po_no) as count FROM `packslip` ps WHERE isLayout != 'Y' and req_date < CURDATE() ORDER BY req_date ASC ";
        $array_counter["late_orders"] = MysqlConnection::fetchCustomSingleCounter($late_orders);
        
        return $array_counter;
    }

}
