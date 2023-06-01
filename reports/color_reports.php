<?php
$category_get = filter_input(INPUT_GET, "category");
$colorname = filter_input(INPUT_GET, "colorname");

$category = $category_get == "" ? "PVC" : $category_get;

$color_brand_list = Colors::getColorSearchColum($category, "colorbrand");
$color_name_list = Colors::getColorSearchColum($category, "colorname");

$filter_input_array = filter_input_array(INPUT_POST);

if ($filter_input_array["btnSearch"] == "Search") {
    $brandname = $filter_input_array["color_brand"];
    $colorname = $filter_input_array["color_name"];
    $_SESSION["colorsearch"] = $filter_input_array;
    $colorreportdata = Colors::getOrdersByColorName($category, $colorname, $brandname);
} else {
    $colorreportdata = Colors::getOrdersByColorName($category, $colorname, "");
}

$orderCountByColor = Colors::getOrdersByColors($category);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">Roundwrap - Showing you report for <b style="color: red"><?php echo $category . ", " . $brandname . ", " . $colorname ?></b></h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label" for="color_brand">Color Brand</label>
                <div class="input-group input-group-merge">
                    <select id="color_name" name="color_brand" class="form-control" >
                        <option value="">Please select brand to search</option>
                        <?php
                        foreach ($color_brand_list as $value) {
                            ?>
                            <option value="<?php echo $value ?>"
                                    <?php echo $brandname == $value ? "selected" : "" ?>>
                                        <?php echo $value ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="color_name">Color Name</label>
                <div class="input-group input-group-merge">
                    <select id="color_name" name="color_name" class="form-control" >
                        <option value="">Please select name to search</option>
                        <?php
                        foreach ($color_name_list as $value) {
                            ?>
                            <option value="<?php echo $value ?>"
                                    <?php echo $colorname == $value ? "selected" : "" ?>>
                                <?php echo $value ?> (Total <?php echo $orderCountByColor[$value] ?> Doors)
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for=".">.</label>
                <div class="form-password-toggle" >
                    <div class="input-group" style="float: right">
                        <input  type="submit" class="btn btn-secondary" name="btnSearch" value="Search">
                        &nbsp;&nbsp;&nbsp;
                        <a  href="index.php?pagename=color_reports&category=PVC" class="btn btn-label-secondary <?php echo $category == "PVC" ? "active" : "" ?>">
                            PVC
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=color_reports&category=LAMINATE" class="btn btn-label-secondary <?php echo $category == "LAMINATE" ? "active" : "" ?>">
                            LAMINATE
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="exportdata/export_colorreport.php?category=<?php echo $category ?>&colorname=<?php echo $colorname ?>" target="_blank">
                            <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-import"></span>&nbsp;Export</button>
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="printpages/printpages_colorreport.php?category=<?php echo $category ?>&colorname=<?php echo $colorname ?>&brandname=<?php echo $brandname?>" target="_blank">
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
                    foreach ($colorreportdata as $value) {
                        ?>
                        <tr >
                            <td><?php echo $index++ ?></td>
                            <td><?php echo $value["customername"] ?></td>
                            <td><?php echo $value["so_no"] ?></td>
                            <td><?php echo $value["po_no"] ?></td>
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
