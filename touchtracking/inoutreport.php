<?php ?>

<div class="card mb-12" >
    <h5 class="card-header"><b>Monthly in out report</b></h5>
</div>
<br/>
<form name="frmTracking" id="frmTracking" method="POST">
    <div class="row gy-4">
        <div class="col-xl-12 col-lg-12 col-md-7 order-0 order-md-1">
            <div class="card mb-12">
                <table class="table table-bordered" id="mastertable">
                    <thead style="background-color: rgb(220,220,220);">
                        <tr style="">
                            <th style="width: 25px">#</th>
                            <th>Date</th>
                            <th>Total In</th>
                            <th>Total Out</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($index = 1; $index < 30; $index++) {
                            $date_current = date('Y-m-d', strtotime('today - ' . $index . ' days'));
                            $totalin = Production::getTrackingDashboardCounterBulk($category, "IN", $date_current);
                            $totalout = Production::getTrackingDashboardCounterBulk($category, "OUT", $date_current);
                            ?>
                            <tr style="">
                                <td><?php echo $index ?></td>
                                <td><?php echo $date_current ?></td>
                                <td><?php echo $totalin ?></td>
                                <td><?php echo $totalout ?></td>
                                <td><?php echo $totalin - $totalout ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>