<?php
$category = filter_input(INPUT_GET, "category");
$primary = filter_input(INPUT_GET, "primary");
$result = Colors::getColorByPrimary($primary);
?>

<div class="card">
    <form name="frmPs" method="post" enctype="multipart/form-data">
        <h5 class="card-header">Create or Edit Color Information</h5>
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
                <a href="index.php?pagename=master_profiles&category=<?php echo $category ?>" class="btn btn-label-secondary">Back</a>
            </div>
        </div>
    </form>
</div>