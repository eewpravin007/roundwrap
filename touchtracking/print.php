<?php
session_start();
ob_start();

$stationWiseOrder = $_SESSION["stationWiseOrder"];
?>

<title>WOrk station report</title>
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
<h3>Work station report</h3>
<table border="1">
    <tr >
        <th>#</th>
        <th>So&nbsp;Number</th>
        <th>Po&nbsp;Number</th>
        <th>Color&nbsp;Brand</th>
        <th>Prod&nbsp;Update</th>
        <th>Urgent?</th>
        <th>Del.Date</th>
        <th>Left Days</th>
    </tr>
    <?php
    $index = 1;
    foreach ($stationWiseOrder as $value) {
        ?>
        <tr >
            <td><?php echo $index++ ?></td>
            <td><?php echo $value["workOrd_Id"] ?></td>
            <td><?php echo $value["po_no"] ?></td>
            <td><?php echo $value["colorbrand"] ?></td>
            <td><?php echo $value["production_update"] ?></td>
            <td><?php echo $value["isUrgent"] ?></td>
            <td><?php echo $value["req_date"] ?></td>
            <td><?php echo $value["daysLeft"] ?></td>
        </tr>
        <?php
    }
    ?>
</table>