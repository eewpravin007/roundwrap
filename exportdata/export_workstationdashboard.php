<?php

$category = filter_input(INPUT_GET, "category");
$search = $category == "lmi" ? "LAMINATE" : "PVC";
$current_phase = filter_input(INPUT_GET, "station_name");

if ($current_phase == "") {
    $current_phase = "PRODUCTION IN";
} 

include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

$exportData = PackingSlip::stationWiseReport($current_phase);
$headers = array_keys($exportData[0]);

$f = fopen('php://memory', 'w');
fputcsv($f, $headers);
foreach ($exportData as $line) {
    fputcsv($f, $line);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . strtolower($category) . "-" . strtolower($current_phase) . '-production.csv";');
fpassthru($f);

