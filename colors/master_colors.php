<?php
$category_get = filter_input(INPUT_GET, "category");
$category = $category_get == "" ? "PVC" : $category_get;
$masterdata = Colors::getColorList($category);
$orderresult = Colors::getOrdersByColors($category_get);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">Roundwrap - Colors List</h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label" for="color_name">Color Brand</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="tablesearch" onkeyup="searchinTable()" name="color_name" class="form-control" placeholder="Enter Color Name" autofocus="" value="<?php echo $color_name ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="color_name">Color Name</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="filter2" onkeyup="searchinTableFilter2()" name="color_name" class="form-control" placeholder="Enter Color Name" autofocus="" value="<?php echo $color_name ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-password-toggle">
                    <label class="form-label" for="">&nbsp;</label>
                    <div class="input-group">
                        <input  type="submit" class="btn btn-secondary" name="btnSearch" value="Search">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=master_colors&category=PVC" class="btn btn-label-secondary <?php echo $category == "PVC" ? "active" : "" ?>">
                            PVC
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=master_colors&category=LAMINATE" class="btn btn-label-secondary <?php echo $category == "LAMINATE" ? "active" : "" ?>">
                            Laminate
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=createedit_colors&category=PVC" class="btn btn-label-secondary">
                            <i class="bx bx-plus-circle" style="color: gray"></i>&nbsp;PVC Color
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=createedit_colors&category=LAMINATE" class="btn btn-label-secondary">
                            <i class="bx bx-plus-circle" style="color: gray"></i>&nbsp;Laminate Color
                        </a>
                    </div>
                </div>
            </div> 
        </div>
    </form>
    <div class="card-body" style="margin-top: -20px">
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="table table-bordered" id="mastertable">
                <thead style="background-color: rgb(220,220,220);">
                    <tr >
                        <th>#</th>
                        <th>#</th>
                        <th>#</th>
                        <th>#</th>
                        <th>Color Code</th>
                        <th>Color Brand</th>
                        <th>Color Name</th>
                        <th>Color Price</th>
                        <th>Matching Edge Tape</th>
                        <th>Matching Finish</th>
                        <th>Total Doors</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($masterdata as $value) {
                        $id = $value["id"];
                        ?>
                        <tr >
                            <td><?php echo $index++ ?></td>
                            <td style="text-align: center">
                                <a href="index.php?pagename=view_colors&category=<?php echo $value["category"]?>&primary=<?php echo $id?>"><i class="bx bx-show" style="color: gray"></i></a>
                            </td>
                            <td style="text-align: center">
                                <a href="index.php?pagename=createedit_colors&category=<?php echo $value["category"]?>&primary=<?php echo $id?>"><i class="bx bx-pencil" style="color: gray"></i></a>
                            </td>
                            <td style="text-align: center">
                                <a href="index.php?pagename=delete_colors&category=<?php echo $value["category"]?>&primary=<?php echo $id?>"><i class="bx bx-trash-alt" style="color: gray"></i></a>
                            </td>
                            <td><?php echo $value["colorcode"] ?></td>
                            <td><?php echo $value["colorbrand"] ?></td>
                            <td><?php echo $value["colorname"] ?></td>
                            <td><?php echo $value["colorprice"] ?></td>
                            <td><?php echo $value["edgetape_name"] ?></td>
                            <td><?php echo $value["finish"] ?></td>
                            <td>
                                <a href="index.php?pagename=color_reports&category=<?php echo $category ?>&colorname=<?php echo $value["colorname"] ?>">
                                    Total (<?php echo $orderresult[$value["colorname"]] ?>) Orders
                                </a>
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
