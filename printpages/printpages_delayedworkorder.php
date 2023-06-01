<?php
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}
$packingslip = PackingSlip::getDelayedOrders("", $where);
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
<h3>DELAYED WORK ORDER</h3>
<table border="1">
    <tr >
        <th></th>
        <th>Customer Name</th>
        <th>Category</th>
        <th>So&nbsp;Number</th>
        <th>Color</th>
        <th>Po&nbsp;Number</th>
        <th>Days&nbsp;Left</th>
        <th>Update</th>
    </tr>
    <?php
    $index = 1;
    foreach ($packingslip as $value) {
        ?>
        <tr >
            <td><?php echo $index++ ?></td>
            <td><?php echo $value["cust_companyname"] ?></td>
            <td><?php echo $value["sub_prof_id"] ?></td>
            <td><?php echo $value["so_no"] ?></td>
            <td><?php echo $value["color_name"] ?></td>
            <td><?php echo $value["po_no"] ?></td>
            <td><small><?php echo PackingSlip::deliveryLeft($value["daysLeft"]) ?></small></td>
            <td><small><?php echo PackingSlip::productionInStatus($value["production_update"]) ?></small></td>
        </tr>
        <?php
    }
    ?>
</table>
