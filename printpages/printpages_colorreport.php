<?php
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

$category_get = filter_input(INPUT_GET, "category");
$colorname = filter_input(INPUT_GET, "colorname");
$brandname = filter_input(INPUT_GET, "brandname");

$category = $category_get == "" ? "PVC" : $category_get;

$color_brand_list = Colors::getColorSearchColum($category, "colorbrand");
$color_name_list = Colors::getColorSearchColum($category, "colorname");

$filter_input_array = filter_input_array(INPUT_POST);

if ($filter_input_array["btnSearch"] == "Search") {
    $brandname = $filter_input_array["color_brand"];
    $colorname = $filter_input_array["color_name"];
    $_SESSION["colorsearch"] = $filter_input_array;
    $colorreportdata = Colors::getOrdersByColorName($category, $colorname, $brandname);
} else {
    $colorreportdata = Colors::getOrdersByColorName($category, $colorname, "");
}

$orderCountByColor = Colors::getOrdersByColors($category);
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
<h3>COLOR PRINT REPORT - <?php echo $category . " - " . $colorname . " - " . $brandname ?></h3>
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
    foreach ($colorreportdata as $value) {
        ?>
        <tr >
            <td><?php echo $index++ ?></td>
            <td><?php echo $value["customername"] ?></td>
            <td><?php echo $value["so_no"] ?></td>
            <td><?php echo $value["po_no"] ?></td>
            <td><?php echo $value["prof_id"] . "-" . $value["sub_prof_id"] ?></td>
            <td><?php echo $value["total_pieces"] ?></td>
            <td><?php echo PackingSlip::productionInStatus($value["production_update"]) ?></td>
            <td>
                <span class="badge bg-label-<?php echo $value["order"] == "Active" ? "success" : "danger" ?>">
                    <?php echo $value["order"] == "Active" ? "Live" : "History" ?>
                </span>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
