<?php
include '../MysqlConnection.php';

session_start();
ob_start();

$category = filter_input(INPUT_GET, "category");
$colorname = filter_input(INPUT_GET, "colorname");

foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

$colorsearch = $_SESSION["colorsearch"];
if (!empty($_SESSION["colorsearch"])) {
    $colorname = $colorsearch["color_name"];
    $brandname = $colorsearch["color_brand"];
}

$exportData = Colors::getOrdersByColorName($category, $colorname, $brandname);
$headers = array_keys($exportData[0]);

$f = fopen('php://memory', 'w');
fputcsv($f, $headers);
foreach ($exportData as $line) {
    fputcsv($f, $line);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . strtolower($category . "-" . $colorname) . '-color-report.csv";');
fpassthru($f);

