<?php

include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}
$exportData = MainPageStatestic::orderTimeLineDelivery();
$headers = array_keys($exportData[0]);

$f = fopen('php://memory', 'w');
fputcsv($f, $headers);
foreach ($exportData as $line) {
    fputcsv($f, $line);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="delivery-orders.csv";');
fpassthru($f);

