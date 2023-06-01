<?php

$category = filter_input(INPUT_GET, "category");
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}
$exportData = PackingSlip::getLast5Orders("", " AND prof_id = '$category' AND `ackrecv` = 'NO' AND production_update = '' ");
$headers = array_keys($exportData[0]);

$f = fopen('php://memory', 'w');
fputcsv($f, $headers);
foreach ($exportData as $line) {
    fputcsv($f, $line);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $category . '-production-pending-acknowledgement.csv";');
fpassthru($f);

