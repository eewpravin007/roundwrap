<?php
$array_where = array();
$array_where["columns"] = "ps_id, po_no, so_no,  prof_id, sub_prof_id, billable_fitsquare, total_pieces, "
        . " rec_date, req_date, cust_id, datediff(req_date, now()) as daysLeft, packingnote, packlebels, packvalues, isUrgent,"
        . " production_update, production_update_date, "
        . " isLayout, deliveryPerson, deliveryContact, deliveryNote, deliveredOn, location, packingnote";
$array_where["order_by"] = " ORDER BY so_no LIMIT 0, 50";

$so_no = filter_input(INPUT_GET, "search_order");
$param = filter_input(INPUT_GET, "criteria");

$array_where["where"] = " AND so_no = '$so_no' ";
$master_result = PackingSlip::searchPackingSlip($array_where);
$customerid = $master_result["cust_id"];
$customer = Customer::getCustomerById($customerid);

$filter_input_array = filter_input_array(INPUT_POST);

if ($filter_input_array["btnDelete"] == "DELETE THIS ORDER" || $filter_input_array["btnSubmit"] == "CREATE NOTE") {

    $notearray = array();
    $notearray["notetype"] = $param;
    $notearray["ps_id"] = $master_result["ps_id"];
    $notearray["so_no"] = $so_no;
    $notearray["cust_id"] = $customerid;
    $notearray["notedesc"] = $filter_input_array["notedesc"];
    $notearray["addeddate"] = date("Y-m-d");
    $notearray["addedby"] = $_SESSION["user"]["email"];

    if ($filter_input_array["btnDelete"] == "DELETE THIS ORDER") {
        $notearray["notetype"] = "delete_order";
        PackingSlip::deleteAndCleanPackingSlip($master_result["ps_id"]);
    }
    Notes::createNotes("", $notearray);
    header("location:index.php?pagename=create_notes&search_order=$so_no&criteria=deplaynote");
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
<script type="text/javascript">
    //var blink = document.getElementById("blinktext");
    setInterval(function () {
        //blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
    }, 1500);
</script>
<div class="card mb-4">
    <h5 class="card-header">Your notes section</h5>
</div>
<form name="frmNote" id="frmNote" method="post">
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

                        </div>
                    </div>
                    <div class="info-container">
                        <table class="table table-bordered">
                            <tr>
                                <td>Customer</td>
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

        </div>
        <!--/ User Sidebar --> 

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            <div class="card mb-4">
                <div class="card-body">
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
                                <b style="color: red" id="blinktext">
                                    Customer order is&nbsp;
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
                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <b style="color: red"><?php Notes::noteType($param) ?></b>
                    <hr>
                    <textarea class="form-control" required="" autofocus="" style="height: 150px;line-height: 26px;resize: none" id="notedesc" name="notedesc"></textarea>
                    <div class="mt-2">
                        <?php Notes::toggleButton($param)?>
                        &nbsp;
                        <a href="index.php"  class="btn btn-label-secondary">
                            BACK
                        </a>
                    </div>
                    <br/>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <b style="color: red">Old notes for customer</b>
                    <hr/>
                    <table class="table table-bordered" id="mastertable">
                        <thead style="background-color: rgb(220,220,220);">
                            <tr >
                                <th>#</th>
                                <th>SO NO</th>
                                <th>Note</th>
                                <th>Added By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listofnotes = Notes::listOrGetNotes("", "", $customerid);
                            $index = 1;
                            foreach ($listofnotes as $value) {
                                ?>
                                <tr >
                                    <td><?php echo $index ?></td>
                                    <td><?php echo $value["so_no"] ?></td>
                                    <td><?php echo $value["notedesc"] ?></td>
                                    <td><?php echo $value["addedby"] ?></td>
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
</form>
