<?php

class GenericSetting {

    static $PVC = "PVC";
    static $LAMINATE = "LAMINATE";
    static $PRESSING = "PRESSING";

    static function getColorByIndex($index) {
        $array = array();
        $array[0] = "warning";
        $array[1] = "danger";
        $array[2] = "dark";
        $array[3] = "gray";
        $array[4] = "indicator";
        $array[5] = "info";
        $array[6] = "primary";
        $array[7] = "secondary";
        $array[8] = "success";
        $array[9] = "warning";
        return $array[$index];
    }

    static function getWorkStationByCategory() {
        $result = MysqlConnection::fetchCustom("SELECT * FROM `generic_entry`"
                        . " WHERE type = 'scannerstep'"
                        . " ORDER BY code, name");
        $array_filter = array();
        foreach ($result as $value) {
            $array_filter[$value["profiletype"]][] = $value;
        }
        return $array_filter;
    }

    static function numberFormat($number) {
        echo number_format((float) $number, 2, '.', '');
    }

    static function toggleMe($flag) {
        $value = $flag == "Y" ? "YES" : "NO";
        if ($flag == "Y") {
            echo "<span class='badge bg-label-success'>$value</span>";
        } else {
            echo "<span class='badge bg-label-danger'>$value</span>";
        }
    }
    
    static function toggleMeWithValue($flag, $value) {
        if ($flag == "Y") {
            echo "<span class='badge bg-label-success'>$value</span>";
        } else {
            echo "<span class='badge bg-label-danger'>$value</span>";
        }
    }

    
    static function truncateString($str, $chars, $to_space, $replacement = "...") {
        if ($chars > strlen($str)) {
            return $str;
        }

        $str = substr($str, 0, $chars);
        $space_pos = strrpos($str, " ");
        if ($to_space && $space_pos >= 0) {
            $str = substr($str, 0, strrpos($str, " "));
        }

        return($str . $replacement);
    }

    static function daysFromTwoDates($date) {
        $now = time(); // or your date as well
        $your_date = strtotime($date);
        $datediff = $now - $your_date;
        echo round($datediff / (60 * 60 * 24));
    }

}
