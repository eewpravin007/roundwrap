<?php
$category = filter_input(INPUT_GET, "category");
$station = filter_input(INPUT_GET, "station");

$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnSave"] == "Search") {
    unset($filter_input_array["btnSave"]);
    $sono = $filter_input_array["count"];
    $shortPackingslip = Production::getShortPackingSLipBySo($sono);
}
if ($filter_input_array["btnProdIn"] == "ADD TO PRODUCTION IN") {
    MysqlConnection::printMe($filter_input_array);
    $ps_id[] = $filter_input_array["ps_id"];
    Production::putOrderInProdIn($ps_id );
    header("location:index.php?pagename=home&category=$category&station=$station");
}
?>

<div class="card mb-12" >
    <h5 class="card-header"><b>Add missing production order</b></h5>
</div>
<br/>
<form name="frmTracking" id="frmTracking" method="POST">
    <input type="hidden" name="ps_id" value="<?php echo $shortPackingslip["ps_id"] ?>">
    <div class="row gy-4">
        <div class="col-xl-4 col-lg-4 col-md-5 order-1 order-md-0">
            <div class="card mb-12">
                <br/>
                <center>
                    <table style="width: 90%;text-align: center">
                        <tr>
                            <td >
                                <h3>Search Sales Order Number</h3>
                                <input type="text" name="count" class="form-control" style="width: 100%;text-align: center;" autofocus="" placeholder="Enter so number">
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center">
                                <input type="submit" name="btnSave" class="btn btn-success" value="Search" style="font-weight: bold;font-size: 22px">
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
                    <tr style="">
                        <td>Customer Name</td>
                        <td><b><?php echo $shortPackingslip["cust_companyname"] ?></b></td>
                        <td>Po Number</td>
                        <td><b><?php echo $shortPackingslip["po_no"] ?></b></td>
                    </tr>
                    <tr style="">
                        <td>SO Number</td>
                        <td><b><?php echo $shortPackingslip["so_no"] ?></b></td>
                        <td>Profile</td>
                        <td><b><span class="badge bg-label-danger"><?php echo $shortPackingslip["sub_prof_id"] ?></span></b></td>
                    </tr>
                    <tr style="">
                        <td>Quantity</td>
                        <td><b><?php echo $shortPackingslip["total_pieces"] ?></b></td>
                        <td>Color</td>
                        <td><b><?php echo $shortPackingslip["color_name"] ?></b></td>
                    </tr>
                    <tr style="">
                        <td>Rush Order</td>
                        <td><b><span class="badge bg-label-<?php echo $shortPackingslip["isUrgent"] == "Y" ? "danger" : "success" ?>"><?php echo $shortPackingslip["isUrgent"] == "Y" ? "YES" : "NO" ?></span></b></td>
                        <td>Time Line</td>
                        <td><b><?php echo PackingSlip::deliveryLeft($shortPackingslip["daysLeft"]) ?></b></td>
                    </tr>
                    <tr style="">
                        <td>Last Update</td>
                        <td><b><?php echo $shortPackingslip["production_update"]?></b></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                    if ($shortPackingslip["so_no"] != "" && $shortPackingslip["production_update"] == "WORK ORDER CREATED") {
                        ?>
                        <tr>
                            <td colspan="4" style="text-align: center">
                                <input type="submit" name="btnProdIn" 
                                       class="btn btn-success" value="ADD TO PRODUCTION IN" 
                                       style="font-weight: bold;">
                            </td>
                        </tr>
                        <?php
                    }else{
                        echo "<tr><td colspan='4' style='text-align: center'><br/><h6 style=color:red;>Order already in production / work order not yet created</h6></td></tr>";
                    }
                    ?>
                </table>
                <br/>

            </div>
        </div>
    </div>
</form>