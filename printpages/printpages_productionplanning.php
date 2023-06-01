<?php
include '../MysqlConnection.php';
foreach (glob("../daoclass/*.php") as $filename) {
    include $filename;
}

$category = filter_input(INPUT_GET, "category");
$resultset = Production::createPlanning($category);
$keys = array_keys($resultset);
?>
<title>RoundWrap Report</title>
<script>
    window.print();
</script>
<style>
    @media print{
        @page {
            size: landscape
        }
    }
    table{
        width: 100%;
        border-collapse: collapse;
    }
    th, td{
        text-align: left;
        padding: 4px;
    }

</style>
<h3>Production behing report</h3>

<div style="overflow: auto;border-bottom: solid 1px #d4d8dd;border-top: solid 0px #d4d8dd">
    <?php
    $left_doors = 0;
    foreach ($keys as $key) {
        $resultset_key = $resultset[$key];
        $tot_drs = getTotalDoorsFromKey($resultset_key);
        $current_date = date("Y-m-d");
        $left_doors = $left_doors + $tot_drs;

        if ($current_date == $key) {
            ?>
            <div style="width: 100%;padding: 5px;border: solid 1px yellow;background-color: #FFFDBD">
                <b>Current day planning, you are <?php echo $left_doors ?> Doors behind from delivery</b>
            </div>
            <br/>
            <?php
            $left_doors = 0;
        }

        if ($tot_drs < 600) {
            $left_doors = "You can add " . (600 - $tot_drs) . " Doors to achive target";
        } else {
            $left_doors = "";
        }
        if ($time_diff > 0) {
            
        }
        ?>
        <table class="dt-select-table table table-bordered" id="mastertable">
            <thead>
                <tr>
                    <td colspan="10" >
                        <?php echo $key ?>, Total <?php echo $tot_drs ?> to make, <b><i><?php echo $left_doors ?> </i></b>
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