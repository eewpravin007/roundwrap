<?php
$category = filter_input(INPUT_GET, "category");
$where = " AND prof_id = '$category' AND isLayout != 'Y'  AND workOrd_Id = '-' ";
$packingslip = PackingSlip::getLast5Orders("", $where);
$count_recors = count($packingslip);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Showing you <?php echo $count_recors ?> active packing Slip for <?php echo $category ?> orders</h5>
    <div class="card-body demo-inline-spacing" style="margin-top: -20px;">
        <table style="width: 100%">
            <tr>
                <td>
                    <input type="text" id="tablesearch" onkeyup="searchinTable()" class="form-control" placeholder="Enter Search String" autofocus="" value="<?php echo $color_name ?>"/>
                </td>
                <td>
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <a class="btn btn-label-secondary" ><i class="bx bx-plus-circle"></i>&nbsp;&nbsp;CREATE</a>
                    &nbsp;
                    <a class="btn btn-label-secondary" ><i class="bx bx-printer"></i>&nbsp;&nbsp;PRINT</a>
                    &nbsp;
                    <a target="_blank" href="exportdata/export_packingslip.php?category=<?php echo $category ?>" 
                       class="btn btn-label-secondary" ><i class="bx bx-import"></i>&nbsp;&nbsp;EXPORT
                    </a>            
                </td>
            </tr>
        </table> 
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="dt-select-table table table-bordered" id="mastertable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>#</th>
                        <th>#</th>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Category</th>
                        <th>So&nbsp;No</th>
                        <th>Po&nbsp;Number</th>
                        <th>Acknge</th>
                        <th>TimeLine</th>
                        <th>Urgent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($packingslip as $value) {
                        $so_no = $value["so_no"];
                        ?>
                        <tr>
                            <td><?php echo $index++ ?></td>
                            <td>
                                <a href="../roundwrap/download/packingslipakg/<?php echo $so_no ?>_acknowledgement.pdf" target="_blank">
                                    <i class="bx bx-printer" style="color: gray" title="PRINT PACKING SLIP"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" >
                                    <i class="bx bx-mail-send" style="color: gray" title="EMAIL PACKING SLIP"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#">
                                    <i class="bx bx-trash" style="color: gray" title="DELETE PACKING SLIP"></i>
                                </a>
                            </td>
                            <td class="break-me"><?php echo $value["cust_companyname"] ?></td>
                            <td><?php echo $value["sub_prof_id"] ?></td>
                            <td>
                                <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                    <?php echo $value["so_no"] ?>
                                </a>
                            </td>
                            <td  class="break-me"><?php echo $value["po_no"] ?></td>
                            <td>
                                <small>
                                    <?php echo GenericSetting::toggleMe(($value["ackrecv"] == "YES" ? "Y" : "N")) ?>
                                </small>
                            </td>
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

</div>
