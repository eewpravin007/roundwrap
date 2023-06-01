<?php
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

$date_for = filter_input(INPUT_GET, "date_for");
$phase_for = filter_input(INPUT_GET, "phase");
if ($date_for != "") {
    $date = "-" . sprintf("%02d", $date_for) . "-";
    $date_num = sprintf("%02d", $date_for);
    $monthName = date('F', mktime(0, 0, 0, $date_num, 10)); // March
} else {
    $date = date("-m-");
    $date_num = date("m");
    $monthName = date('F', mktime(0, 0, 0, $date_num, 10)); // March
}

if ($phase_for == "") {
    $result = MainPageStatestic::workStationLoadGeneratePDF($date);
    $pvc_doors = MainPageStatestic::generateDoorsReport($result["PVC"]);
    $lmi_doors = MainPageStatestic::generateDoorsReport($result["LAMINATE"]);
} else if ($phase_for == "NONPRODOUT") {
    $result_p = MainPageStatestic::workStationLoadGeneratePDF($date, "VINYL PRESS AND PACK");
    $result_l = MainPageStatestic::workStationLoadGeneratePDF($date, "LAMINATE CLEAN/PACK");
    $pvc_doors = MainPageStatestic::generateDoorsReport($result_p["PVC"]);
    $lmi_doors = MainPageStatestic::generateDoorsReport($result_l["LAMINATE"]);
}
?>
<title>RoundWrap Report</title>
<script>
    window.print();
</script>
<style>
    @media print{
        @page {
            size: landscape
        }
    }
    table{
        width: 100%;
        border-collapse: collapse;
    }
    th, td{
        text-align: left;
        padding: 4px;
    }

</style>
<h3>PVC monthly station report and load on station.</h3>
<table border="1">
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
<hr/>
<h3>Laminate monthly station report and load on station.</h3>
<table border="1">
    <thead>
        <tr >
            <th>DATE</th>
            <th>DAY</th>
            <th>Total Time</th>
            <th>Total Worker</th>
            <th>Production Goal</th>
            <th>Actual Volume</th>
            <th>% of Attained Goal</th>
            <th>Reason Less Production</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($lmi_doors as $key => $value) {
            $day = date('l', strtotime($key));
            $percentlmi = ($value / 300) * 100;
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
