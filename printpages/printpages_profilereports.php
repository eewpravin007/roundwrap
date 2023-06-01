<?php
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}
$category = filter_input(INPUT_GET, "category");
$profilename = filter_input(INPUT_GET, "profilename");

$profilereportdata = Profiles::getProfileDataForReport($category, $profilename);
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

<table border="1">
    <tr >
        <th>#</th>
        <th>Customer</th>
        <th>So&nbsp;Number</th>
        <th>Po&nbsp;Number</th>
        <th>Profile&nbsp;Style</th>
        <th>Total&nbsp;Doors</th>
        <th>Production&nbsp;Update</th>
        <th>Order&nbsp;Type</th>
    </tr>
    <?php
    $index = 1;
    foreach ($profilereportdata as $value) {
        ?>
        <tr >
            <td><?php echo $index++ ?></td>
            <td><?php echo $value["customername"] ?></td>
            <td><?php echo $value["so_no"] ?></td>
            <td><?php echo $value["po_no"] ?></td>
            <td><?php echo $value["prof_id"] . "-" . $value["sub_prof_id"] ?></td>
            <td><?php echo $value["total_pieces"] ?></td>
            <td><?php echo PackingSlip::productionInStatus($value["production_update"]) ?></td>
            <td><?php echo $value["order"] == "Active" ? "Live" : "History" ?></td>
        </tr>
        <?php
    }
    ?>
</table>