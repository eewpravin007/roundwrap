<?php
$customerid = filter_input(INPUT_GET, "customerid");

$customer = Customer::getCustomerById($customerid);
$doorMade = Customer::doorInCustomer($customerid, "IN");
$doorProgress = Customer::doorInCustomer($customerid, "NOT IN");

$nwProgressOrders = PackingSlip::otherInProgressOrdersForCustomer($customerid, "neworders");
$inProgressOrders = PackingSlip::otherInProgressOrdersForCustomer($customerid, "inprogres");
$deliveredOrders = PackingSlip::otherInProgressOrdersForCustomer($customerid, "delivered");
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Hurry!!!.. Please find your search result.</h5>
</div>

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
                <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                    <table class="table table-borderless" style="text-align: center">
                        <tr>
                            <td><span class="badge bg-label-primary p-2 rounded"><i class="bx bx-book bx-sm"></i></span></td>
                            <td><span class="badge bg-label-warning p-2 rounded"><i class="bx bx-adjust bx-sm"></i></span></td>
                            <td><span class="badge bg-label-success p-2 rounded"><i class="bx bx-check bx-sm"></i></span></td>
                        </tr>
                        <tr>
                            <td>
                                <h5 class="mb-0"><?php echo $doorMade + $doorProgress ?></h5>
                                <span>Total Doors</span>
                            </td>
                            <td>
                                <a href="index.php?pagename=searchdisplay_customermaster&customerid=<?php echo $customerid ?>&query=inprogres" style="color: #516377">
                                    <h5 class="mb-0">
                                        <?php echo $doorProgress ?>
                                    </h5>
                                    <span>In Progress</span>
                                </a>
                            </td>
                            <td>
                                <a href="index.php?pagename=searchdisplay_customermaster&customerid=<?php echo $customerid ?>&query=delivered" style="color: #516377">
                                    <h5 class="mb-0">
                                        <?php echo $doorMade ?>
                                    </h5>
                                    <span>Door Made</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="info-container">
                    <table class="table table-bordered">
                        <tr>
                            <td>Customer&nbsp;Name</td>
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
                            <td>Shipping&nbsp;Address</td>
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

            <div class="card">
                <div class="card-header header-elements">
                    <div class="d-flex flex-column">
                        <p class="card-subtitle text-muted mb-1">Monthly Orders</p>
                        <h5 class="card-title fw-bold mb-0">000</h5>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="horizontalBarChart" class="chartjs" data-height="400"></canvas>
                </div>
            </div>

        </div>

    </div>
    <!--/ User Sidebar -->

    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

        <div class="col-md" style="margin-top: -15px">
            <div class="accordion mt-3 accordion-header-primary" id="accordionWithIcon" >


                <?php if (count($nwProgressOrders) != 0) { ?>
                    <div class="accordion-item card">
                        <h2 class="accordion-header d-flex align-items-center">
                            <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionWithIcon-0" aria-expanded="false" >
                                <i class="bx bx-chart me-2"></i>
                                New orders not sent to production&nbsp;<b><?php echo $customer["cust_companyname"] ?></b>
                            </button>
                        </h2>
                        <div id="accordionWithIcon-0" class="accordion-collapse show">
                            <div class="accordion-body">

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
                                            foreach ($nwProgressOrders as $value) {
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
                                    </table>
                                </div>
                                <a href="#" class="btn btn-label-secondary"><i class="bx bx-printer me-2"></i> PRINT REPORT</a>
                                <a href="#" class="btn btn-label-secondary"><i class="bx bx-mail-send me-2"></i> EMAIL REPORT</a>
                                <a href="#" class="btn btn-label-secondary"><i class="bx bx-download me-2"></i> DOWNLOAD REPORT</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (count($inProgressOrders) != 0) { ?>
                <div class="accordion-item card">
                    <h2 class="accordion-header d-flex align-items-center">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionWithIcon-1" aria-expanded="false" >
                            <i class="bx bx-chart me-2"></i>
                            In Progress Orders for&nbsp;<b><?php echo $customer["cust_companyname"] ?></b>
                        </button>
                    </h2>

                    <div id="accordionWithIcon-1" class="accordion-collapse show">
                        <div class="accordion-body">

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
                                        $index1 = 1;
                                        foreach ($inProgressOrders as $value) {
                                            ?>    
                                            <tr style="">
                                                <td><?php echo $index1++ ?></td>
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
                            <a href="#" class="btn btn-label-secondary"><i class="bx bx-printer me-2"></i> PRINT REPORT</a>
                            <a href="#" class="btn btn-label-secondary"><i class="bx bx-mail-send me-2"></i> EMAIL REPORT</a>
                            <a href="#" class="btn btn-label-secondary"><i class="bx bx-download me-2"></i> DOWNLOAD REPORT</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <?php if (count($deliveredOrders) != 0) { ?>
                <div class="accordion-item card">
                    <h2 class="accordion-header d-flex align-items-center">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordionWithIcon-3" aria-expanded="false" >
                            <i class="bx bx-plus-circle me-2"></i>
                            Delivered Orders of&nbsp;<b><?php echo $customer["cust_companyname"] ?></b>
                        </button>
                    </h2>
                    <div id="accordionWithIcon-3" class="accordion-collapse show">
                        <div class="accordion-body">
                            <div class="table-responsive mb-2" style="max-height: 500px;overflow-y: auto;;border-bottom: solid 1px #d4d8dd">
                                <table class="table table-bordered">
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
                                        $index2 = 1;
                                        foreach ($deliveredOrders as $value) {
                                            ?>    
                                            <tr style="">
                                                <td><?php echo $index2++ ?></td>
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
                            <a href="#" class="btn btn-label-secondary"><i class="bx bx-printer me-2"></i> PRINT REPORT</a>
                            <a href="#" class="btn btn-label-secondary"><i class="bx bx-mail-send me-2"></i> EMAIL REPORT</a>
                            <a href="#" class="btn btn-label-secondary"><i class="bx bx-download me-2"></i> DOWNLOAD REPORT</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
