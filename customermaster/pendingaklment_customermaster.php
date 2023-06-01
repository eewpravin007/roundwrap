<?php
$category = filter_input(INPUT_GET, "category");
if ($category == "") {
    $category = "PVC";
}

$master_result = PackingSlip::getLast5Orders("", " AND prof_id = '$category' AND `ackrecv` = 'NO' AND production_update = '' ");
$counter = count($master_result);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <div class="card-header" >
        <div class="alert alert-danger" role="alert">
            <b><i>Order created but, packing slip yet to be confirmed from customer, total <?php echo $counter?> orders</i></b>
        </div>
        <table style="width: 100%">
            <tr>
                <td>
                    <input type="text" id="tablesearch" onkeyup="searchinTable()" 
                           class="form-control" placeholder="Enter Search String" autofocus=""/>
                </td>
                <td style="width: 50%">
                    <div style="float: right"> 
                        <a href="index.php?pagename=pendingaklment_customermaster&category=PVC" 
                           class="btn btn-label-dark <?php echo $category == "PVC" ? "active" : "" ?>">PVC</a>
                        &nbsp;
                        <a href="index.php?pagename=pendingaklment_customermaster&category=LAMINATE" 
                           class="btn btn-label-dark <?php echo $category == "LAMINATE" ? "active" : "" ?>">LAMINATE</a>
                        &nbsp;
                        <a href="exportdata/export_pendingaklment.php?category=<?php echo $category ?>" 
                           target="_blank" class="btn btn-label-dark" >
                            <span class="tf-icons bx bx-import"></span>&nbsp;Export
                        </a>   
                        &nbsp;
                        <a href="printpages/printpages_pendingaklment.php?category=<?php echo $category ?>" 
                           target="_blank" class="btn btn-label-dark" >
                            <span class="tf-icons bx bx-printer"></span>&nbsp;Print
                        </a>   
                        &nbsp;
                        <a href="index.php">
                            <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-left-arrow"></span>&nbsp;Back</button>
                        </a>
                    </div>
                </td>
            </tr>
        </table>



    </div>

    <div class="card-body" style="margin-top: 0px">
        <div class="table-responsive mb-2" style="max-height: 1000px;overflow-y: auto;border-bottom: solid 1px #d4d8dd">
            <table class="table table-bordered" id="mastertable" >
                <thead style="background-color: rgb(220,220,220);">
                    <tr style="">
                        <th style="width: 25px">#</th>
                        <th style="width: 25px">#</th>
                        <th style="width: 25px">#</th>
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
                                <a title="Create Note" href="index.php?pagename=create_notes&search_order=<?php echo $value["so_no"] ?>&criteria=deplaynote">
                                    <i class="bx bx-note"></i>
                                </a>
                            </td>
                            <td>
                                <a title="Send Email" href="#">
                                    <i class="bx bx-mail-send"></i>
                                </a>
                            </td>
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
            </table>
        </div>
        <br/>
        <div style="float: left">
        </div>
    </div>
</div>
