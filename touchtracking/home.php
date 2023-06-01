<?php
$trackingPhase = Production::trackingPortalPhase($category);

$trackingNote = Production::trackingNotesFromAdmin();

if ($wrokstation != "") {
    $stationWiseOrder = Production::getRecordsForStationTracking($wrokstation, $category, "");
    $_SESSION["stationWiseOrder"] = $stationWiseOrder;
}
?>
<div class="card mb-12" style="padding-bottom: 0px;margin-bottom: 0px">
    <h5 class="card-header">Production Work station workflow <b style="color: red"><?php echo $wrokstation ?></b></h5>
    <form class="card-body" method="POST">
        <?php
        $index = 1;
        foreach ($trackingPhase as $value) {
            $active = $value == $wrokstation ? "active" : "";
            echo $index != 1 ? "<i class='bx bx-right-arrow' style=color:gray></i>" : "";
            ?>
            <a href="index.php?pagename=home&category=<?php echo $category ?>&station=<?php echo $value ?>" 
               class="btn btn-label-secondary <?php echo $active ?>"><?php echo $value ?>
            </a>
            <?php
            $index++;
        }
        ?>
        <a href="https://rmp.roundwrap.com/" style="float: right" class="btn btn-label-secondary active">Log Out</a>
        <?php
        if ($wrokstation == "VINYL PRESS AND PACK") {
            ?>
            <a href="index.php?pagename=cycle&category=<?php echo $category ?>" style="float: right;margin-right: 10px" class="btn btn-label-secondary active">Enter Cycle </a>
            <?php
        }
        ?>
    </form>
    <i style="margin-left: 20px">
        <marquee width="50%" direction="right" height="30px" >
            <?php foreach ($trackingNote as $value) { ?>
                &nbsp;<b class='badge bg-label-<?php echo $value["empid"] ?>'><?php echo $value["reminderbody"] ?></b>&nbsp;
            <?php } ?>
        </marquee>
    </i>
</div>
<br/>
<div class="card mb-12" style="padding-bottom: 0px;margin-bottom: 0px">
    <div class="card-body" >
        <table style="width: 100%">
            <tr>
                <td>
                    <input type="text" id="tablesearch" onkeyup="searchinTable()" class="form-control" placeholder="Enter Search String" autofocus="" value="<?php echo $color_name ?>"/>
                </td>
                <td style="text-align: right">
                    &nbsp;
                    &nbsp;
                    <?php if ($wrokstation == "LAMINATE PRESS" || $wrokstation == "CNC") { ?>
                        <a href="index.php?pagename=prodin&category=<?php echo $category ?>&station=<?php echo $wrokstation ?>" class="btn btn-label-success" ><i class="bx bx-plus"></i>ADD MISSING</a>
                    <?php } ?>
                    &nbsp;
                    <a href="index.php" class="btn btn-label-secondary" ><i class="bx bx-arrow-to-left"></i>BACK</a>
                    &nbsp;
                    <a href="print.php" target="_blank" class="btn btn-label-secondary" ><i class="bx bx-printer me-2"></i> PRINT REPORT</a>
                    &nbsp;
                    <a href="downlaod.php" target="_blank" class="btn btn-label-secondary" ><i class="bx bx-download me-2"></i> DOWNLOAD REPORT</a>      
                </td>
            </tr>
        </table> 
    </div>
    <table class="table table-bordered" id="mastertable">
        <thead style="background-color: rgb(220,220,220);">
            <tr style="">
                <th>#</th>
                <th>Customer</th>
                <th>WO NO</th>
                <th>PO NO</th>
                <th>Quantity</th>
                <th>Profile</th>
                <th>Color</th>
                <th>Del.Date</th>
                <th>Time.Line</th>
                <th>Status</th>
                <th>Rush</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $index01 = 1;
            foreach ($stationWiseOrder as $value) {
                $psid = $value["ps_id"];
                ?>    
                <tr style="">
                    <td><?php echo $index01++ ?></td>
                    <td><?php echo $value["cust_companyname"] ?></td>
                    <td>
                        <a href="index.php?pagename=move&category=<?php echo $category ?>&station=<?php echo $wrokstation ?>&ps_id=<?php echo $psid ?>">
                            <b><?php echo $value["workOrd_Id"] ?></b>
                        </a>
                    </td>
                    <td><?php echo $value["po_no"] ?></td>
                    <td><?php echo $value["total_pieces"] ?></td>
                    <td><span class="badge bg-label-danger"><?php echo $value["sub_prof_id"] ?></span></td>
                    <td><?php echo $value["color_name"] ?></td>
                    <td><?php echo $value["req_date"] ?></td>
                    <td><?php echo PackingSlip::deliveryLeft($value["daysLeft"]) ?></td>
                    <td><?php echo PackingSlip::productionInStatus($value["production_update"]) ?></td>
                    <td><span class="badge bg-label-<?php echo $value["isUrgent"] == "Y" ? "danger" : "success" ?>"><?php echo $value["isUrgent"] == "Y" ? "YES" : "NO" ?></span></td>
                </tr>
                <?php
            }
            ?>    
            <?php
            if (count($stationWiseOrder) == 0) {
                echo "<tr><td colspan=13 style=color:red;text-aligh:center>Sorry no record found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
$cyclecountresult = MysqlConnection::fetchCustom("SELECT * FROM `tbl_cycle_count` ORDER BY `date` DESC LIMIT 0, 28");
$count = "";
$dates = "";

foreach ($cyclecountresult as $value) {
    $expload = explode(" ", $value["date"]);
    $count = $count . "" . $value["count"] . ",";
    $dates = $dates . "" . $expload[0] . ",";
}
?>
<?php
if ($wrokstation == "VINYL PRESS AND PACK") {
    ?>
    <input type="hidden" id="count" value="<?php echo $count ?>">
    <input type="hidden" id="dates" value="<?php echo $dates ?>">
    <br/>
    <div class="card mb-12">
        <div class="card mb-6">
            <div class="card" style="padding: 10px;font-size: 12px">
                <br/>
                <div id="lineChart" ></div>
            </div>
        </div>
    </div>
<?php } ?>