<?php
$filter_input = filter_input(INPUT_GET, "limit");
$limit = $filter_input == "" ? "0" : $filter_input;
$orderTimeLineInward = MainPageStatestic::orderTimeLineDelivery("", "LIMIT $limit,1000");
?>

<style>
    .table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card">
    <h5 class="card-header"><i class="bx bx-user"></i>&nbsp;Customer Delivered Orders, Showing <?php echo count($orderTimeLineInward) ?> orders</h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label" for="customer_details">Customer Details</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="customer_details" name="customer_details" class="form-control" placeholder="RoundWrap" autofocus="" value="<?php echo $customer_details ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-5">
                <label class="form-label" for="so_no">Sales Order Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="so_no" name="so_no" class="form-control" placeholder="123456" autofocus="" value="<?php echo $customer_details ?>"/>
                    <span class="input-group-text" id="so_no"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-password-toggle">
                    <label class="form-label" for="">&nbsp;</label>
                    <div class="input-group input-group-merge">
                        <input  type="submit" class="btn btn-primary me-sm-3 me-1" name="btnSearch" value="Search">
                        <a href="index.php" class="btn btn-label-secondary">
                            Cancel
                        </a>
                    </div>
                </div>
            </div> 
        </div>
    </form>
    <div class="card-body" style="margin-top: -20px">
        <div 
            class="card-datatable dataTable_select text-nowrap table-responsive" 
            style="max-height: 500px;overflow-y: auto;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Category</th>
                        <th>Given By</th>
                        <th>Received By</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($orderTimeLineInward as $value) {
                        ?>
                        <tr>
                            <td><?php echo ++$limit ?></td>
                            <td><?php echo $value["cust_companyname"] ?></td>
                            <td>
                                <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["so_no"] ?>
                                </a>
                            </td>
                            <td><?php echo $value["deliveryPerson"] ?></td>
                            <td><?php echo $value["deliveryContact"] ?></td>
                            <td><?php echo $value["deliveredOn"] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer" style="margin-top: -30px">
        <div style="float: left">
            <a class="btn btn-label-dark <?php echo $limit == 1000 ? "active" : "" ?>" 
               href="index.php?pagename=outwardorder_dashboard&limit=0">Show 000 - 1000</a>&nbsp;

            <a class="btn btn-label-dark <?php echo $limit == 2000 ? "active" : "" ?>" 
               href="index.php?pagename=outwardorder_dashboard&limit=1000">Show 1001 - 2000</a>&nbsp;

            <a class="btn btn-label-dark <?php echo $limit == 3000 ? "active" : "" ?>" 
               href="index.php?pagename=outwardorder_dashboard&limit=2000">Show 2001 - 3000</a>&nbsp;

            <a class="btn btn-label-dark <?php echo $limit == 4000 ? "active" : "" ?>" 
               href="index.php?pagename=outwardorder_dashboard&limit=3000">Show 3001 - 4000</a>&nbsp;
        </div>
        <div style="float: right">
            <a href="#">
                <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-export"></span>&nbsp;Export</button>
            </a>
            &nbsp;
            <a href="#">
                <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-printer"></span>&nbsp;Print</button>
            </a>
            &nbsp;
            <a href="index.php">
                <button type="button" class="btn btn-label-dark"><span class="tf-icons bx bx-left-arrow"></span>&nbsp;Back</button>
            </a>
        </div>
    </div>
</div>
