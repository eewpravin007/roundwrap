<?php
$invoiceId = filter_input(INPUT_GET, "invoiceno");
$invoice_details = Invoicing::getInvoice($invoiceId);
$json_array = json_decode($invoice_details["josnText"]);
?>
<div class="row invoice-preview">
    <!-- Invoice -->
    <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
        <div class="card invoice-preview-card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0" >
                    <div class="mb-xl-0 mb-4">
                        <div class="d-flex svg-illustration mb-3 gap-2">
                            <span class="app-brand-text h3 mb-0 fw-bold">RoundWrap</span>
                        </div>
                        <p class="mb-1">1680 Savage Rd, Richmond</p>
                        <p class="mb-1">BC V6V 3A9, Canada</p>
                        <p class="mb-1">Ph: 604-278-1002 Fax: 604-278-1463</p>
                        <p class="mb-0">www.roundwrap.com</p>
                    </div>
                    <div>
                        <h4>Invoice #<?php echo $invoiceId ?></h4>
                        <table class="">
                            <tbody>
                                <tr>
                                    <td class="pe-3">Date Issues</td>
                                    <td class="pe-3">&nbsp;:&nbsp;</td>
                                    <td><b><?php echo $invoice_details["invoicedate"] ?></b></td>
                                </tr>
                                <tr>
                                    <td class="pe-3">Due Issues</td>
                                    <td class="pe-3">&nbsp;:&nbsp;</td>
                                    <td><b><?php echo $invoice_details["invoicedate"] ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-body">
                <div class="row p-sm-3 p-0">
                    <div class="col-xl-8 ">
                        <h6 class="pb-2">Invoice To:</h6>
                        <p class="mb-1"><b><?php echo $invoice_details["customername"] ?></b></p>
                        <p class="mb-1"><?php echo $invoice_details["billto"] ?></p>
                    </div>

                    <div class="col-xl-4 col-md-12 col-sm-7 col-12">
                        <h6 class="pb-2"></h6>
                        <table class="">
                            <tbody>
                                <tr>
                                    <td class="pe-3">Total Due</td>
                                    <td class="pe-3">&nbsp;:&nbsp;</td>
                                    <td><b><?php echo $invoice_details["nettotal"] ?></b></td>
                                </tr>
                                <tr>
                                    <td class="pe-3">Payment Term</td>
                                    <td class="pe-3">&nbsp;:&nbsp;</td>
                                    <td><b><?php echo $invoice_details["payment_term"] ?></b></td>
                                </tr>
                                <tr>
                                    <td class="pe-3">Tax</td>
                                    <td class="pe-3">&nbsp;:&nbsp;</td>
                                    <td><b><?php echo $invoice_details["ordertax"] ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table border-top m-0">
                        <thead style="background-color: rgb(240,240,240)">
                            <tr>
                                <th>#</th>
                                <th>Door</th>
                                <th style="text-align: right">Quantity</th>
                                <th style="text-align: right">Sq Feet</th>
                                <th style="text-align: right">Price</th>
                                <th style="text-align: right">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 1;
                            foreach ($json_array as $value) {
                                ?>
                                <tr>
                                    <td><?php echo $index++ ?></td>
                                    <td class="text-nowrap"><?php echo $value->type ?></td>
                                    <td style="text-align: right"><?php GenericSetting::numberFormat($value->qty) ?></td>
                                    <td style="text-align: right"><?php GenericSetting::numberFormat($value->sqfeet) ?></td>
                                    <td style="text-align: right"><?php GenericSetting::numberFormat($value->priceeachprofile) ?></td>
                                    <td style="text-align: right"><?php GenericSetting::numberFormat($value->subtotal) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="4" class="align-top px-4 py-5" style="text-align: left">
                                    <p class="mb-2">
                                        <span class="me-1 fw-semibold">Salesperson:</span>
                                        <span><?php echo $invoice_details["salesman"] ?></span>
                                    </p>
                                    <span>Thanks for your business</span>
                                </td>
                                <td class="text-end px-4 py-5">
                                    <p class="mb-2">Subtotal:</p>
                                    <p class="mb-2"><?php echo $invoice_details["ordertax"] ?>:</p>
                                    <p class="mb-2">Shipping:</p>
                                    <p class="mb-0">Total:</p>
                                </td>
                                <td class="px-4 py-5" style="text-align: right">
                                    <p class="fw-semibold mb-2">$<?php echo $invoice_details["subtotal"] ?></p>
                                    <p class="fw-semibold mb-2">$<?php echo $invoice_details["taxamount"] ?></p>
                                    <p class="fw-semibold mb-2">$<?php echo $invoice_details["shipppingtaxamount"] ?></p>
                                    <p class="fw-semibold mb-0">$<?php echo $invoice_details["nettotal"] ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <span class="fw-semibold">Note:</span>
                        <span>
                            It was a pleasure working with you and your team. We hope you will keep us in mind for
                            future freelance projects. Thank You!
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-4 col-12 invoice-actions">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-primary d-grid w-100 mb-3" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="bx bx-paper-plane bx-xs me-3"></i>Send Invoice</span>
                </button>
                <button class="btn btn-label-secondary d-grid w-100 mb-3">Download</button>
                <a class="btn btn-label-secondary d-grid w-100 mb-3" target="_blank" href="#">Print</a>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title">Send Invoice</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form>
            <div class="mb-3">
                <label for="invoice-from" class="form-label">From</label>
                <input type="text" class="form-control" id="invoice-from" value="shelbyComapny@email.com" placeholder="company@email.com" />
            </div>
            <div class="mb-3">
                <label for="invoice-to" class="form-label">To</label>
                <input type="text" class="form-control" id="invoice-to" value="qConsolidated@email.com" placeholder="company@email.com" />
            </div>
            <div class="mb-3">
                <label for="invoice-subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="invoice-subject" value="Invoice of purchased Admin Templates" placeholder="Invoice regarding goods" />
            </div>
            <div class="mb-3">
                <label for="invoice-message" class="form-label">Message</label>
                <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="8">
            Dear Queen Consolidated,
            Thank you for your business, always a pleasure to work with you!
          We have generated a new invoice in the amount of $95.59
          We would appreciate payment of this invoice by 05/11/2021</textarea
                >
            </div>
            <div class="mb-4">
                <span class="badge bg-label-primary">
                    <i class="bx bx-link bx-xs"></i>
                    <span class="align-middle">Invoice Attached</span>
                </span>
            </div>
            <div class="mb-3 d-flex flex-wrap">
                <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>