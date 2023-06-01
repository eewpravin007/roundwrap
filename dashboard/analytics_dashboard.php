<?php
$productionLiveChart = MainPageStatestic::getProductionLiveChart();
$pvcAndLaminateLiveStationLoad = MainPageStatestic::getPvcAndLaminateLiveStationLoad();
$onlyProductionOutValues = MainPageStatestic::onlyProductionOutValues();

$counter_row = MainPageStatestic::counterRow();

$pvc_chart_values = ""
        . "" . $pvcAndLaminateLiveStationLoad["CNC-OUT"] . ","
        . "" . $pvcAndLaminateLiveStationLoad["SAND/CLEAN-OUT"] . ","
        . "" . $pvcAndLaminateLiveStationLoad["GLUE-OUT"] . ","
        . "" . $pvcAndLaminateLiveStationLoad["VINYL PRESS AND PACK-OUT"] . ","
        . "" . $onlyProductionOutValues["PVC-PRODUCTION OUT-OUT"] . ""
        . "";
//
$lmi_chart_values = ""
        . "" . $pvcAndLaminateLiveStationLoad["LAMINATE PRESS-OUT"] . ","
        . "" . $pvcAndLaminateLiveStationLoad["SAW/DOOR-OUT"] . ","
        . "" . $pvcAndLaminateLiveStationLoad["EDGE BANDING-OUT"] . ","
        . "" . $pvcAndLaminateLiveStationLoad["LAMINATE CLEAN/PACK-OUT"] . ","
        . "" . $onlyProductionOutValues["LAMINATE-PRODUCTION OUT-OUT"] . ""
        . "";

$orderTimeLineInward = MainPageStatestic::orderTimeLineInward();
$orderTimeLineInProduction = MainPageStatestic::orderTimeLineInProduction();
$orderTimeLineDelivery = MainPageStatestic::orderTimeLineDelivery("", "LIMIT 0,50");

