<?php
$date_for = $date_for_select = filter_input(INPUT_GET, "date_for");
if ($date_for != "") {
    $expload = explode("-", $date_for);
    $get_month = $expload[0];
    $year = $expload[1]; 
    
    $date = "-" . sprintf("%02d", $get_month) . "-";
    $date_num = sprintf("%02d", $get_month);
    $monthName = date('F', mktime(0, 0, 0, $get_month, 10)); 
} else {
    $date = date("-m-");
    $year = date("Y");
    $date_num = date("m");
    $monthName = date('F', mktime(0, 0, 0, $date_num, 10));
}

if ($phase_for == "") {
    $result = MainPageStatestic::workStationLoadGeneratePDF($date, "PRODUCTION OUT", $year);
    $pvc_doors = MainPageStatestic::generateDoorsReport($result["PVC"]);
    $lmi_doors = MainPageStatestic::generateDoorsReport($result["LAMINATE"]);
} else if ($phase_for == "NONPRODOUT") {
    $result_p = MainPageStatestic::workStationLoadGeneratePDF($date, "VINYL PRESS AND PACK");
    $result_l = MainPageStatestic::workStationLoadGeneratePDF($date, "LAMINATE CLEAN/PACK");
    $pvc_doors = MainPageStatestic::generateDoorsReport($result_p["PVC"]);
    $lmi_doors = MainPageStatestic::generateDoorsReport($result_l["LAMINATE"]);
}
?>

<style>
    .dt-fixedcolumns thead{
        background-color: rgb(220,220,220);
    }
    .actual_volume{
        background-color: lightyellow
    }
</style>

<div class="card mb-12">
    <h5 class="card-header">This is your monthly station report and load on station.</h5>
    <form class="card-body" method="POST">
        <?php
        $date_num_c = date("m");
        for ($index = 0; $index < 6; $index++) {
            $monthName_c = date('F', mktime(0, 0, 0, ($date_num_c - $index), 10));
            $month_year = date('m-Y', strtotime("-$index month"));
            ?>
            <a 
                style="margin-right: 10px;"
                href="index.php?pagename=workstationloadtable_dashboard&date_for=<?php echo $month_year ?>" 
                class="btn btn-label-secondary <?php echo $date_for == $month_year ? "active" : "" ?>">
                    <?php echo $monthName_c ?>
            </a>
            <?php
        }
        ?>
        <a 
            href="index.php?pagename=workstationload_dashboard" 
            class="btn btn-label-secondary" style="float: right;margin-left: 10px">
            <i class="bx bx-chart"></i>
            GRAPH VIEW
        </a>&nbsp;&nbsp;&nbsp;
        <a  target="_blank"
            href="printpages/printpages_workstationloadtable.php?date_for=<?php echo $date_for?>&phase=<?php echo $phase_for?>" 
            class="btn btn-label-secondary" style="float: right;margin-left: 10px">
            <i class="bx bx-printer"></i>
            PRINT REPORT
        </a>
    </form>
