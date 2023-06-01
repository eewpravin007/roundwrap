<?php
session_start();
ob_start();
$category = filter_input(INPUT_GET, "category");
$profile_name = filter_input(INPUT_GET, "profile_name");

$getProfilesGroup = Profiles::getProfilesGroup($category);
if ($profile_name == "") {
    $profile_name = $getProfilesGroup["profile"][0];
}

$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["frmAddToGroup"] == "ADD FOR PRODUCTION IN") {
    $selected_for_prod_in = Profiles::groupProfileFromPackingSLip($getProfilesGroup["profile_order"][$profile_name], $filter_input_array["select"]);
    $keys = $selected_for_prod_in["psid"];
    $value = $selected_for_prod_in["value"];
    Production::putOrderInProdIn($keys);
    Production::createEntryForTracking($value, "PRODUCTION IN-OUT");
    header("location:index.php?pagename=group_profiles&category=$category&profile_name=$profile_name");
}
?>
<div class="card md-12">
    <h5 class="card-header">Excellent!!!.. Check yours profiles details and orders for <i><?php echo $category ?>, <?php echo $profiles_name ?></i> </h5>

    <div class="row gy-4"  >
        <div class="col-xl-12 col-lg-5 col-md-5 order-1 order-md-0">
            <div class="card-body" style="margin-top: -10px">
                <form  method="POST" enctype="multipart/form-data">
                    <div class="row mb-5">
                        <div class="col-md-2 col-lg-3">
                            <table class="table table-bordered">
                                <thead style="background-color: rgb(220,220,220);">
                                    <tr >
                                        <th>Profiles&nbsp;Name</th>
                                        <th style="text-align: right">Orders</th>
                                        <th>Group</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($getProfilesGroup["profile"] as $value) {
                                        $selected = "";
                                        if ($profile_name == $value) {
                                            $selected = "style='background-color: #e2e4e6'";
                                        } else {
                                            $selected = "";
                                        }
                                        ?> 
                                        <tr <?php echo $selected ?>>
                                            <td><?php echo ucwords(strtolower($value)) ?></td>
                                            <td style="text-align: right">
                                                <b><?php echo GenericSetting::numberFormat(count($getProfilesGroup["profile_order"][$value])) ?></b>
                                            </td>
                                            <td>
                                                <a href="index.php?pagename=group_profiles&category=<?php echo $category ?>&profile_name=<?php echo $value ?>">
                                                    <small>Group</small>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>   
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-10 col-lg-9">
                            <div class="col-md-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" id="tablesearch" onkeyup="searchinTable()" class="form-control" placeholder="Enter Search String" autofocus="" />
                                </div>
                            </div>
                            <br/>
                            <div style="overflow: auto;max-height: 825px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
                                <table class="table table-bordered" id="mastertable" >
                                    <thead style="background-color: rgb(220,220,220);">
                                        <tr >
                                            <th>#</th>
                                            <th>#</th>
                                            <th>Customer Name</th>
                                            <th>Brand</th>
                                            <th>SO NO</th>
                                            <th>Del.Date</th>
                                            <th>Doors</th>
                                            <th >#</th>
                                            <th style="text-align: right">SQFeet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 1;
                                        $doors_total = 0;
                                        $sqfeet_total = 0;
                                        $total_grp_orders = $getProfilesGroup["profile_order"][$profile_name];
                                        foreach ($total_grp_orders as $value) {
                                            $doors_total = $doors_total + $value["total_pieces"];
                                            $sqfeet_total = $sqfeet_total + $value["billable_fitsquare"];
                                            if (in_array($value["ps_id"], $filter_input_array["select"])) {
                                                $checked = 'checked=""';
                                                $bgv = 'class="alert alert-secondary"';
                                            } else {
                                                $checked = '';
                                                $bgv = "";
                                            }
                                            ?> 
                                            <tr <?php echo $bgv ?>>
                                                <td>
                                                    <input type="checkbox" name="select[]" id="select[]" 
                                                    <?php echo $checked ?>
                                                           value="<?php echo $value["ps_id"] ?>">
                                                </td>
                                                <td><?php echo $index++ ?></td>
                                                <td><?php echo $value["cust_companyname"] ?></td>
                                                <td><?php echo $value["colorbrand"] ?></td>
                                                <td>
                                                    <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                                        <?php echo $value["so_no"] ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $value["req_date"] ?></td>
                                                <td style="text-align: right"><?php echo $value["total_pieces"] ?></td>
                                                <td><?php echo PackingSlip::deliveryLeft($value["daysLeft"]) ?></td>
                                                <td style="text-align: right"><?php echo GenericSetting::numberFormat($value["billable_fitsquare"]) ?></td>
                                            </tr>
                                        <?php } ?>   
                                    </tbody>
                                    <tfoot style="background-color: rgb(220,220,220);">
                                        <tr >
                                            <td colspan="6"></td>
                                            <td style="text-align: right"><b><?php echo $doors_total ?></b></td>
                                            <td></td>
                                            <td style="text-align: right"><b><?php echo $sqfeet_total ?></b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="" style="margin-top: 15px;float: left">
                                <input type="submit" name="frmAddToGroup" 
                                       class="btn btn-label-secondary"
                                       value="ADD FOR PRODUCTION IN">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div> 
</div>