<?php
$category = filter_input(INPUT_GET, "category");
$primary = filter_input(INPUT_GET, "primary");
$result = Colors::getColorByPrimary($primary);
if ($filter_input_array["btnSubmit"] == "Delete Color") {
    
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
        <h5 class="card-header">Are you sure you want to delete this record?</h5>
        <div class="card-body demo-inline-spacing" >
            <table class="table table-bordered">
                <tr>
                    <td >Category</td>
                    <td ><b><?php echo $result["category"] ?></b></td>
                    <td >Color Brand</td>
                    <td ><b><?php echo $result["colorbrand"] ?></b></td>
                    <td >Edge Tape Name</td>
                    <td ><b><?php echo $result["edgetape_name"] ?></b></td>
                </tr>
                <tr>
                    <td >Color Code</td>
                    <td ><b><?php echo $result["colorcode"] ?></b></td>
                    <td >Color Name</td>
                    <td ><b><?php echo $result["colorname"] ?></b></td>
                    <td >Color Price</td>
                    <td ><b><?php echo $result["colorprice"] ?></b></td>
                </tr>
            </table>
            <div class="mt-2">
                <input type="submit" name="btnSubmit" class="btn btn-danger me-2" value="Delete Color">
                <a href="index.php?pagename=master_colors&category=<?php echo $category ?>" class="btn btn-label-secondary">Back</a>
            </div>
        </div>
    </form>
</div>