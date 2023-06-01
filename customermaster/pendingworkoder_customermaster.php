<?php
$category = filter_input(INPUT_GET, "category");
if ($category == "") {
    $category = "PVC";
}
$condition = " AND prof_id = '$category' "
        . " AND `ackrecv` = 'YES' "
        . " AND production_update = ''"
        . " AND isLayout != 'Y' ";
$master_result = PackingSlip::getLast5Orders("", $condition);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <div class="card-header" >
        <div class="alert alert-danger" role="alert">
            <b><i>Acknowledgement Received but work order not created</i></b>
        </div>

        <div style="float: left">
            <a href="index.php?pagename=pendingworkoder_customermaster&category=PVC" 
               class="btn btn-label-dark <?php echo $category == "PVC" ? "active" : "" ?>">PVC</a>
            &nbsp;
            <a href="index.php?pagename=pendingworkoder_customermaster&category=LAMINATE" 
               class="btn btn-label-dark <?php echo $category == "LAMINATE" ? "active" : "" ?>">LAMINATE</a>
        </div>
    </div>

    <div class="card-body" style="margin-top: 0px">
        <div class="table-responsive mb-2" style="max-height: 500px;overflow-y: auto;border-bottom: solid 1px #d4d8dd">
            <table class="table table-bordered" >
                <thead style="background-color: rgb(220,220,220);">
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
                            <td>
                                <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["so_no"] ?>
                                </a>
                            </td>
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
                <?php 
                    if(count($master_result) == 0){
                        echo "<tr><td colspan=8; style=color:red>No Records Found</td></tr>";
                    }
                ?>
            </table>
        </div>
        <br/>
        <div style="float: left">
            <a href="#">
                <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-export"></span>&nbsp;Export</button>
            </a>
            &nbsp;
            <a href="#">
                <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-printer"></span>&nbsp;Print</button>
            </a>
            &nbsp;
            <a href="index.php">
                <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-left-arrow"></span>&nbsp;Back</button>
            </a>
        </div>
    </div>
</div>
