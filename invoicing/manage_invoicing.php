<?php
$category = filter_input(INPUT_GET, "category");

$filter_input_array = filter_input_array(INPUT_POST);
$invoice_details = $filter_input_array["invoice_details"];
$customer_name = $filter_input_array["customer_name"];
$so_number = $filter_input_array["so_number"];
$invoiceList = Invoicing::listInvoice($category, $filter_input_array);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">Excellent!!!.. Check yours invoice details and orders</h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label" for="invoice_details">Invoice Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="invoice_details" name="invoice_details" 
                           class="form-control" placeholder="Invoice Number" autofocus="" value="<?php echo $invoice_details ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="customer_name">Customer Name</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="tablesearch" onkeyup="searchinTable()" name="customer_name" 
                           class="form-control" placeholder="Customer Name" autofocus="" value="<?php echo $customer_name ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-user"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="so_number">Sales Order Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="filter2" onkeyup="searchinTableFilter2()" name="so_number" 
                           class="form-control" placeholder="Sales Order Number" autofocus="" value="<?php echo $so_number ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-cart"></i></span>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-password-toggle">
                    <label class="form-label" for="">&nbsp;</label>
                    <div class="input-group input-group-merge">
                        <input  type="submit" class="btn btn-primary me-sm-3 me-1" 
                                name="btnSearch" value="Search">
                        <a href="index.php?pagename=manage_invoicing&category=<?php echo $category ?>" class="btn btn-label-secondary">
                            Refresh
                        </a>
                    </div>
                </div>
            </div> 
        </div>
        <hr>
    </form>
    <div class="card-body" style="margin-top: -40px">
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd">
            <table class="table table-bordered" id="mastertable">
                <thead style="background-color: rgb(220,220,220);">
                    <tr >
                        <th>#</th>
                        <th>Invoice&nbsp;NO</th>
                        <th>Date</th>
                        <th>Company&nbsp;Name</th>
                        <th>SO&nbsp;NO</th>
                        <th>Category</th>
                        <th>Color</th>
                        <th>Quantity</th>
                        <th>SqFeet</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($invoiceList as $value) {
                        ?>
                        <tr >
                            <td><?php echo $index++ ?></td>
                            <td>
                                <a href="index.php?pagename=view_invoicing&invoiceno=<?php echo $value["invoiceno"] ?>">
                                    <?php echo $value["invoiceno"] ?>
                                </a>
                            </td> 
                            <td><?php echo $value["invoicedate"] ?></td> 
                            <td><?php echo $value["customername"] ?></td> 
                            <td>
                                <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["so_no"] ?>
                                </a>
                            </td> 
                            <td><?php echo $value["profile"] . " " . $value["category"] ?></td> 
                            <td><?php echo $value["ordercolor"] ?></td> 
                            <td><?php echo GenericSetting::numberFormat($value["quantity"]) ?></td> 
                            <td><?php echo GenericSetting::numberFormat($value["sqfeettotal"]) ?></td> 
                            <td><?php echo GenericSetting::numberFormat($value["nettotal"]) ?></td> 
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-body demo-inline-spacing" style="margin-top: -40px;">
        <a target="_blank"
           href="exportdata/export_invoice.php?category=<?php echo $category ?>" 
           class="btn btn-label-secondary" ><i class="bx bx-import"></i>EXPORT</a>
    </div>
</div>
