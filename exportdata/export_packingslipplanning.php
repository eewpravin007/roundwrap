<?php

include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}
$category = filter_input(INPUT_GET, "category");
$specific_date = filter_input(INPUT_GET, "specific_date");

$resultset = Production::createPlanning($category, $specific_date);
$keys = array_keys($resultset);

$exportData = array();
foreach ($keys as $key) {
    $resultset_key = $resultset[$key];
    $index = 1;
    $total_doors = 0;
    foreach ($resultset_key as $value) {
        $value["isUrgent"] = $value["isUrgent"] == "N" ? "NO" : "YES";
        $value["daysLeft"] = ceil($value["daysLeft"])." Days Behind";
        $exportData[] = $value;
    }
}
$headers = array_keys($exportData[0]);

$f = fopen('php://memory', 'w');
fputcsv($f, $headers);
foreach ($exportData as $line) {
    fputcsv($f, $line);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . strtolower($category) . '-packingslip-orders.csv";');
fpassthru($f);
