<?php
$sales_order_no = filter_input(INPUT_GET, "sales_order_no");

$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnSearch"] == "Search" || $sales_order_no != "") {

    $po_number = filter_input(INPUT_POST, "po_no");
    if ($po_number != "") {
        header("location:index.php?pagename=historypo_customermaster&po_number=" . $po_number);
    }

    $so_number = filter_input(INPUT_POST, "so_no");
    if($so_number == ""){
        $so_number = $sales_order_no;
    }
    $resultset = HistoryOrders::getPackingSlipDetails($so_number);

    $database = $resultset["db"];

    $master_result = $resultset["order"];
    $packingslip_detail_master = $resultset["items"];

    $customer = Customer::getCustomerById($master_result["cust_id"]);
    $tracking = PackingSlip::tracking($so_number, $database);
    $tracking_phase = PackingSlip::trackingPhase($master_result["prof_id"]);
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
<div class="card mb-4">
    <h5 class="card-header">Search history orders for customer</h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-2">
                <label class="form-label" for="so_no">Sales Order Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="so_no" name="so_no" 
                           class="form-control" placeholder="123456" autofocus="" 
                          
                           value="<?php echo $so_number ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-8">
                <label class="form-label" for="po_no"># Purchase Order Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="po_no" name="po_no" class="form-control" placeholder="PO 0023"  value="<?php echo $master_result["po_no"] ?>" />
                    <span class="input-group-text" id="po_no2"><i class="bx bx-album"></i></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-password-toggle">
                    <label class="form-label" for="">&nbsp;</label>
                    <div class="input-group input-group-merge">
                        <input  type="submit" class="btn btn-primary me-sm-3 me-1" name="btnSearch" value="Search">
                        <a href="index.php?pagename=main_dashboard" class="btn btn-label-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div> 
        </div>
    </form>
</div>

