<?php
$category = filter_input(INPUT_GET, "category");
$search = $category == "lmi" ? "LAMINATE" : "PVC";
$trackingPhase = PackingSlip::trackingPhase($search);

if ($search == "LAMINATE") {
    unset($trackingPhase[0]);
    unset($trackingPhase[8]);
    unset($trackingPhase[9]);
} else {
    unset($trackingPhase[0]);
    unset($trackingPhase[6]);
    unset($trackingPhase[7]);
}

$station_name = filter_input(INPUT_GET, "station_name");
if ($station_name == "") {
    $current_phase = $trackingPhase[1];
} else {
    $current_phase = $station_name;
}

$stationWiseOrder = PackingSlip::stationWiseReport($current_phase);
?>

<div class="card mb-12" style="padding-bottom: 0px;margin-bottom: 0px">
    <h5 class="card-header">Search Orders on Laminate workstation - <?php echo $current_phase ?></h5>
    <form class="card-body" method="POST">
        <?php
        foreach ($trackingPhase as $value) {
            $active = $value == $station_name ? "active" : "";
            ?>
            <a href="index.php?pagename=workstation_dashboard&category=<?php echo $category ?>&station_name=<?php echo $value ?>" 
               class="btn btn-label-secondary <?php echo $active ?>">
                   <?php echo $value ?>
            </a>&nbsp;
            <?php
        }
        ?>
        <a href="index.php?pagename=workstation_dashboard&category=<?php echo $category ?>&station_name=PRODUCTION OUT" 
           class="btn btn-label-secondary <?php echo $active = "PRODUCTION OUT" == $station_name ? "active" : ""; ?>">
            PRODUCTION OUT
        </a>
        <hr>
    </form>
    <div class="card-body" style="margin-top: -20px;padding-top: 0px">
        <table style="width: 100%">
            <tr>
                <td>
                    <input type="text" id="tablesearch" onkeyup="searchinTable()" class="form-control" placeholder="Enter Search String" autofocus="" value="<?php echo $color_name ?>"/>
                </td>
                <td>
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <a href="printpages/printpages_workstationdashboard.php?category=<?php echo $category ?>&station_name=<?php echo $station_name ?>" 
                       target="_blank"
                       class="btn btn-label-secondary" ><i class="bx bx-printer me-2"></i> PRINT REPORT</a>
                    &nbsp;
                    <a href="#" class="btn btn-label-secondary" ><i class="bx bx-mail-send me-2"></i> EMAIL REPORT</a>
                    &nbsp;
                    <a href="exportdata/export_workstationdashboard.php?category=<?php echo $category ?>&station_name=<?php echo $station_name ?>" 
                       target="_blank"
                       class="btn btn-label-secondary" ><i class="bx bx-download me-2"></i> DOWNLOAD REPORT</a>      
                </td>
            </tr>
        </table> 
        <br/>
        <div class="table-responsive mb-2" style="max-height: 518px;overflow-y: auto;border-bottom: solid 1px #d4d8dd">
            <table class="table table-bordered" id="mastertable">
                <thead style="background-color: rgb(220,220,220);">
                    <tr style="">
                        <th>#</th>
                        <th>Customer</th>
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
                    foreach ($stationWiseOrder as $value) {
                        ?>    
                        <tr style="">
                            <td><?php echo $index01++ ?></td>
                            <td><?php echo $value["cust_companyname"] ?></td>
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
                    <?php
                    if (count($stationWiseOrder) == 0) {
                        echo "<tr><td colspan=8 style=color:red;text-aligh:center>Sorry no record found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-body demo-inline-spacing" style="margin-top: -30px;padding-top: 0px;">

    </div>
</div>