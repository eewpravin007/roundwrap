<?php
$po_number = filter_input(INPUT_GET, "po_number");

$filter_input_array = filter_input_array(INPUT_POST);
if ($po_number != "") {
    $resultset = HistoryOrders::getPackingSlipDetailsByPo($po_number);
}
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
    .tracking{
        height: 45px;
        width: 45px;
        border: solid 1px gray;
        border-radius: 45px;
        margin: 10px;
        text-align: center;
        margin: 0 auto;
    }
    .rotate {
        border-bottom: 1px solid gray;
        transform: rotate(315deg);
        white-space: nowrap;
    }
</style>

<div class="card">
    <h5 class="card-header">Search Result by purchase order</h5>
    <div class="card-body" >
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="table table-bordered">
                <thead style="background-color: rgb(220,220,220);">
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>So No</th>
                        <th>Po No</th>
                        <th>Profile</th>
                        <th>Style</th>
                        <th>Color</th>
                        <th>Order Date</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($resultset as $value) {
                        ?>
                        <tr>
                            <td><?php echo $index++ ?></td>
                            <td><?php echo $value["customername"] ?></td>
                            <td>
                                <a href="index.php?pagename=history_customermaster&sales_order_no=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["so_no"] ?>
                                </a>
                            </td>
                            <td>
                                <a href="index.php?pagename=history_customermaster&sales_order_no=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["po_no"] ?>
                                </a>
                            </td>
                            <td><?php echo $value["prof_id"] ?></td>
                            <td><?php echo $value["sub_prof_id"] ?></td>
                            <td><?php echo $value["color_name"] ?></td>
                            <td><?php echo $value["rec_date"] ?></td>
                            <td>
                                <?php $flag = $value["db"] == "rw" ? "Y" : "N" ?>
                                <?php $value = $value["db"] == "rw" ? "Active" : "History" ?>
                                <?php
                                GenericSetting::toggleMeWithValue($flag, $value);
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>