?>
<input type="hidden" id="pvc_chart_values" value="<?php echo $pvc_chart_values ?>">
<input type="hidden" id="lmi_chart_values" value="<?php echo $lmi_chart_values ?>">
<meta http-equiv="refresh" content="120">
<div class="row">
    <div class="col-lg-2 col-md-12 mb-4">
        <a href="index.php?pagename=manage_incomingorder">
            <div class="card" style="text-align: center;color: green">
                <div class="card-header">
                    <h4 style="color: green"><?php echo $counter_row["website_count"] ?></h4>
                    <h5 style="color: green">Website Orders</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-2 col-md-12 mb-4">
        <a href="">
            <div class="card" style="text-align: center">
                <div class="card-header">
                    <h4><?php echo $counter_row["tracking_note"] ?></h4>
                    <h5>Tracking Note</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-2 col-md-12 mb-4">
        <a href="index.php?pagename=pendingaklment_customermaster&category=PVC">
            <div class="card" style="text-align: center;color: red">
                <div class="card-header">
                    <h4 style="color: red"><?php echo $counter_row["pending_akg"] ?></h4>
                    <h5 style="color: red">Pending Acknowledge</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-2 col-md-12 mb-4">
        <a href="">
            <div class="card" style="text-align: center">
                <div class="card-header">
                    <h4 style="color: red"><?php echo $counter_row["tracking_note"] ?></h4>
                    <h5 style="color: red">Over-Due Orders</h5>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-lg-2 col-md-12 mb-4">
        <a href="index.php?pagename=delayed_workorder">
            <div class="card" style="text-align: center;">
                <div class="card-header">
                    <h4 style="color: red"><?php echo $counter_row["late_orders"] ?></h4>
                    <h5 style="color: red">Late Orders</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-2 col-md-12 mb-4">
        <a href="">
            <div class="card" style="text-align: center">
                <div class="card-header">
                    <h4><?php echo $counter_row["tracking_note"] ?></h4>
                    <h5>Orders Note</h5>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Live PVC Production Orders</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="visitsOptions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="visitsOptions">
                        <a class="dropdown-item" href="index.php?pagename=workstation_dashboard&category=PVC">Station Orders</a>
                        <a class="dropdown-item" href="index.php?pagename=workstationload_dashboard">Station Load</a>
                    </div>
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="d-flex justify-content-around align-items-center flex-wrap mb-4">
                    <div class="user-analytics text-center me-2">
                        <i class="bx bx-user me-1"></i>
                        <span>Total Orders</span>
                        <div class="d-flex align-items-center mt-2">
                            <div class="chart-report" data-color="success" data-series="100"></div>
                            <h3 class="mb-0"><?php echo $productionLiveChart["PVC"]["total_order"] ?></h3>
                        </div>
                    </div>
                    <div class="sessions-analytics text-center me-2">
                        <i class="bx bx-pie-chart-alt me-1"></i>
                        <span>Total Doors</span>
                        <div class="d-flex align-items-center mt-2">
                            <div class="chart-report" data-color="success" data-series="100"></div>
                            <h3 class="mb-0"><?php echo $productionLiveChart["PVC"]["total_door"] ?></h3>
                        </div>
                    </div>
                    <div class="sessions-analytics text-center me-2">
                        <i class="bx bx-abacus me-1"></i>
                        <span>Doors Completed</span>
                        <div class="d-flex align-items-center mt-2">
                            <div class="chart-report" data-color="success" data-series="100"></div>
                            <h3 class="mb-0"><?php echo $productionLiveChart["PVC"]["doors_made"] ?></h3>
                        </div>
                    </div>
                    <div class="bounce-rate-analytics text-center">
                        <i class="bx bx-trending-up me-1"></i>
                        <span>Production Rate</span>
                        <div class="d-flex align-items-center mt-2">
                            <div class="chart-report" data-color="warning" data-series="65"></div>
                            <h3 class="mb-0"><?php echo $productionLiveChart["PVC"]["production_rate"] ?>%</h3>
                        </div>
                    </div>
                </div>
                <div id="pvcBarChart"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Live Laminate Production Orders</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="visitsOptions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="visitsOptions">
                        <a class="dropdown-item" href="index.php?pagename=workstation_dashboard&category=lmi">Station Orders</a>
                        <a class="dropdown-item" href="index.php?pagename=workstationload_dashboard">Station Load</a>
                    </div>
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="d-flex justify-content-around align-items-center flex-wrap mb-4">
                    <div class="user-analytics text-center me-2">
                        <i class="bx bx-user me-1"></i>
                        <span>Total Orders</span>
                        <div class="d-flex align-items-center mt-2">
                            <div class="chart-report" data-color="success" data-series="100"></div>
                            <h3 class="mb-0"><?php echo $productionLiveChart["LAMINATE"]["total_order"] ?></h3>
                        </div>
                    </div>
                    <div class="sessions-analytics text-center me-2">
                        <i class="bx bx-pie-chart-alt me-1"></i>
                        <span>Total Doors</span>
                        <div class="d-flex align-items-center mt-2">
                            <div class="chart-report" data-color="success" data-series="100"></div>
                            <h3 class="mb-0"><?php echo $productionLiveChart["LAMINATE"]["total_door"] ?></h3>
                        </div>
                    </div>
                    <div class="sessions-analytics text-center me-2">
                        <i class="bx bx-abacus me-1"></i>
                        <span>Doors Completed</span>
                        <div class="d-flex align-items-center mt-2">
                            <div class="chart-report" data-color="success" data-series="100"></div>
                            <h3 class="mb-0"><?php echo $productionLiveChart["LAMINATE"]["doors_made"] ?></h3>
                        </div>
                    </div>
                    <div class="bounce-rate-analytics text-center">
                        <i class="bx bx-trending-up me-1"></i>
                        <span>Production Rate</span>
                        <div class="d-flex align-items-center mt-2">
                            <div class="chart-report" data-color="danger" data-series="10"></div>
                            <h3 class="mb-0"><?php echo $productionLiveChart["LAMINATE"]["production_rate"] ?>%</h3>
                        </div>
                    </div>
                </div>
                <div id="laminateBarChart"></div>
            </div>
        </div>
    </div>


    <div class="col-xl-4">
        <div class="card">
            <h5 class="card-header">New Orders (Inward Order) TimeLine</h5>
            <div class="card-body ">
                <div class="table-responsive mb-2" style="max-height: 518px;overflow-y: auto;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
                    <table class="table table-bordered" >
                        <thead style="background-color: rgb(220,220,220);">
                            <tr style="">
                                <th>SO NO</th>
                                <th>Customer</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orderTimeLineInward as $value) {
                                ?>
                                <tr style="">
                                    <td>
                                        <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                            <?php echo $value["so_no"] ?>
                                        </a>
                                    </td>
                                    <td><?php echo $value["cust_companyname"] ?></td>
                                    <td>
                                        <small><?php echo PackingSlip::deliveryLeft($value["daysLeft"]) ?></small> 
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div style="float: right">
                    <a href="exportdata/export_inwardorder.php" target="_blank">
                        <button type="button" class="btn btn-sm btn-label-dark">
                            <span class="tf-icons bx bx-import"></span>&nbsp;Export
                        </button>
                    </a>
                    <a href="index.php?pagename=inwardorder_dashboard">
                        <button type="button" class="btn btn-sm btn-label-dark">
                            <span class="tf-icons bx bx-lock-open"></span>&nbsp;View More
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <h5 class="card-header">In Production TimeLine</h5>
            <div class="card-body">
                <div class="table-responsive mb-2" style="max-height: 518px;overflow-y: auto;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
                    <table class="table table-bordered" >
                        <thead style="background-color: rgb(220,220,220);">
                            <tr style="">
                                <th>SO NO</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orderTimeLineInProduction as $value) {
                                ?>
                                <tr style="">
                                    <td>
                                        <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                            <?php echo $value["so_no"] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $value["cust_companyname"] ?><br/>
                                        <small class="" style="color: red">
                                            <?php echo PackingSlip::productionInStatus($value["production_update"]) ?>, 
                                            <?php echo PackingSlip::deliveryLeft($value["daysLeft"]) ?> 
                                        </small>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div style="float: right">
                    <a href="exportdata/export_productionorder.php" target="_blank">
                        <button type="button" class="btn btn-sm btn-label-warning">
                            <span class="tf-icons bx bx-import"></span>&nbsp;Export
                        </button>
                    </a>
                    <a href="index.php?pagename=inproduction_dashboard">
                        <button type="button" class="btn btn-sm btn-label-warning">
                            <span class="tf-icons bx bx-window"></span>&nbsp;View More
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Advanced-->
    <div class="col-xl-4">
        <div class="card">
            <h5 class="card-header">Outward Order TimeLine</h5>
            <div class="card-body">
                <div class="table-responsive mb-2" style="max-height: 518px;overflow-y: auto;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
                    <table class="table table-bordered" >
                        <thead style="background-color: rgb(220,220,220);">
                            <tr style="">
                                <th>SO NO</th>
                                <th>Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orderTimeLineDelivery as $value) {
                                ?>
                                <tr style="">
                                    <td>
                                        <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                            <?php echo $value["so_no"] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $value["cust_companyname"] ?><br/>
                                        <small >
                                            <?php echo PackingSlip::productionInStatus($value["production_update"]) ?><br/> 
                                            <b>Received By <?php echo $value["deliveryContact"] ?></b><br/> 
                                            <?php echo $value["deliveryNote"] ?><br/> 
                                            <?php echo $value["deliveredOn"] ?> 
                                        </small>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div style="float: right">
                    <a href="exportdata/export_deliveryorder.php" target="_blank">
                        <button type="button" class="btn btn-sm btn-label-success">
                            <span class="tf-icons bx bx-import"></span>&nbsp;Export
                        </button>
                    </a>
                    <a href="index.php?pagename=outwardorder_dashboard">
                        <button type="button" class="btn btn-sm btn-label-success">
                            <span class="tf-icons bx bx-window"></span>&nbsp;View More
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>