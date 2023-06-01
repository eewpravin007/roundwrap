<?php

include '../MysqlConnection.php';

session_start();
ob_start();

$category = filter_input(INPUT_GET, "category");
$profilename = filter_input(INPUT_GET, "profilename");

foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

$profilesearch = $_SESSION["profile_search"];
if ($_SESSION["profile_search"] != "") {
    $profilename = $profilesearch;
}
$exportData = Profiles::getProfileDataForReport($category, $profilename);
$headers = array_keys($exportData[0]);

$f = fopen('php://memory', 'w');
fputcsv($f, $headers);
foreach ($exportData as $line) {
    fputcsv($f, $line);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . strtolower($category . "-" . $profilename) . '-report.csv";');
fpassthru($f);

