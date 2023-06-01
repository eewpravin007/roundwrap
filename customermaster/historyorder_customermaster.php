<?php
$customerid = filter_input(INPUT_GET, "customerid");
$year = filter_input(INPUT_GET, "year");

$customerresult = Customer::getCustomerById($customerid);
$orderyears = HistoryOrders::getOrderYear($customerid);

if ($year == "") {
    $year = $orderyears[0];
}

if ($year != "") {
    $customerorder = Customer::customerDoorDetailsPerYear($customerid, $year);
}
?>
<div class="card mb-4">
    <h5 class="card-header">Search history orders for <b style="color: blue"><?php echo $customerresult["cust_companyname"] ?></b></h5>
    <div class="card-body" style="margin-top: -10px">
        <?php
        foreach ($orderyears as $value) {
            $totaldoors = Customer::customerOrderCountPerYear($customerid, $value);
            ?>
            <a href="index.php?pagename=historyorder_customermaster&customerid=<?php echo $customerid ?>&year=<?php echo $value ?>" 
               class="btn btn-secondary ">
                <?php echo $value ?> - <?php echo $totaldoors ?> Doors
            </a>&nbsp;&nbsp;&nbsp;&nbsp;
        <?php } ?>
        <a href="exportdata/export_historyorder.php?customerid=<?php echo $customerid ?>" target="_blank" class="btn btn-secondary ">
            <span class="tf-icons bx bx-import"></span>&nbsp;Export All
        </a>  
        <br/>
        <br/>
        <div class="table-responsive mb-2" style="max-height: 800px;overflow-y: auto;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="table table-bordered">
                <thead style="background-color: rgb(220,220,220);">
                    <tr style="">
                        <th style="width: 50px">#</th>
                        <th>SO NO</th>
                        <th>PO NO</th>
                        <th>Profile</th>
                        <th style="text-align: right">Doors</th>
                        <th>Color</th>
                        <th >Order Date</th>
                        <th ></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index2 = 1;
                    foreach ($customerorder as $value) {
                        ?>    
                        <tr style="">
                            <td><?php echo $index2++ ?></td>
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
                            <td><?php echo $value["prof_id"] . " - " . $value["sub_prof_id"] ?></td>
                            <td style="text-align: right"><?php echo $value["total_pieces"] ?></td>
                            <td><?php echo $value["color_name"] ?></td>
                            <td><?php echo $value["rec_date"] ?></td>
                            <td style="color: red"><?php echo GenericSetting::daysFromTwoDates($value["rec_date"]) ?> days old </td>
                        </tr>
                        <?php
                    }
                    ?>    
                </tbody>
            </table>
        </div>
    </div>
</div>
