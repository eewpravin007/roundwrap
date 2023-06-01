<?php

error_reporting(0);
include '../MysqlConnection.php';
include '../daoclass/MainPageStatestic.php';

$pvcAndLaminateLiveStationLoad = MainPageStatestic::getPvcAndLaminateLiveStationLoad();

echo $pvc_chart_values = "["
        . "" . $pvcAndLaminateLiveStationLoad["CNC-OUT"] . ","
        . "" . $pvcAndLaminateLiveStationLoad["SAND/CLEAN-OUT"] . ","
        . "" . $pvcAndLaminateLiveStationLoad["GLUE-OUT"] . ","
        . "" . $pvcAndLaminateLiveStationLoad["VINYL PRESS AND PACK-OUT"] . ""
        . "]";
//
//echo $lmi_chart_values = "["
//        . "" . $pvcAndLaminateLiveStationLoad["LAMINATE PRESS-OUT"] . ","
//        . "" . $pvcAndLaminateLiveStationLoad["SAW/DOOR-OUT"] . ","
//        . "" . $pvcAndLaminateLiveStationLoad["EDGE BANDING-OUT"] . ","
//        . "" . $pvcAndLaminateLiveStationLoad["LAMINATE CLEAN/PACK-OUT"] . ""
//        . "]";
