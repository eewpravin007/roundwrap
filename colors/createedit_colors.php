<?php 
$category = filter_input(INPUT_GET, "category");
$primary = filter_input(INPUT_GET, "primary");

$filter_input_array = filter_input_array(INPUT_POST);
if($filter_input_array["btnSubmit"] == "Save changes"){
    unset($filter_input_array["btnSubmit"]);
    $result = Colors::saveEditColor($primary, $filter_input_array);
    header("location:index.php?pagename=master_colors&category=$category");
}else{
    $result = Colors::getColorByPrimary($primary);
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
        <h5 class="card-header">Create or Edit Color Information</h5>
        <div class="card-body demo-inline-spacing" >
            <table class="table table-bordered">
                <tr>
                    <td ><b>Category</b></td>
                    <td>
                        <select required="" name="category" id="category" class="form-control" >
                            <option value="PVC" <?php echo $category == "PVC" ? "selected" : ""?> >PVC</option>
                            <option value="LAMINATE" <?php echo $category == "LAMINATE" ? "selected" : ""?>>LAMINATE</option>
                        </select>
                    </td>
                    <td ><b>Color Brand</b></td>
                    <td><input required="" type="text" name="colorbrand" value="<?php echo $result["colorbrand"] == "" ? "-" : $result["colorbrand"] ?>" class="form-control"   /></td>
                    <td ><b>Edge Tape Name</b></td>
                    <td><input required=""  type="text" name="edgetape_name" id="edgetape_name"  value="<?php echo $result["edgetape_name"] == "" ? "-" : $result["edgetape_name"] ?>" class="form-control"  /></td>
                </tr>
                <tr>
                    <td ><b>Color Code</b></td>
                    <td><input required=""  type="text" name="colorcode" id="colorcode" value="<?php echo $result["colorcode"] == "" ? "-" : $result["colorcode"] ?>" class="form-control"  /></td>
                    <td ><b>Color Name</b></td>
                    <td><input required=""   type="text" name="colorname" id="colorname" value="<?php echo $result["colorname"] ?>" class="form-control"   /></td>
                    <td ><b>Color Price</b></td>
                    <td><input required=""  type="text" name="colorprice" onkeypress="return chkNumericKey(event)" value="<?php echo $result["colorprice"] ?>" class="form-control"  /></td>
                </tr>
            </table>
            <div class="mt-2">
                <input type="submit" name="btnSubmit" class="btn btn-primary me-2" value="Save changes">
                <a href="index.php?pagename=master_profiles&category=<?php echo $category ?>" class="btn btn-label-secondary">Back</a>
            </div>
        </div>
    </form>
</div>