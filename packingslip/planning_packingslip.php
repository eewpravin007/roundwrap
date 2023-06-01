<?php
$category = filter_input(INPUT_GET, "category");
$specific_date = filter_input(INPUT_GET, "specific_date");
$resultset = Production::createPlanning($category, $specific_date);
$keys = array_keys($resultset);
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
                    <a class="btn btn-label-secondary" ><i class="bx bx-printer"></i>&nbsp;&nbsp;PRINT</a>
                    &nbsp;
                    <a target="_blank" href="exportdata/export_packingslipplanning.php?category=<?php echo $category ?>" 
                       class="btn btn-label-secondary" ><i class="bx bx-import"></i>&nbsp;&nbsp;EXPORT
                    </a>            
                </td>
            </tr>
        </table> 
        <div style="overflow: auto;border-bottom: solid 1px #d4d8dd;border-top: solid 0px #d4d8dd">
            <?php
            foreach ($keys as $key) {
                $resultset_key = $resultset[$key];
                $tot_drs = getTotalDoorsFromKey($resultset_key);
                ?>

                <table class="dt-select-table table table-bordered" id="mastertable">
                    <thead>
                        <tr>
                            <td colspan="10" >
                                <?php echo $key ?>, Total Doors <?php echo $tot_drs ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 40px">#</th>
                            <th style="width: 40px">#</th>
                            <th style="width: 250px">Customer Name</th>
                            <th style="width: 150px">Category</th>
                            <th style="width: 150px">So&nbsp;No</th>
                            <th>Po&nbsp;Number</th>
                            <th style="width: 80px">Acknge</th>
                            <th style="width: 150px">TimeLine</th>
                            <th style="width: 80px">Urgent</th>
                            <th style="width: 250px">Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 1;
                        $total_doors = 0;
                        foreach ($resultset_key as $value) {
                            $so_no = $value["so_no"];
                            $total_doors = $total_doors + $value["total_pieces"];
                            ?>
                            <tr>
                                <td><?php echo $index++ ?></td>

                                <td>
                                    <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>" >
                                        <i class="bx bx-show" style="color: gray" title="EMAIL PACKING SLIP"></i>
                                    </a>
                                </td>
                                <td ><?php echo $value["cust_companyname"] ?></td>
                                <td><?php echo $value["sub_prof_id"] ?></td>
                                <td>
                                    <a href="index.php?pagename=main_dashboard&search_order=<?php echo $value["so_no"] ?>">
                                        <?php echo $value["so_no"] ?>
                                    </a>
                                </td>
                                <td  ><?php echo $value["po_no"] ?></td>
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
                                <td  ><?php echo $value["production_update"] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <br/>
                <?php
            }
            ?>
        </div>
    </div>

</div>

<?php

function getTotalDoorsFromKey($array) {
    $total_doors = 0;
    foreach ($array as $value) {
        $total_doors = $total_doors + $value["total_pieces"];
    }
    return $total_doors;
}
?>