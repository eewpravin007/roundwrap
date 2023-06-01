<?php
$category = filter_input(INPUT_GET, "category");
$wrokstation = filter_input(INPUT_GET, "station");
$ps_id = filter_input(INPUT_GET, "ps_id");
$trackingHistory = Production::getTrackingHistory($ps_id);

$shortPackingslip = Production::getShortPackingSLip($ps_id);

$imm_last_phase = $trackingHistory[0];

$order = Production::getPackingSlipLastProductionUpdate($ps_id);
$buttonstatus = Production::trackingPortalButtonName($order["production_update"]);
$filter_input_array = filter_input_array(INPUT_POST);
if (isset($filter_input_array["btnSave"]) || isset($filter_input_array["btnRemake"])) {
    $sub_prof_id = $order["sub_prof_id"];
    $order["phase"] = $wrokstation;
    $order["status"] = $buttonstatus;
    $order["alertHistory"] = $filter_input_array["alertHistory"];
    $order["location"] = $location = $filter_input_array["location"];
    $remakeDoor = $filter_input_array["remake_door"];

    if (isset($filter_input_array["btnRemake"])) {
        Production::setRemakeOrder($remakeDoor, $location, $wrokstation, $ps_id);
    } else {

        Production::createTrackingEvent($order);
        if ($sub_prof_id == "Square Slab" && $wrokstation == "LAMINATE PRESS" && $buttonstatus == "OUT") {
            $order["phase"] = "SAW/BLANKS";
            $order["status"] = "IN";
            $order["alertHistory"] = $filter_input_array["alertHistory"];
            Production::createTrackingEvent($order);

            $order["phase"] = "SAW/BLANKS";
            $order["status"] = "OUT";
            $order["alertHistory"] = $filter_input_array["alertHistory"];
            Production::createTrackingEvent($order);

            $order["phase"] = "POSTFORMING";
            $order["status"] = "IN";
            $order["alertHistory"] = $filter_input_array["alertHistory"];
            Production::createTrackingEvent($order);

            $order["phase"] = "POSTFORMING";
            $order["status"] = "OUT";
            $order["alertHistory"] = $filter_input_array["alertHistory"];
            Production::createTrackingEvent($order);
        }
    }

    header("location:index.php?pagename=move&category=$category&station=$wrokstation&ps_id=$ps_id");
}
?>
<div class="card mb-12" >
    <h5 class="card-header">PERFORM STEP OPERATION - <b style="color: red"><?php echo $wrokstation ?></b></h5>
</div>
<br/>

<form name="frmTracking" id="frmTracking" method="POST">

    <div class="row gy-4">
        <div class="col-xl-4 col-lg-4 col-md-5 order-1 order-md-0">
            <div class="card mb-12">
                <br/>
                <center>
                    <table style="width: 90%;text-align: center">
                        <tr>
                            <td >
                                <h3><?php echo $wrokstation ?></h3>
                                <input type="text" name="alertHistory" class="form-control" style="width: 100%;text-align: center;" autofocus="" placeholder="Enter any deplay note">
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <?php
                                if (($imm_last_phase["phase"] == "VINYL PRESS AND PACK" || $imm_last_phase["phase"] == "LAMINATE CLEAN/PACK" ) && $buttonstatus == "OUT") {
                                    ?>
                                    <input type="text" name="location" value="<?php echo $shortPackingslip["location"] ?>" class="form-control" style="width: 100%;text-align: center;border-color: red" required="" autofocus="" placeholder="Enter location">
                                    <?php
                                }
                                ?>
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center">
                                <?php if ($imm_last_phase["phase"] == $wrokstation && $imm_last_phase["status"] == "OUT") { ?>
                                    <a class="btn btn-gray"  href="index.php?pagename=home&category=<?php echo $category ?>&station=<?php echo $wrokstation ?>" style="font-size: 10px">PROCESS DONE - BACK</a>
                                <?php } else { ?>
                                    <input type="submit" name="btnSave" class="btn btn-success" value="<?php echo $buttonstatus ?>" style="font-weight: bold;font-size: 26px">
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <?php
                                if (($imm_last_phase["phase"] == "VINYL PRESS AND PACK" || $imm_last_phase["phase"] == "LAMINATE CLEAN/PACK" ) && $buttonstatus == "OUT") {
                                    ?>
                                    <br/>
                                    <input type="text" name="remake_door" class="form-control" style="width: 100%;text-align: center;border-color: red" autofocus="" placeholder="Remake Door e.g. 10,20,30">
                                    <br/>
                                    <input type="submit" value="REMAKE DOOR" class="btn btn-success"
                                           style="height: 40px;font-weight: bold;margin-right: 5px" 
                                           name="btnRemake">
                                           <?php
                                       }
                                       ?>
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center">
                                <br/>
                                <a class="btn btn-gray" href="index.php?pagename=home&category=<?php echo $category ?>&station=<?php echo $wrokstation ?>" style="font-size: 10px">BACK</a>
                            </td>
                        </tr>
                    </table>
                </center>
                <br/>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-7 order-0 order-md-1">
            <div class="card mb-12">

                <table class="table table-bordered" id="mastertable">
                    <tr style="">
                        <td>Customer Name</td>
                        <td><b><?php echo $shortPackingslip["cust_companyname"] ?></b></td>
                        <td>Po Number</td>
                        <td><b><?php echo $shortPackingslip["po_no"] ?></b></td>
                    </tr>
                    <tr style="">
                        <td>SO Number</td>
                        <td><b><?php echo $shortPackingslip["so_no"] ?></b></td>
                        <td>Profile</td>
                        <td><b><span class="badge bg-label-danger"><?php echo $shortPackingslip["sub_prof_id"] ?></span></b></td>
                    </tr>
                    <tr style="">
                        <td>Quantity</td>
                        <td><b><?php echo $shortPackingslip["total_pieces"] ?></b></td>
                        <td>Color</td>
                        <td><b><?php echo $shortPackingslip["color_name"] ?></b></td>
                    </tr>
                    <tr style="">
                        <td>Rush Order</td>
                        <td><b><span class="badge bg-label-<?php echo $shortPackingslip["isUrgent"] == "Y" ? "danger" : "success" ?>"><?php echo $shortPackingslip["isUrgent"] == "Y" ? "YES" : "NO" ?></span></b></td>
                        <td>Time Line</td>
                        <td><b><?php echo PackingSlip::deliveryLeft($shortPackingslip["daysLeft"]) ?></b></td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td><b><?php echo $shortPackingslip["location"] ?></b></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <br/>
            <div class="card mb-12">
                <table class="table table-bordered" id="mastertable">
                    <thead style="background-color: rgb(220,220,220);">
                        <tr style="">
                            <th style="width: 25px">#</th>
                            <th>So NO</th>
                            <th>Phase</th>
                            <th>Moment</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Remake</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 1;
                        foreach ($trackingHistory as $value) {
                            ?>
                            <tr style="">
                                <td><?php echo $index++ ?></td>
                                <td><?php echo $value["workOrId"] ?></td>
                                <td><?php echo $value["phase"] ?></td>
                                <td><?php echo $value["status"] ?></td>
                                <td><?php echo $value["phase_date"] ?></td>
                                <td><?php echo $value["phase_time"] ?></td>
                                <td><?php echo $value["remake"] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</form>