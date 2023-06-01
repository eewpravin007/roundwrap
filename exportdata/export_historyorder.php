<?php

$customerid = filter_input(INPUT_GET, "customerid");
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

$orderyears = HistoryOrders::getOrderYear($customerid);

$headers = array();
$headers[] = "ps_id";
$headers[] = "po_no";
$headers[] = "so_no";
$headers[] = "prof_id";
$headers[] = "sub_prof_id";
$headers[] = "total_pieces";
$headers[] = "rec_date";
$headers[] = "total_weight";
$headers[] = "billable_fitsquare";
$headers[] = "color_name";

$f = fopen('php://memory', 'w');
fputcsv($f, $headers);

foreach ($orderyears as $year) {
    $exportData = Customer::customerDoorDetailsPerYear($customerid, $year);
    foreach ($exportData as $line) {
        fputcsv($f, $line);
    }
}

fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="production-orders.csv";');
fpassthru($f);

