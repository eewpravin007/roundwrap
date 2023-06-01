<?php
$category = filter_input(INPUT_GET, "category");
if ($category == "") {
    $category = "PVC";
}

$packingslip = PackingSlip::getDelayedOrders("", " AND prof_id = '$category' ");
$count_recors = count($packingslip);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <div class="card-header">
        <div class="alert alert-danger" role="alert">
            <b><i><?php echo $count_recors ?>, <?php echo $category ?> Orders are behind its schedule</i></b>
        </div>
        <table style="width: 100%">
            <tr>
                <td>
                    <input type="text" id="tablesearch" onkeyup="searchinTable()" 
                           class="form-control" placeholder="Enter Search String" autofocus="" style="width: 50%"/>

                </td>
                <td>
                    <div style="float: right">
                        <a href="index.php?pagename=delayed_workorder&category=PVC" 
                           class="btn btn-label-dark <?php echo $category == "PVC" ? "active" : "" ?>">PVC</a>
                        &nbsp;
                        <a href="index.php?pagename=delayed_workorder&category=LAMINATE" 
                           class="btn btn-label-dark <?php echo $category == "LAMINATE" ? "active" : "" ?>">LAMINATE</a>
                        &nbsp;
                        <a href="exportdata/export_delayedworkorder.php?category=export_delayedworkorder" target="_blank">
                            <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-import"></span>&nbsp;Export</button>
                        </a>
                        &nbsp;
                        <a href="printpages/printpages_delayedworkorder.php?category=printpages_delayedworkorder" target="_blank">
                            <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-printer"></span>&nbsp;Print</button>
                        </a>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="card-body" style="margin-top: 0px">
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="dt-select-table table table-bordered" id="mastertable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Category</th>
                        <th>So&nbsp;Number</th>
                        <th>Color</th>
                        <th>Po&nbsp;Number</th>
                        <th>Days&nbsp;Left</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($packingslip as $value) {
                        $so_no = $value["so_no"];
                        ?>
                        <tr>
                            <td><?php echo $index++ ?></td>
                            <td>
                                <a href="index.php?pagename=create_notes&search_order=<?php echo $so_no ?>&criteria=deplaynote" >
                                    <i class="bx bx-note" style="color: gray" title="PRINT WORK ORDER"></i>
                                </a>
                            </td>
                            <td class="break-me"><?php echo $value["cust_companyname"] ?></td>
                            <td><?php echo $value["sub_prof_id"] ?></td>
                            <td>
                                <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["so_no"] ?>
                                </a>
                            </td>
                            <td ><?php echo $value["color_name"] ?></td>
                            <td  class="break-me"><?php echo $value["po_no"] ?></td>
                            <td>
                                <small>
                                    <?php echo PackingSlip::deliveryLeft($value["daysLeft"]) ?>
                                </small>
                            </td>
                            <td>
                                <small>
                                    <?php echo PackingSlip::productionInStatus($value["production_update"]) ?>
                                </small>
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
