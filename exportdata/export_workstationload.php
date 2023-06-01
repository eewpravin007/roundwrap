<?php
$date_for = filter_input(INPUT_GET, "date_for");
$date = "-" . sprintf("%02d", $date_for) . "-";
$category = filter_input(INPUT_GET, "category");
$phase_for = filter_input(INPUT_GET, "phase");

include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

if ($category == "PVC") {
    if ($phase_for == "") {
        $result = MainPageStatestic::workStationLoadGeneratePDF($date);
        $doorsData = MainPageStatestic::generateDoorsReport($result["PVC"]);
    } else if ($phase_for == "NONPRODOUT") {
        $result_p = MainPageStatestic::workStationLoadGeneratePDF($date, "VINYL PRESS AND PACK");
        $doorsData = MainPageStatestic::generateDoorsReport($result_p["PVC"]);
    }
} else if($category == "LAMINATE") {
    if ($phase_for == "") {
        $result = MainPageStatestic::workStationLoadGeneratePDF($date);
        $doorsData = MainPageStatestic::generateDoorsReport($result["LAMINATE"]);
    } else if ($phase_for == "NONPRODOUT") {
        $result_l = MainPageStatestic::workStationLoadGeneratePDF($date, "LAMINATE CLEAN/PACK");
        $doorsData = MainPageStatestic::generateDoorsReport($result_l["LAMINATE"]);
    }
}

$exportData = array();
foreach ($doorsData as $key => $value) {
    $percentpvc = ($value / 300) * 100;
    $day = date('l', strtotime($key));

    $export = array();
    $export["Date"] = $key;
    $export["Day"] = $day;
    $export["Total Time"] = "0";
    $export["Total Worker"] = 3;
    $export["Production Goal"] = 300;
    $export["Actual Volume"] = $value;
    $export["% of Attained Goal"] = number_format((float) $percentpvc, 2, '.', '');
    $export["Reason Less Production"] = "N/A";

    array_push($exportData, $export);
}
$headers = array_keys($exportData[0]);
$f = fopen('php://memory', 'w');
fputcsv($f, $headers);
foreach ($exportData as $line) {
    fputcsv($f, $line);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . strtolower($category) . '-workstation-load.csv";');
fpassthru($f);

