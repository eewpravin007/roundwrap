<?php

session_start();
ob_start();

$exportData = $_SESSION["stationWiseOrder"];
$headers = array_keys($exportData[0]);

$f = fopen('php://memory', 'w');
fputcsv($f, $headers);
foreach ($exportData as $line) {
    fputcsv($f, $line);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="work-station-data.csv";');
fpassthru($f);
