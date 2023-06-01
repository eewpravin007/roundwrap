<?php
$primary = filter_input(INPUT_GET, "profileid");
$npcount = filter_input(INPUT_GET, "count");
$phase = filter_input(INPUT_GET, "phase");

$profilecounter = Profiles::getAllPrimaryIds(filter_input(INPUT_GET, "category"));
if ($npcount > 0 ) {
    $primary = $profilecounter[$npcount]["id"];
}
if ($phase == "Nx") {
    $npcount = $npcount + 1;
} else if ($phase == "Pr") {
    $npcount = $npcount - 1;
}

$category = filter_input(INPUT_GET, "category");
$filter_input_array = Profiles::getProfileFromPrimary($primary);
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
        <h5 class="card-header">Show Profile and Door Style</h5>
        <div class="card-body demo-inline-spacing" >
            <table class="table table-bordered">
                <tr>
                    <td style="width: 20%">Category</td>
                    <td><b><?php echo $category ?></b></td>
                    <td rowspan="8" style="width: 50%">
                        <img src="profiles/uploaded/<?php echo $filter_input_array["profilecode"] ?>" style="width: 400px;height: 500px">
                        &nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=view_profiles&profileid=<?php echo $primary?>&category=<?php echo $category?>&phase=Nx&count=<?php echo $npcount?>" class="btn btn-label-secondary">Next -></a>
                        <a href="index.php?pagename=view_profiles&profileid=<?php echo $primary?>&category=<?php echo $category?>&phase=Pr&count=<?php echo $npcount?>" class="btn btn-label-secondary"><- Privous</a>
                        <a href="index.php?pagename=master_profiles&category=<?php echo $category ?>" class="btn btn-label-secondary">Back</a>
                    </td>
                </tr>
                <tr>
                    <td>Category Price</td>
                    <td><b><?php echo $filter_input_array["profiledetailprice"] ?></td>
                </tr>
                <tr>
                    <td>Sub Profile</td>
                    <td><b><?php echo $filter_input_array["profilename"] ?></td>
                </tr>
                <tr>
                    <td>Profile Style</td>
                    <td><b><?php echo $filter_input_array["profile"] ?></td>
                </tr>
                <tr>
                    <td>Left Rail</td>
                    <td><b><?php echo $filter_input_array["leftrail"] ?></td>
                </tr>
                <tr>
                    <td>Top Rail</td>
                    <td><b><?php echo $filter_input_array["toprail"] ?></td>
                </tr>
                <tr>
                    <td>Right Rail</td>
                    <td><b><?php echo $filter_input_array["rightrail"] ?></td>
                </tr>
                <tr>
                    <td>Bottom Rail</td>
                    <td><b><?php echo $filter_input_array["bottomrail"] ?></td>
                </tr>
            </table>
            <div class="mt-2">
                <a href="index.php?pagename=master_profiles&category=<?php echo $category ?>" class="btn btn-label-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
<br/>