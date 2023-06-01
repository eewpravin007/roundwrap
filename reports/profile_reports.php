<?php
$category_get = filter_input(INPUT_GET, "category");
$profilename = filter_input(INPUT_GET, "profile");

$category = $category_get == "" ? "PVC" : $category_get;
$displayarray = Profiles::getProfileForMasterPage($category);
$profilenamearray = $displayarray[0];

$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnSearch"] == "Search") {
    $profilename = $filter_input_array["profilename"];
    $_SESSION["profile_search"] = $profilename;
}

$profilereportdata = Profiles::getProfileDataForReport($category, $profilename);
$counter = count($profilereportdata);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">RoundWrap - Profiles Report for <b style="color: red"><?php echo $profilename ?></b></h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label" for="profilename">Profile Names</label>
                <div class="input-group input-group-merge">
                    <select class="form-control" id="profilename" name="profilename" >
                        <option>Select profile name</option>
                        <?php
                        foreach ($profilenamearray as $value) {
                            ?>
                            <option 
                            <?php echo $profilename == $value ? "selected" : "" ?> 
                                <?php echo $value ?>><?php echo $value ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-password-toggle">
                    <label class="form-label" for="">&nbsp;</label>
                    <div class="input-group">
                        <input  type="submit" class="btn btn-secondary" name="btnSearch" value="Search">
                        &nbsp;&nbsp;&nbsp;
                        <a  href="index.php?pagename=profile_reports&category=PVC" class="btn btn-label-secondary <?php echo $category == "PVC" ? "active" : "" ?>">
                            PVC
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=profile_reports&category=LAMINATE" class="btn btn-label-secondary <?php echo $category == "LAMINATE" ? "active" : "" ?>">
                            LAMINATE
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=master_colors&category=<?php echo $category ?>" class="btn btn-label-secondary">
                            <i class="bx bx-arrow-back" style="color: gray"></i>&nbsp;Cancel
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="exportdata/export_profilereport.php?category=<?php echo $category ?>&profilename=<?php echo $profilename ?>" target="_blank">
                            <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-import"></span>&nbsp;Export</button>
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="printpages/printpages_profilereports.php?category=<?php echo $category ?>&profilename=<?php echo $profilename ?>" target="_blank">
                            <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-printer"></span>&nbsp;Print</button>
                        </a>
                    </div>
                </div>
            </div> 
        </div>
    </form>
    <div class="card-body" style="margin-top: -20px">
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="table table-bordered">
                <thead style="background-color: rgb(220,220,220);">
                    <tr >
                        <th>#</th>
                        <th>Customer</th>
                        <th>So&nbsp;Number</th>
                        <th>Po&nbsp;Number</th>
                        <th>Profile&nbsp;Style</th>
                        <th>Total&nbsp;Doors</th>
                        <th>Production&nbsp;Update</th>
                        <th>Order&nbsp;Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($profilereportdata as $value) {
                        ?>
                        <tr >
                            <td><?php echo $index++ ?></td>
                            <td><?php echo $value["customername"] ?></td>
                            <td>
                                <a href="index.php?pagename=history_customermaster&sales_order_no=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["so_no"] ?>
                                </a>
                            </td>
                            <td>
                                <a href="index.php?pagename=history_customermaster&sales_order_no=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["po_no"] ?>
                                </a>
                            </td>
                            <td><?php echo $value["prof_id"] . "-" . $value["sub_prof_id"] ?></td>
                            <td><?php echo $value["total_pieces"] ?></td>
                            <td><?php echo PackingSlip::productionInStatus($value["production_update"]) ?></td>
                            <td>
                                <span class="badge bg-label-<?php echo $value["order"] == "Active" ? "success" : "danger" ?>">
                                    <?php echo $value["order"] == "Active" ? "Live" : "History" ?>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br/>
        <div style="float: right">
        </div>
    </div>
</div>
