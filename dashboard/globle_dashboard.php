<?php
$sales_order_no = filter_input(INPUT_GET, "sales_order_no");

$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnSearch"] == "Search") {
    $so_number = $filter_input_array["so_no"];
    $po_number = $filter_input_array["po_no"];
    $customer = $filter_input_array["customer_name"];

    $where = "";
    if ($so_number != "") {
        $where .= " AND ps.so_no LIKE '%$so_number%'";
    }
    if ($po_number != "") {
        $where .= " AND ps.po_no LIKE '%$po_number%'";
    }
    if ($customer != "") {
        $where .= " AND cm.cust_companyname LIKE '%$customer%'";
    }
    $masterdata = Customer::globleSearch($where);
}
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
    .tracking{
        height: 45px;
        width: 45px;
        border: solid 1px gray;
        border-radius: 45px;
        margin: 10px;
        text-align: center;
        margin: 0 auto;
    }
    .rotate {
        border-bottom: 1px solid gray;
        transform: rotate(315deg);
        white-space: nowrap;
    }
</style>
<div class="card mb-4">
    <h5 class="card-header">Search history orders for customer</h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label" for="so_no">Sales Order Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="so_no" name="so_no" 
                           class="form-control" placeholder="123456" autofocus="" 
                           value="<?php echo $so_number ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="po_no"># Purchase Order Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="po_no" name="po_no" class="form-control" placeholder="PO 0023"  
                           value="<?php echo $po_number ?>" />
                    <span class="input-group-text" id="po_no2"><i class="bx bx-album"></i></span>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="so_no">Customer Name</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="so_no" name="customer_name" 
                           class="form-control" placeholder="Sandhu Enterprises Ltd." autofocus="" 
                           value="<?php echo $masterdata[0]["cust_companyname"] ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-password-toggle">
                    <label class="form-label" for="">&nbsp;</label>
                    <div class="input-group input-group-merge">
                        <input  type="submit" class="btn btn-primary me-sm-3 me-1" name="btnSearch" value="Search">
                        <a href="index.php?pagename=main_dashboard" class="btn btn-label-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div> 
        </div>
    </form>

    <div class="card-body" >
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="table table-bordered">
                <thead style="background-color: rgb(220,220,220);">
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>So No</th>
                        <th>Po No</th>
                        <th>Profile</th>
                        <th>Style</th>
                        <th>Color</th>
                        <th>Qty</th>
                        <th>Delay</th>
                        <th>Time-Line</th>
                        <th>Remake</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($masterdata as $value) {
                        ?>
                        <tr>
                            <td><?php echo $index++ ?></td>
                            <td><?php echo $value["cust_companyname"] ?></td>
                            <td>
                                <a href="index.php?pagename=history_customermaster&sales_order_no=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["so_no"] ?>
                                </a>
                            </td>
                            <td>
                                <a href="index.php?pagename=history_customermaster&sales_order_no=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["po_no"] ?>
                                </a>
                            </td>
                            <td><?php echo $value["prof_id"] ?></td>
                            <td><?php echo $value["sub_prof_id"] ?></td>
                            <td><?php echo $value["color_name"] ?></td>
                            <td><?php echo $value["total_pieces"] ?></td>
                            <td>
                                <?php
                                if ($value["production_update"] == "ORDER DELIVERED" || $value["production_update"] == "ORDER DELIVERED-OUT") {
                                    echo PackingSlip::productionInStatus($value["production_update"]);
                                } else {
                                    echo PackingSlip::deliveryLeft($value["daysLeft"]);
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($value["production_update"] == "ORDER DELIVERED" || $value["production_update"] == "ORDER DELIVERED-OUT") {
                                    //echo PackingSlip::productionInStatus($value["production_update"]);
                                } else {
                                    echo PackingSlip::productionInStatus($value["production_update"]);
                                }
                                ?>
                            </td>
                            <td><?php echo $value["rec_date"] ?></td>
                            <td><?php echo $value["location"] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