</div> 
<br/>
<div class="row">
    <div class="col-lg-12 col-md-12 mb-12">
        <!-- Heat map Chart -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">PVC Station Monthly Performance Chart - <?php echo $monthName ?></h5>
                <table border="0">
                    <tr>
                        <td>
                            <a 
                                href="index.php?pagename=workstationloadtable_dashboard&date_for=<?php echo $date_for ?>&category=PVC"
                                class="btn btn-label-secondary <?php echo $phase_for == "" ? "active" : "" ?>" style="float: right;margin-left: 10px">
                                <i class="bx bx-outline"></i>
                                PRODUCTION OUT
                            </a>
                        </td>
                        <td>
                            <a 
                                href="index.php?pagename=workstationloadtable_dashboard&date_for=<?php echo $date_for ?>&category=PVC&phase=NONPRODOUT"
                                class="btn btn-label-secondary <?php echo $phase_for == "NONPRODOUT" ? "active" : "" ?>" style="float: right;margin-left: 10px">
                                <i class="bx bx-box"></i>
                                VINYL PRESS AND PACK
                            </a>
                        </td>
                        <td>
                            <a 
                                href="exportdata/export_workstationload.php?date_for=<?php echo $date_for ?>&category=PVC&phase=<?php echo $phase_for ?>" target="_blank"
                                class="btn btn-label-secondary" style="float: right;margin-left: 10px">
                                <i class="bx bx-import"></i>
                                DOWNLOAD REPORT
                            </a>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="card-body">
                <table class="dt-select-table table table-bordered">
                    <thead>
                        <tr style="background-color: rgb(220,220,220);">
                            <th>Date</th>
                            <th>Day</th>
                            <th>Total Time</th>
                            <th>Total Worker</th>
                            <th>Production Goal</th>
                            <th>Actual Volume</th>
                            <th style="text-align: right">% of Attained Goal</th>
                            <th>Reason Less Production</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($pvc_doors as $key => $value) {
                            $day = date('l', strtotime($key));
                            $percentpvc = ($value / 300) * 100;
                            if ($percentpvc < 100) {
                                $gbv = "background-color: rgb(255, 228, 228);color:red;font-weight:bold";
                            } else {
                                $gbv = "";
                            }
                            ?>
                            <tr >
                                <td><?php echo $key ?></td>
                                <td style="color: <?php echo $day == "Saturday" ? "red" : "" ?>"><?php echo $day ?></td>
                                <td>0</td>
                                <td>3</td>
                                <td>300</td>
                                <td style="background-color: lightyellow"><?php echo $value ?></td>
                                <td style="text-align: right;<?php echo $gbv ?>">
                                    <?php echo GenericSetting::numberFormat($percentpvc) ?>&nbsp;%
                                </td>
                                <td>N/A</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br/>
<!-- /Heat map Chart -->
<div class="row">
    <div class="col-lg-12 col-md-12 mb-12">
        <!-- Heat map Chart -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Laminate Stations Monthly Performance Chart - <?php echo $monthName ?></h5>
                <table border="0">
                    <tr>
                        <td>
                            <a 
                                href="index.php?pagename=workstationloadtable_dashboard&date_for=<?php echo $date_for ?>&category=PVC"
                                class="btn btn-label-secondary <?php echo $phase_for == "" ? "active" : "" ?>" style="float: right;margin-left: 10px">
                                <i class="bx bx-outline"></i>
                                PRODUCTION OUT
                            </a>
                        </td>
                        <td>
                            <a 
                                href="index.php?pagename=workstationloadtable_dashboard&date_for=<?php echo $date_for ?>&category=PVC&phase=NONPRODOUT" 
                                class="btn btn-label-secondary <?php echo $phase_for == "NONPRODOUT" ? "active" : "" ?>" style="float: right;margin-left: 10px">
                                <i class="bx bx-box"></i>
                                LAMINATE CLEAN/PACK
                            </a>
                        </td>
                        <td>
                            <a 
                                href="exportdata/export_workstationload.php?date_for=<?php echo $date_for ?>&category=LAMINATE&phase=<?php echo $phase_for ?>" target="_blank"
                                class="btn btn-label-secondary" style="float: right;margin-left: 10px">
                                <i class="bx bx-import"></i>
                                DOWNLOAD REPORT
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-body">
                <table class="dt-select-table table table-bordered">
                    <thead>
                        <tr style="background-color: rgb(220,220,220);">
                            <th>DATE</th>
                            <th>DAY</th>
                            <th>Total Time</th>
                            <th>Total Worker</th>
                            <th>Production Goal</th>
                            <th>Actual Volume</th>
                            <th style="text-align: right">% of Attained Goal</th>
                            <th>Reason Less Production</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($lmi_doors as $key => $value) {
                            $day = date('l', strtotime($key));
                            $percentlmi = ($value / 300) * 100;
                            if ($percentlmi < 100) {
                                $gbv = "background-color: rgb(255, 228, 228);color:red;font-weight:bold";
                            } else {
                                $gbv = "";
                            }
                            ?>
                            <tr>
                                <td><?php echo $key ?></td>
                                <td style="color: <?php echo $day == "Saturday" ? "red" : "" ?>"><?php echo $day ?></td>
                                <td>0</td>
                                <td>3</td>
                                <td>300</td>
                                <td style="background-color: lightyellow"><?php echo $value ?></td>
                                <td style="text-align: right;<?php echo $gbv ?>">
                                    <?php echo GenericSetting::numberFormat($percentlmi) ?>&nbsp;%
                                </td>
                                <td>N/A</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

