<?php
$userid = filter_input(INPUT_GET, "primary");
$user = UserManager::getUserFronLogin($userid);

$arrmaster = UserManager::getUserMenus("master");
$arrretial = UserManager::getUserMenus("retial");
$arrproduction = UserManager::getUserMenus("production");
$arrsystem = UserManager::getUserMenus("system");

?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
    .tblcustom{
        width: 100%;
    }
    .tblcustom td{
        padding: 1px;
        border: solid 1px rgb(220,220,220);
    }
    .tblcustom th{
        height: 40px;
        text-align: center;
        border: solid 1px rgb(220,220,220);
    }
    .inputextend{
        height: 30px;
        border-radius: 0px;
        width: 100%;
        text-align: center;
        border: solid 0px;
    }
</style>

<div class="card">
    <form name="frmPs" method="post" enctype="multipart/form-data">
        <h5 class="card-header">Show User and Permission Details</h5>
        <div class="card-body demo-inline-spacing" >
            <table class="table table-bordered">
                <tr>

                    <td>First Name</td>
                    <td><b><?php echo $user["firstName"] ?></b></td>
                    <td>Last Name</td>
                    <td><b><?php echo $user["lastName"] ?></b></td>
                    <td>Designation</td>
                    <td><b><?php echo $user["name"] ?></b></td>
                </tr>
                <tr>
                    <td>Company Name</td>
                    <td><b><?php echo $user["cmpName"] ?></b></td>
                    <td>Email</td>
                    <td><b><?php echo $user["email"] ?></b></td>
                    <td>Phone</td>
                    <td><b><?php echo $user["phone"] ?></b></td>

                </tr> 

                <tr>
                    <td>Address</td>
                    <td><b><?php echo $user["streetNo"] ?></b></td>
                    <td>Postal Code</td>
                    <td><b><?php echo $user["postalCode"] ?></b></td>
                    <td>City</td>
                    <td><b><?php echo $user["city"] ?></b></td>
                </tr>
                <tr>

                    <td>Province</td>
                    <td><b><?php echo $user["province"] ?></b></td>
                    <td>Country</td>
                    <td><b><?php echo $user["country"] ?></b></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <hr/>
            <h5> System permissions </h5>
            <hr/>
            <table class="table table-bordered">
                <tr style="background-color: #A9CDEC;height: 30px;">
                    <td style="color: white">&nbsp;MASTER</td>
                    <td style="color: white">&nbsp;RETAIL</td>
                    <td style="color: white">&nbsp;PRODUCTION</td>
                    <td style="color: white">&nbsp;SYSTEM</td>
                </tr>
                <?php
                $settingArray = UserManager::getSettingArray();
                $master = $settingArray["master"];
                $retail = $settingArray["retail"];
                $production = $settingArray["production"];
                $system = $settingArray["system"];
                ?>
                <tr style="height: 27px;">
                    <td style="vertical-align: top">
                        <table>
                            <?php
                            $index = 1;
                            foreach ($master as $key => $value) {
                                if (in_array("master$$$value", $arrmaster)) {
                                    $checked1 = "checked";
                                } else {
                                    $checked1 = "";
                                }
                                ?>
                                <tr style="height: 27px;">
                                    <td>&nbsp;<input <?php echo $checked1 ?> onclick="return false;" type="checkbox"  name="master[]" disabled="" id="master<?php echo $index++ ?>"  value="<?php echo "master$$" . $value ?>"></td>
                                    <td>&nbsp;<?php echo ucwords(str_replace("_", " ", $value)) ?></td>
                                </tr>
                            <?php } ?>
                        </table>     
                    </td>

                    <td style="vertical-align: top">
                        <table>
                            <?php
                            $index1 = 1;
                            foreach ($retail as $key => $value) {
                                if (in_array("retial$$$value", $arrretial)) {
                                    $checked2 = "checked";
                                } else {
                                    $checked2 = "";
                                }
                                ?>
                                <tr style="height: 27px;">
                                    <td>&nbsp;<input <?php echo $checked2 ?> type="checkbox" disabled="" id="retail<?php echo $index1++ ?>" name="retial[]" value="<?php echo "retial$$" . $value ?>"></td>
                                    <td>&nbsp;<?php echo ucwords(str_replace("_", " ", $value)) ?></td>
                                </tr>
                            <?php } ?>
                        </table>     
                    </td>


                    <td style="vertical-align: top">
                        <table>
                            <?php
                            $index2 = 1;
                            foreach ($production as $key => $value) {
                                if (in_array("production$$$value", $arrproduction)) {
                                    $checked3 = "checked";
                                } else {
                                    $checked3 = "";
                                }
                                ?>
                                <tr style="height: 27px;">
                                    <td>&nbsp;<input <?php echo $checked3 ?> type="checkbox" disabled="" id="production<?php echo $index2++ ?>" name="production[]" value="<?php echo "production$$" . $value ?>"></td>
                                    <td>&nbsp;<?php echo ucwords(str_replace("_", " ", $value)) ?></td>
                                </tr>
                            <?php } ?>
                        </table>     
                    </td>

                    <td style="vertical-align: top">
                        <table>
                            <?php
                            $index3 = 1;
                            foreach ($system as $key => $value) {
                                if (in_array("system$$$value", $arrsystem)) {
                                    $checked4 = "checked";
                                } else {
                                    $checked4 = "";
                                }
                                ?>
                                <tr style="height: 27px;">
                                    <td>&nbsp;<input <?php echo $checked4 ?> type="checkbox" disabled="" id="system<?php echo $index3++ ?>" name="system[]" value="<?php echo "system$$" . $value ?>"></td>
                                    <td>&nbsp;<?php echo ucwords(str_replace("_", " ", $value)) ?></td>
                                </tr>
                            <?php } ?>
                        </table>     
                    </td>
                </tr>
            </table>
            <div class="mt-2">
                <a href="index.php?pagename=master_usermanagement" class="btn btn-label-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
<br/>