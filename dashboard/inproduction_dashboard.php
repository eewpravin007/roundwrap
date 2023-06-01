<?php
$orderTimeLineInward = MainPageStatestic::orderTimeLineInProduction("");
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">RoundWrap Inward Orders, Total <?php echo count($orderTimeLineInward) ?> orders</h5>
    <div 
        class="card-datatable dataTable_select text-nowrap table-responsive" 
        style="max-height: 500px;overflow-y: auto;border-bottom: solid 1px #d4d8dd">
        <table class="dt-select-table table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>Customer Name</th>
                    <th>Category</th>
                    <th>So Number</th>
                    <th>Po Number</th>
                    <th>Delivery</th>
                    <th>Days Left</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($orderTimeLineInward as $value) {
                    ?>
                    <tr>
                        <td><?php echo $index++ ?></td>
                        <td class="break-me"><?php echo $value["cust_companyname"] ?></td>
                        <td><?php echo $value["prof_id"] . ", " . $value["sub_prof_id"] ?></td>
                        <td><?php echo $value["so_no"] ?></td>
                        <td  class="break-me"><?php echo $value["po_no"] ?></td>
                        <td><?php echo $value["req_date"] ?></td>
                        <td><?php echo PackingSlip::deliveryLeft($value["daysLeft"])  ?></td>
                        <td><?php echo PackingSlip::productionInStatus($value["production_update"]) ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <br/>
    <center>
        <center>
            <a href="#">
                <button type="button" class="btn btn-label-success"><span class="tf-icons bx bx-export"></span>&nbsp;Export</button>
            </a>
            &nbsp;
            <a href="#">
                <button type="button" class="btn btn-label-warning"><span class="tf-icons bx bx-printer"></span>&nbsp;Print</button>
            </a>
            &nbsp;
            <a href="index.php">
                <button type="button" class="btn btn-label-danger"><span class="tf-icons bx bx-left-arrow"></span>&nbsp;Back</button>
            </a>
        </center>
    </center>
    <br/>
</div>
