<?php
$customer_dropdown = Customer::getCustomerDetails("*");
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">Roundwrap - Customer master</h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-10">
                <label class="form-label" for="customer_details">Customer Details</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="tablesearch" onkeyup="searchinTable()" name="customer_details" class="form-control" placeholder="Enter Customer Name" autofocus="" value="<?php echo $customer_details ?>"/>
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
    <div class="card-body" style="margin-top: -20px">
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="table table-bordered" id="mastertable">
                <thead style="background-color: rgb(220,220,220);">
                    <tr >
                        <th>#</th>
                        <th>SHOW</th>
                        <th>HISTORY</th>
                        <th>Company&nbsp;Name</th>
                        <th>Email&nbsp;Id</th>
                        <th>Contact&nbsp;Number</th>
                        <th>Sq&nbsp;Feet</th>
                        <th>Doors</th>
                        <th>Portal</th>
                        <th>Tracking</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($customer_dropdown as $value) {
                        ?>
                        <tr >
                            <td><?php echo $index++ ?></td>
                            <td style="text-align: center">
                                <a href="index.php?pagename=searchdisplay_customermaster&customerid=<?php echo $value["id"] ?>">
                                    <i class="bx bx-show" style="color: gray"></i>
                                </a>
                            </td>
                            <td style="text-align: center">
                                <a title="Click here to see customer order history"
                                   href="index.php?pagename=historyorder_customermaster&customerid=<?php echo $value["id"] ?>">
                                    <i class="bx bx-history" style="color: gray"></i>
                                </a>
                            </td>
                            <td><?php echo GenericSetting::truncateString($value["cust_companyname"], 30, false) ?></td>
                            <td><?php echo GenericSetting::truncateString($value["cust_email"], 30, false) ?></td>
                            <td><?php echo $value["phno"] ?></td>
                            <td><?php echo $value["defaultsqfeet"] ?></td>
                            <td><?php echo $value["total_pieces"] ?></td>
                            <td>
                                <span class='badge bg-label-<?php echo $value["enable_tracking"] == "Y" ? "success" : "danger" ?>'>
                                    <?php echo $value["enable_tracking"] == "Y" ? "Yes" : "No" ?>
                                </span>
                            </td>
                            <td>
                                <span class='badge bg-label-<?php echo $value["portalUser"] == "Y" ? "success" : "danger" ?>'>
                                    <?php echo $value["portalUser"] == "Y" ? "Yes" : "No" ?>
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
