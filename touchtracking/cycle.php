<?php
$category = filter_input(INPUT_GET, "category");

$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnSave"] == "Add Count") {
    unset($filter_input_array["btnSave"]);
    $filter_input_array["date"] = date("Y-m-d");
    MysqlConnection::insert("tbl_cycle_count", $filter_input_array);
    header("location:index.php?pagename=cycle&category=$category");
}

?>

<div class="card mb-12" >
    <h5 class="card-header"><b>Add Cycle Count</b></h5>
</div>
<br/>
<form name="frmTracking" id="frmTracking" method="POST">

    <div class="row gy-4">
        <div class="col-xl-4 col-lg-4 col-md-5 order-1 order-md-0">
            <div class="card mb-12">
                <br/>
                <center>
                    <table style="width: 90%;text-align: center">
                        <tr>
                            <td >
                                <h3>Cycle Count Number</h3>
                                <input type="text" name="count" required="" class="form-control" style="width: 100%;text-align: center;" autofocus="" placeholder="Enter cycle count">
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center">
                                <input type="submit" name="btnSave" class="btn btn-success" value="Add Count" style="font-weight: bold;font-size: 22px">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center">
                                <br/>
                                <a class="btn btn-gray" href="index.php?pagename=home&category=<?php echo $category ?>&station=<?php echo $wrokstation ?>" style="font-size: 10px">BACK</a>
                            </td>
                        </tr>
                    </table>
                </center>
                <br/>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-7 order-0 order-md-1">
            <div class="card mb-12">
                <table class="table table-bordered" id="mastertable">
                    <thead style="background-color: rgb(220,220,220);">
                        <tr style="">
                            <th style="width: 25px">#</th>
                            <th>Date</th>
                            <th>Count</th>
                            <th>Avg Day Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 1;
                        $avgcount = 0;
                        $trackingHistory = MysqlConnection::fetchCustom("SELECT *,"
                                        . " ( substring_index(date, ' ', 1) ) as date "
                                        . "FROM `tbl_cycle_count` ORDER BY date DESC");
                        
                        $prev = "";
                        $next = "";
                        
                        
                        foreach ($trackingHistory as $value) {
                            $avgcount = $avgcount + $value["count"];
                            
                            $prev = $trackingHistory[$index - 1]["count"];
                            $next = $trackingHistory[$index]["count"];
                            
                            ?>
                            <tr style="">
                                <td><?php echo $index ?></td>
                                <td><?php echo $value["date"] ?></td>
                                <td><?php echo $value["count"] ?></td>
                                <td><?php echo abs($prev - $next)?></td>
                            </tr>
                            <?php
                            $index++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>