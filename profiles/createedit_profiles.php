<?php
$category = filter_input(INPUT_GET, "category");
$primary = filter_input(INPUT_GET, "profileid");

$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnSubmit"] == "Save changes") {
    $files = $_FILES["profileImage"];
    if ($files["name"] != "") {
        $extension = explode(".", $files["name"]);
        $file_name = $filter_input_array["profilename"] . "." . $extension[1];
        move_uploaded_file($_FILES["profileImage"]["tmp_name"], "profiles/uploaded/" . $file_name);
    }
    $filter_input_array["profilecode"] = $file_name;
    $filter_input_array["category"] = $category;
    $filter_input_array["overheadpercent"] = "0";
    $filter_input_array["profilepercent"] = "0";
    $filter_input_array["customerdiscount"] = "0";
    $filter_input_array["decription"] = $filter_input_array["profilename"] . "-" . $filter_input_array["profile"];
    unset($filter_input_array["btnSubmit"]);
    Profiles::createOrEditProfile($filter_input_array, $primary);
    header("location:index.php?pagename=master_profiles&category=" . $category);
} else {
    if ($primary != "") {
        $filter_input_array = Profiles::getProfileFromPrimary($primary);
        $category = $filter_input_array["category"];
    }
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
        <h5 class="card-header">Create PVC Packing Slip</h5>
        <div class="card-body demo-inline-spacing" >
            <table class="table table-bordered">
                <tr>
                    <td><b>Category</b></td>
                    <td>
                        <input type="text" readonly="" name="doortypecate" value="<?php echo $category ?>" class="form-control" >
                        <input type="hidden" readonly="" name="category" value="<?php echo $category ?>" class="form-control" >
                    </td>
                    <td><b>Category Price</b></td>
                    <td><input type="text" autofocus="" value="<?php echo $filter_input_array["profiledetailprice"] ?>" class="form-control" name="profiledetailprice" id="profiledetailprice" onkeypress="return chkNumericKey(event)" placeholder="Enter price 0.00"></td>
                    <td><b>Sub Profile</b></td>
                    <td><input type="text" class="form-control" name="profilename" value="<?php echo $filter_input_array["profilename"] ?>"   ></td>
                </tr>
                <tr>
                    <td><b>Profile Style</b></td>
                    <td><input type="text" class="form-control" value="<?php echo $filter_input_array["profile"] ?>" name="profile" placeholder="Enter DF, Door, GF, Window"  ></td>
                    <td><b>Left Rail</b></td>
                    <td><input type="text" class="form-control" value="<?php echo $filter_input_array["leftrail"] ?>" name="leftrail" onkeypress="return chkNumericKey(event)"></td>
                    <td><b>Top Rail</b></td>
                    <td><input type="text" class="form-control" value="<?php echo $filter_input_array["toprail"] ?>" name="toprail" onkeypress="return chkNumericKey(event)"></td>
                </tr>
                <tr>
                    <td><b>Profile Image</b></td>
                    <td><input type="file" name="profileImage"></td>
                    <td><b>Right Rail</b></td>
                    <td><input type="text" class="form-control" value="<?php echo $filter_input_array["rightrail"] ?>" name="rightrail" onkeypress="return chkNumericKey(event)"></td>
                    <td><b>Bottom Rail</b></td>
                    <td><input type="text" class="form-control" value="<?php echo $filter_input_array["bottomrail"] ?>" name="bottomrail" onkeypress="return chkNumericKey(event)"></td>
                </tr>
            </table>
            <div class="mt-2">
                <input type="submit" name="btnSubmit" class="btn btn-primary me-2" value="Save changes">
                <a href="index.php?pagename=master_profiles&category=<?php echo $category ?>" class="btn btn-label-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
<br/>