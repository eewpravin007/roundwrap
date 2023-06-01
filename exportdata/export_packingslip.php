<?php

$category = filter_input(INPUT_GET, "category");
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}


$where = " AND prof_id = '$category' AND isLayout != 'Y'  AND workOrd_Id = '-' ";
$exportData = PackingSlip::getLast5Orders("", $where);
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

