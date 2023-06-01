<?php
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}
$category = filter_input(INPUT_GET, "category");
if ($category == "") {
    $category = "PVC";
}
$condition = " AND prof_id = '$category' "
        . " AND `ackrecv` = 'YES' "
        . " AND production_update IN('VINYL PRESS AND PACK-OUT', 'LAMINATE CLEAN/PACK-OUT') "
        . " AND isLayout != 'Y' ";
$master_result = PackingSlip::getLast5Orders("", $condition);
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
<h3>Order process but pending for production out</h3>
<table border='1' >
    <thead>
        <tr style="">
            <th>#</th>
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
        foreach ($master_result as $value) {
            ?>    
            <tr style="">
                <td><?php echo $index01++ ?></td>
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

