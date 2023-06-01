<?php
$category = filter_input(INPUT_GET, "category");
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

$condition = " AND prof_id = '$category' "
        . " AND `ackrecv` = 'YES' "
        . " AND production_update IN('PRODUCTION OUT-OUT', 'DELIVERY-IN') "
        . " AND isLayout != 'Y' ";
$exportData = PackingSlip::getLast5Orders("", $condition);

$headers = array_keys($exportData[0]);

$f = fopen('php://memory', 'w');
fputcsv($f, $headers);
foreach ($exportData as $line) {
    fputcsv($f, $line);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="not-delivered-to-customer.csv";');
fpassthru($f);

