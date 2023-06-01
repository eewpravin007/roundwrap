<?php
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

$category = filter_input(INPUT_GET, "category");
$search = $category == "lmi" ? "LAMINATE" : "PVC";
$current_phase = filter_input(INPUT_GET, "station_name");

if ($current_phase == "") {
    $current_phase = "PRODUCTION IN";
} else {
    
}

$stationWiseOrder = PackingSlip::stationWiseReport($current_phase);
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
<h3>Workstation report <?php echo $current_phase ?></h3>
<table border="1">
    <thead style="background-color: rgb(220,220,220);">
        <tr style="">
            <th>#</th>
            <th>Customer</th>
            <th>SO NO</th>
            <th>PO NO</th>
            <th>Type</th>
            <th>Doors</th>
            <th>Update</th>
            <th>Delivery</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index01 = 1;
        foreach ($stationWiseOrder as $value) {
            ?>    
            <tr style="">
                <td><?php echo $index01++ ?></td>
                <td><?php echo $value["cust_companyname"] ?></td>
                <td><?php echo $value["so_no"] ?></td>
                <td><?php echo $value["po_no"] ?></td>
                <td><?php echo $value["sub_prof_id"] ?></td>
                <td><?php echo $value["total_pieces"] ?></td>
                <td><?php echo PackingSlip::productionInStatus($value["production_update"]) ?></td>
                <td><?php echo PackingSlip::deliveryLeft($value["daysLeft"]) ?></td>
            </tr>
            <?php
        }
        ?>    
    </tbody>
</table>

