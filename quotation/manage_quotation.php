<?php
$category = filter_input(INPUT_GET, "category");
$quotationList = Quotation::listQuotation($category);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Quotations for <?php echo $category ?> orders</h5>
    <div class="card-body" style="margin-top: 0px">
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd">
            <table class="dt-select-table table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Customer Name</th>
                        <th>Category</th>
                        <th>So&nbsp;Number</th>
                        <th>Color</th>
                        <th>Po&nbsp;Number</th>
                        <th>Days&nbsp;Left</th>
                        <th>Urgent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($quotationList as $value) {
                        ?>
                        <tr>
                            <td><?php echo $index++ ?></td>
                            <td class="break-me"><?php echo $value["cust_companyname"] ?></td>
                            <td><?php echo $value["sub_prof_id"] ?></td>
                            <td>
                                <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["so_no"] ?>
                                </a>
                            </td>
                            <td ><?php echo $value["color_name"] ?></td>
                            <td  class="break-me"><?php echo $value["po_no"] ?></td>
                            <td>
                                <small>
                                    <?php echo PackingSlip::deliveryLeft($value["daysLeft"]) ?>
                                </small>
                            </td>
                            <td>
                                <small>
                                    <?php echo GenericSetting::toggleMe($value["isUrgent"]) ?>
                                </small>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-body demo-inline-spacing" style="margin-top: -40px;">
        <a href="#" class="btn btn-label-secondary" ><i class="bx bx-printer me-2"></i> PRINT REPORT</a>
        &nbsp;
        <a href="#" class="btn btn-label-secondary" ><i class="bx bx-mail-send me-2"></i> EMAIL REPORT</a>
        &nbsp;
        <a href="#" class="btn btn-label-secondary" ><i class="bx bx-download me-2"></i> DOWNLOAD REPORT</a>
    </div>
</div>
