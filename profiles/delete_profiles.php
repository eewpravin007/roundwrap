<?php
$primary = filter_input(INPUT_GET, "profileid");
$filter_input_array = Profiles::getProfileFromPrimary($primary);
$btnSubmit = filter_input(INPUT_POST, "btnSubmit");
if($btnSubmit == "Delete Profile"){
    MysqlConnection::delete("DELETE FROM tbl_portfolio_profile_price WHERE id = '$primary' ");
    header("location:index.php?pagename=master_profiles");
}
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
                    <td><b><?php echo $filter_input_array["category"] ?></b></td>
                    <td rowspan="8" style="width: 50%"><img src="profiles/uploaded/<?php echo $filter_input_array["profilecode"] ?>" style="width: 400px;height: 500px"></td>
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
                <input type="submit" name="btnSubmit" class="btn btn-danger me-2" value="Delete Profile">
                <a href="index.php?pagename=master_profiles&category=<?php echo $category ?>" class="btn btn-label-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
<br/>