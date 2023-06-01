<?php
$master_result = IncomingOrder::getIncomingOrderDetails();
?>
<style>
    .dt-fixedcolumns th{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header"><i class="bx bx-globe"></i> Great!!! You can manage your Incoming Orders..;</h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label" for="so_no">Sales Order Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="so_no" name="so_no" class="form-control" placeholder="123456" autofocus="" value="<?php echo $so_no ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="po_no">Purchase Order Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="po_no" name="po_no" class="form-control" placeholder="PO 0023"  value="<?php echo $po_no ?>" />
                    <span class="input-group-text" id="po_no2"><i class="bx bx-album"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-password-toggle">
                    <label class="form-label" for="cust_id">Customer Name</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="cust_id" name="cust_id" class="form-control" placeholder="Siskin Doors"  value="<?php echo $cust_id ?>"/>
                        <span class="input-group-text cursor-pointer" id="cust_id2"><i class="bx bx-user"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-password-toggle">
                    <label class="form-label" for="">&nbsp;</label>
                    <div class="input-group input-group-merge">
                        <input  type="submit" class="btn btn-primary me-sm-3 me-1" name="btnSearch" value="Search">
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </div>
            </div> 
        </div>
    </form>

</div><!-- Content -->
<div class="card">
    <h5 class="card-header">Search Result</h5>
    <div class="card-datatable text-nowrap">
        <table class="dt-fixedcolumns table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Entered By</th>
                    <th>Company Name</th>
                    <th>Profile </th>
                    <th>PO No</th>
                    <th>Ordered</th>
                    <th>Required</th>
                    <th>Rush Order</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($master_result as $value) {
                    ?>
                    <tr>
                        <td style="text-align: center"><?php echo $index ?></td>
                        <td></td>
                        <td>
                            <?php
                            if (trim($customername["cust_companyname"] == "")) {
                                echo $value["cust_id"] . " (Web site order)";
                            } else {
                                echo $customername["cust_companyname"];
                            }
                            ?>
                        </td>
                        <td><?php echo $value["prof_id"] . " - " . $value["sub_prof_id"] ?></td>
                        <td><?php echo $value["po_no"] ?></td>
                        <td><?php echo $value["rec_date"] ?></td>
                        <td><?php echo $value["req_date"] ?></td>
                        <td ><?php echo $value["isUrgent"] == "" ? "" : "<img src='assets/images/done.png' style=width:22px;height:22px>" ?></td>
                    </tr>
                    <?php
                    $index++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