<?php if (count($resultset) != 0) { ?>
    <div class="row gy-4">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img
                                class="img-fluid rounded my-4"
                                src="assets/img/avatars/10.png"
                                height="110"
                                width="110"
                                alt="User avatar"
                                />
                            <div class="user-info text-center">
                                <h5 class="mb-2"><?php echo $customer["cust_companyname"] ?></h5>
                                <span class="badge bg-label-secondary">Customer</span>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="info-container">
                        <table class="table table-bordered">
                            <tr>
                                <td>Full Name</td>
                                <td><b><?php echo $customer["firstname"] . " " . $customer["lastname"] ?></b></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><b><?php echo $customer["cust_email"] ?></b></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <span class='badge bg-label-<?php echo $customer["status"] == "Y" ? "success" : "danger" ?>'>
                                        <?php echo $customer["status"] == "Y" ? "Active" : "InActive" ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone No</td>
                                <td><b><?php echo $customer["phno"] ?></b></td>
                            </tr>
                            <tr>
                                <td>Fax No</td>
                                <td><b><?php echo $customer["cust_fax"] ?></b></td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td><?php echo $customer["billto"] ?></td>
                            </tr>
                            <tr>
                                <td>Country:</td>
                                <td><b><?php echo $customer["country"] ?></b></td>
                            </tr>
                            <tr>
                                <td>Using&nbsp;Tracking</td>
                                <td>
                                    <span class='badge bg-label-<?php echo $customer["enable_tracking"] == "Y" ? "success" : "danger" ?>'>
                                        <?php echo $customer["enable_tracking"] == "Y" ? "Yes" : "No" ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Using&nbsp;Portal</td>
                                <td>
                                    <span class='badge bg-label-<?php echo $customer["portalUser"] == "Y" ? "success" : "danger" ?>'>
                                        <?php echo $customer["portalUser"] == "Y" ? "Yes" : "No" ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <a target="_blank" href="../../roundwrap/download/packingslip/<?php echo $so_number ?>_packingslip.pdf" 
                       class="btn btn-label-secondary" style="width: 100%"><i class="bx bx-printer"></i>
                        &nbsp;PRINT PACKING SLIP</a>
                    <br/>
                    <br/>
                    <a target="_blank" href="../../roundwrap/download/packingslipakg/<?php echo $so_number ?>_acknowledgement.pdf" 
                       class="btn btn-label-secondary" style="width: 100%"><i class="bx bx-printer"></i>
                        &nbsp;PRINT ACKNOWLEDGEMENT</a>
                    <br/>
                    <br/>
                    <a target="_blank" href="../../roundwrap/download/workorder/<?php echo $so_number ?>_workorder.pdf" 
                       class="btn btn-label-secondary" style="width: 100%"><i class="bx bx-printer"></i>
                        &nbsp;PRINT WORK ORDER</a>
                    <br/>
                </div>
            </div>
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            <div class="col-md" style="margin-top: -15px">
                <div class="accordion mt-3 accordion-header-primary" id="accordionWithIcon" >

                    <div class="card accordion-item active">
                        <h2 class="accordion-header d-flex align-items-center">
                            <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#accordionWithIcon-1" aria-expanded="true" >
                                <i class="bx bx-bar-chart-alt-2 me-2"></i>
                                Work Order / Packing Slip Details
                            </button>
                        </h2>

                        <div id="accordionWithIcon-1" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>SO&nbsp;Number&nbsp;</td>
                                        <td><b><?php echo $master_result["so_no"] ?></b></td>
                                        <td>PO&nbsp;Number&nbsp;</td>
                                        <td><b><?php echo $master_result["po_no"] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td><b><?php echo $master_result["prof_id"] ?></b></td>
                                        <td>Profile</td>
                                        <td><b><?php echo $master_result["sub_prof_id"] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>SQ Foot</td>
                                        <td><b><?php echo $master_result["billable_fitsquare"] ?></b></td>
                                        <td>Door Quantity</td>
                                        <td><b><?php echo $master_result["total_pieces"] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Order Date</td>
                                        <td><b><?php echo $master_result["rec_date"] ?></b></td>
                                        <td>Delivery Date</td>
                                        <td><b><?php echo $master_result["req_date"] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Production Update</td>
                                        <td><b><?php echo PackingSlip::productionInStatus($master_result["production_update"]) ?></b></td>
                                        <td>Update Date</td>
                                        <td><b><?php echo $master_result["production_update_date"] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Time Line</td>
                                        <td>
                                            <b>
                                                <?php
                                                if ($master_result["production_update"] == "ORDER DELIVERED") {
                                                    echo PackingSlip::deliveryLeft($master_result["daysLeft"]) . "";
                                                } else {
                                                    echo PackingSlip::deliveryLeft($master_result["daysLeft"]);
                                                }
                                                ?>
                                            </b>
                                        </td>
                                        <td>Urgent Order??</td>
                                        <td>
                                            <b>
                                                <span class='badge bg-label-<?php echo $customer["isUrgent"] == "Y" ? "success" : "danger" ?>'>
                                                    <?php echo $customer["isUrgent"] == "Y" ? "Yes" : "No" ?>
                                                </span>
                                            </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Packing Note</td>
                                        <td colspan="3"><b><?php echo $master_result["packingnote"] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Location</td>
                                        <td><b><?php echo $master_result["location"] ?></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-body" style="text-align: left">
                            <h6><i class="bx bx-bar-chart-alt-2 me-2"></i>Order Tracking</h6>
                            <div style="overflow: auto">
                                <table border="0" class="table table-bordered table-responsive">
                                    <tr>
                                        <?php
                                        foreach ($tracking_phase as $phase) {
                                            $trackresult = $tracking[$phase];
                                            $color = $trackresult["color"];
                                            if ($master_result["isLayout"] != "Y") {
                                                if ($phase == "WORK ORDER") {
                                                    $color = "green";
                                                } else if ($color == "") {
                                                    $color = "red";
                                                }
                                            } else {
                                                $color = "green";
                                            }
                                            ?>
                                            <td>
                                                <div class="tracking" style="background-color: <?php echo $color ?>">

                                                </div>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php foreach ($tracking_phase as $phase) { ?>
                                            <td>
                                                <span style="transform: rotate(45deg);font-size: 12px;text-align: center">
                                                    <center><?php echo $phase ?></center>
                                                </span>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php if ($master_result["isLayout"] == "Y") { ?>
                        <div class="card mb-4">
                            <div class="card-body" style="text-align: left">
                                <h6><i class="bx bx-car me-2"></i>Delivery Details</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Given&nbsp;By&nbsp;</td>
                                        <td><b><?php echo $master_result["deliveryPerson"] ?></b></td>
                                        <td>Note&nbsp;</td>
                                        <td><b><?php echo $master_result["deliveryNote"] ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Received&nbsp;By&nbsp;</td>
                                        <td><b><?php echo $master_result["deliveryContact"] ?></b></td>
                                        <td>Delivered&nbsp;On&nbsp;</td>
                                        <td><b><?php echo $master_result["deliveredOn"] ?></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="card" style="margin-top: -15px;">
                        <h2 class="accordion-header d-flex align-items-center">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionWithIcon-2" aria-expanded="false">
                                <i class="bx bx-briefcase me-2"></i>
                                Doors Details
                            </button>
                        </h2>
                        <div id="accordionWithIcon-2" class="accordion-collapse active">
                            <div class="accordion-body">
                                <div class="table-responsive mb-2" style="max-height: 100%;overflow-y: auto;border-bottom: solid 1px #d4d8dd">
                                    <table class="table table-bordered">
                                        <thead style="background-color: rgb(220,220,220);">
                                            <tr style="text-align: center">
                                                <th>#</th>
                                                <th>Door Type</th>
                                                <th>Quantity</th>
                                                <th>MM Width</th>
                                                <th>MM Height</th>
                                                <th>Width</th>
                                                <th>Height</th>
                                                <th>SQ Feet</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $index = 1;
                                            foreach ($packingslip_detail_master as $value) {
                                                ?>    
                                                <tr style="text-align: center">
                                                    <td><?php echo $index++ ?></td>
                                                    <td  style="text-align: left"><?php echo $value["type"] ?></td>
                                                    <td ><?php echo $value["pcs"] ?></td>
                                                    <td><?php echo $value["mm_w"] ?></td>
                                                    <td><?php echo $value["mm_h"] ?></td>
                                                    <td style="text-align: left"><?php echo $value["inch_w"] ?></td>
                                                    <td style="text-align: left"><?php echo $value["inch_h"] ?></td>
                                                    <td><?php echo $value["sqFeet"] ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php } ?>